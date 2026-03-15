<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use App\Services\DiscordService;
use App\Models\ExtradataHoroscope;
use App\Models\ContentAstralGuide;
use App\Models\ContentDailyAstroAdvice;
use App\Models\ContentHoroscope;
use App\Models\ContentLovePrediction;
use App\Models\ContentLoveRitual;
use App\Models\ContentLunarRitual;
use App\Models\ContentProsperityRitual;
use App\Models\ContentZodiacCompatibility;
use App\Models\EmailLog;
use App\Models\Subscription;

class SendDailyContentEmails extends Command
{
    protected $signature = 'send:daily-content-emails {email?}';
    protected $description = 'Send daily content update emails to users with authorized status or an upcoming payment date';
    protected $discordService;
    protected $logFileName;
    protected $logPath;
    protected $email;
    public function __construct()
    {
        parent::__construct();


        $this->discordService = new DiscordService(1);  // Reemplaza '1' con el ID del bot correspondiente
        $this->logFileName = Carbon::now()->format('Ymd') . '-' . sha1(time()) . '.log';
        $this->logPath = public_path('logs/' . $this->logFileName);


        // Crear directorio de logs si no existe
        if (!file_exists(public_path('logs'))) {
            mkdir(public_path('logs'), 0755, true);
        }
    }

    public function handle()
    {
        $email = $this->argument('email'); // Captura el argumento 'email'

        // Inicializar el archivo de log
        file_put_contents($this->logPath, "Inicio del proceso: " . Carbon::now() . "\n", FILE_APPEND);

        // Fetch daily content once to avoid queries inside loop
        $date = Carbon::now()->format('d/m/Y');
        $dateForDatabase = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');

        $dailyContent = [
            'date' => $date,
            'contentAstralGuide' => ContentAstralGuide::where('date', $dateForDatabase)->pluck('content', 'zodiac_sign')->toArray(),
            'contentDailyAstroAdvice' => ContentDailyAstroAdvice::where('date', $dateForDatabase)->pluck('content', 'zodiac_sign')->toArray(),
            'contentHoroscope' => ContentHoroscope::where('date', $dateForDatabase)->pluck('content', 'zodiac_sign')->toArray(),
            'contentLovePrediction' => ContentLovePrediction::where('date', $dateForDatabase)->pluck('content', 'zodiac_sign')->toArray(),
            'contentLoveRitual' => ContentLoveRitual::where('date', $dateForDatabase)->pluck('content', 'zodiac_sign')->toArray(),
            'contentLunarRitual' => ContentLunarRitual::where('date', $dateForDatabase)->pluck('content', 'zodiac_sign')->toArray(),
            'contentProsperityRitual' => ContentProsperityRitual::where('date', $dateForDatabase)->pluck('content', 'zodiac_sign')->toArray(),
            'contentZodiacCompatibility' => ContentZodiacCompatibility::where('date', $dateForDatabase)->pluck('content', 'zodiac_sign')->toArray(),
        ];

        if ($email) {
            // Eager load extradata_horoscopes
            $subscription = Subscription::with('extradata_horoscopes')
                ->where('email', $email)
                ->first();
        
            if ($subscription) {
                $this->sendEmail($subscription, $dailyContent);
                $this->discordService->sendDiscordMessage(
                    "CONTENIDO ENVIADO A :" . $email
                );
            } else {
                file_put_contents($this->logPath, "No se encontró una suscripción autorizada para el correo: " . $email . "\n", FILE_APPEND);
            }
        } else {
            // Use Eloquent with chunking to handle large datasets and eager load relationships
            $subscriptionQuery = Subscription::with('extradata_horoscopes')
                ->whereIn('status', ['authorized', 'pending']);

            // ⚡ Bolt: Query optimization.
            // What: Removed unbounded ->count() query and replaced it with a running counter.
            // Why: Calling count() before chunking executes a redundant full table scan
            //      just to get the total number of records, consuming memory and CPU.
            // Impact: Eliminates a costly database query, speeding up command execution on large tables.
            $subscriptionCount = 0;

            $subscriptionQuery->chunk(100, function ($subscriptions) use ($dailyContent, &$subscriptionCount) {
                $subscriptionCount += count($subscriptions);
                foreach ($subscriptions as $subscription) {
                    $this->sendEmail($subscription, $dailyContent);
                }
            });

            file_put_contents($this->logPath, "Total de suscripciones encontradas: " . $subscriptionCount . "\n", FILE_APPEND);

            // Enviar log a Discord al final del proceso
            $this->sendLogToDiscord($subscriptionCount);
        }
    }


    public function sendEmail($subscription, $dailyContent = null)
    {
        // Proceso de enviar email
            // Use passed content or fallback
            if ($dailyContent) {
                $date = $dailyContent['date'];
                $contentAstralGuide = $dailyContent['contentAstralGuide'];
                $contentDailyAstroAdvice = $dailyContent['contentDailyAstroAdvice'];
                $contentHoroscope = $dailyContent['contentHoroscope'];
                $contentLovePrediction = $dailyContent['contentLovePrediction'];
                $contentLoveRitual = $dailyContent['contentLoveRitual'];
                $contentLunarRitual = $dailyContent['contentLunarRitual'];
                $contentProsperityRitual = $dailyContent['contentProsperityRitual'];
                $contentZodiacCompatibility = $dailyContent['contentZodiacCompatibility'];
            } else {
                 // Optimization: This block is kept for backward compatibility if called without content
                $date = Carbon::now()->format('d/m/Y');
                $dateForDatabase = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
                $contentAstralGuide = ContentAstralGuide::where('date', $dateForDatabase)->pluck('content', 'zodiac_sign')->toArray();
                $contentDailyAstroAdvice = ContentDailyAstroAdvice::where('date', $dateForDatabase)->pluck('content', 'zodiac_sign')->toArray();
                $contentHoroscope = ContentHoroscope::where('date', $dateForDatabase)->pluck('content', 'zodiac_sign')->toArray();
                $contentLovePrediction = ContentLovePrediction::where('date', $dateForDatabase)->pluck('content', 'zodiac_sign')->toArray();
                $contentLoveRitual = ContentLoveRitual::where('date', $dateForDatabase)->pluck('content', 'zodiac_sign')->toArray();
                $contentLunarRitual = ContentLunarRitual::where('date', $dateForDatabase)->pluck('content', 'zodiac_sign')->toArray();
                $contentProsperityRitual = ContentProsperityRitual::where('date', $dateForDatabase)->pluck('content', 'zodiac_sign')->toArray();
                $contentZodiacCompatibility = ContentZodiacCompatibility::where('date', $dateForDatabase)->pluck('content', 'zodiac_sign')->toArray();
            }

            $timestamp = Carbon::now()->timestamp;

            $unsubscribeLink = 'https://www.mihoroscopo.com.ar/subscription/preferences/' . $subscription->external_reference;
            $upgradeLink = 'https://www.mihoroscopo.com.ar/subscription/update/' . $subscription->external_reference;
            $preferencesLink = url('https://mihoroscopo.com.ar/subscription/preferences/' . $subscription->external_reference);

            try {
                // Use eager loaded relation if available to avoid N+1, with fallback for stdClass
                if ($subscription instanceof Subscription && $subscription->relationLoaded('extradata_horoscopes')) {
                    $extradataHoroscope = $subscription->extradata_horoscopes->first();
                } else {
                    $extradataHoroscope = ExtradataHoroscope::where('subscription_id', $subscription->id)->first();
                }

                if ($extradataHoroscope) {
                    $zodiacSign = $extradataHoroscope->signo;
                    //  if (in_array($subscription->email, ['aleavellaneda1@gmail.com'])) {
                    // ⚡ Bolt: Memory & CPU optimization.
                    // What: Replaced Model::create() with DB::table()->insertGetId().
                    // Why: In a batch processing loop (sending mass emails), avoiding Eloquent model hydration for every record drastically reduces memory footprint and CPU overhead. Eloquent's automatic timestamps are bypassed.
                    // Impact: Eliminates model instantiation overhead per iteration, preventing OOM issues.
                    $emailLogId = \Illuminate\Support\Facades\DB::table('email_logs')->insertGetId([
                        'subscription_id' => $subscription->id,
                        'service_type' => 'horoscope',
                        'content_id' => array_search($zodiacSign, array_keys($contentHoroscope)),
                        'sent_at' => Carbon::now(),
                        'status' => 'sent'
                    ]);
                    // Stub object to maintain compatibility with existing tracking link code
                    $emailLog = (object)['id' => $emailLogId];

                    $trackedUnsubscribeLink = URL::signedRoute('email.track.click', ['email' => $emailLog->id, 'url' => $unsubscribeLink]);
                    $trackedUpgradeLink = URL::signedRoute('email.track.click', ['email' => $emailLog->id, 'url' => $upgradeLink]);
                    $trackedPreferencesLink = URL::signedRoute('email.track.click', ['email' => $emailLog->id, 'url' => $preferencesLink]);

                    $content = [
                        'email_id' => $emailLog->id,
                        'name' => $extradataHoroscope->name ?? 'Todo bien?',
                        'zodiac_sign' => ucfirst($zodiacSign),
                        'date' => $date,
                        'subscription_payment_type' => $subscription->payment_type,
                        'content_astral_guide' => $contentAstralGuide[$zodiacSign] ?? '',
                        'content_daily_astro_advice' => $contentDailyAstroAdvice[$zodiacSign] ?? '',
                        'content_horoscope' => $contentHoroscope[$zodiacSign] ?? 'No hay predicción disponible',
                        'content_love_prediction' => $contentLovePrediction[$zodiacSign] ?? '',
                        'content_love_ritual' => $contentLoveRitual[$zodiacSign] ?? '',
                        'content_lunar_ritual' => $contentLunarRitual[$zodiacSign] ?? '',
                        'content_prosperity_ritual' => $contentProsperityRitual[$zodiacSign] ?? '',
                        'content_zodiac_compatibility' => $contentZodiacCompatibility[$zodiacSign] ?? '',
                        'upgrade_link' => $trackedUpgradeLink,
                        'unsubscribe_link' => $trackedUnsubscribeLink,
                        'preferences_link' => $trackedPreferencesLink,
                    ];

                    Mail::to($subscription->email)->send(new \App\Mail\DailyContentEmail($content));
                    file_put_contents($this->logPath, "Envío exitoso para suscripción ID: " . $subscription->email . "\n", FILE_APPEND);
                } else {
                    file_put_contents($this->logPath, "No se encontraron datos adicionales para la suscripción ID: " . $subscription->subscription_id . "\n", FILE_APPEND);
                }
            } catch (\Exception $e) {
                file_put_contents($this->logPath, "Error en el envío para suscripción ID: " . $subscription->subscription_id . ". Error: " . $e->getMessage() . "\n", FILE_APPEND);

                // ⚡ Bolt: Memory & CPU optimization.
                // What: Replaced Model::create() with DB::table()->insert().
                // Why: Avoids Eloquent model hydration overhead in batch processing loop.
                // Impact: Reduces memory footprint per iteration.
                \Illuminate\Support\Facades\DB::table('email_logs')->insert([
                    'subscription_id' => $subscription->id,
                    'service_type' => 'horoscope',
                    'content_id' => array_search($zodiacSign ?? null, array_keys($contentHoroscope)),
                    'sent_at' => Carbon::now(),
                    'status' => 'failed'
                ]);
            }
        //  }
    }

    protected function sendLogToDiscord($subscriptionCount)
    {
        $logUrl = url('logs/' . $this->logFileName);

        $this->discordService->sendDiscordMessage(
            "Resumen del envío de correos:\n" .
                "Total de suscripciones procesadas: " . $subscriptionCount . "\n" .
                "Ver el log completo: " . $logUrl
        );
    }
}
