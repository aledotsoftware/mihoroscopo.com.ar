<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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

class SendDailyContentEmails extends Command
{
    protected $signature = 'send:daily-content-emails';
    protected $description = 'Send daily content update emails to users with authorized status or an upcoming payment date';
    protected $discordService;
    protected $logFileName;
    protected $logPath;

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
     
        // Inicializar el archivo de log
        file_put_contents($this->logPath, "Inicio del proceso: " . Carbon::now() . "\n", FILE_APPEND);

        // Fecha actual en formato 'dd/mm/yyyy'
        $date = Carbon::now()->format('d/m/Y');
        // Convertir la fecha al formato 'yyyy-mm-dd' para la consulta
        $dateForDatabase = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');

        $contentAstralGuide = ContentAstralGuide::where('date', $dateForDatabase)
            ->pluck('content', 'zodiac_sign') // Asegúrate de que 'zodiac_sign' es la columna correcta
            ->toArray();

        $contentDailyAstroAdvice = ContentDailyAstroAdvice::where('date', $dateForDatabase)
            ->pluck('content', 'zodiac_sign') // Asegúrate de que 'zodiac_sign' es la columna correcta
            ->toArray();

        $contentHoroscope = ContentHoroscope::where('date', $dateForDatabase)
            ->pluck('content', 'zodiac_sign') // Asegúrate de que 'zodiac_sign' es la columna correcta
            ->toArray();

        $contentLovePrediction = ContentLovePrediction::where('date', $dateForDatabase)
            ->pluck('content', 'zodiac_sign') // Asegúrate de que 'zodiac_sign' es la columna correcta
            ->toArray();

        $contentLoveRitual = ContentLoveRitual::where('date', $dateForDatabase)
            ->pluck('content', 'zodiac_sign') // Asegúrate de que 'zodiac_sign' es la columna correcta
            ->toArray();

        $contentLunarRitual = ContentLunarRitual::where('date', $dateForDatabase)
            ->pluck('content', 'zodiac_sign') // Asegúrate de que 'zodiac_sign' es la columna correcta
            ->toArray();
        $contentProsperityRitual = ContentProsperityRitual::where('date', $dateForDatabase)
            ->pluck('content', 'zodiac_sign') // Asegúrate de que 'zodiac_sign' es la columna correcta
            ->toArray();
        $contentZodiacCompatibility = ContentZodiacCompatibility::where('date', $dateForDatabase)
            ->pluck('content', 'zodiac_sign') // Asegúrate de que 'zodiac_sign' es la columna correcta
            ->toArray();

        $subscriptions = DB::table('subscriptions')
            ->where('status', 'authorized')
            ->get();

        // Contar las suscripciones encontradas
        $subscriptionCount = $subscriptions->count();
        file_put_contents($this->logPath, "Total de suscripciones encontradas: " . $subscriptionCount . "\n", FILE_APPEND);

        // Procesar cada suscripción
        foreach ($subscriptions as $subscription) {
            $timestamp = Carbon::now()->timestamp;
            // $unsubscribeLink = url('/unsubscribe/' . $subscription->subscription_id . '/' . $timestamp);

            // $unsubscribeLink =  'https://www.mercadopago.com.ar/subscriptions/v0/' . $subscription->subscription_id . '/admin';
            $unsubscribeLink =  'https://www.mihoroscopo.com.ar/subscription/preferences/' . $subscription->external_reference . '';
            $upgradeLink =  'https://www.mihoroscopo.com.ar/subscription/update/' . $subscription->external_reference . '';
            // $preferencesLink = url('/preferences/' . $subscription->subscription_id . '/' . $timestamp);
            $preferencesLink = url('https://mihoroscopo.com.ar/subscription/preferences/' . $subscription->external_reference);

            // file_put_contents($this->logPath, "Procesando suscripción ID: " . $subscription->subscription_id . " (Email: " . $subscription->email . ")\n" . "\n", FILE_APPEND);

            try {
                $extradataHoroscope = ExtradataHoroscope::where('subscription_id', $subscription->id)->first();

                if ($extradataHoroscope) {
                    $zodiacSign = $extradataHoroscope->signo;

                    // $content_horoscope = $contentHoroscope[$zodiacSign] ?? 'No hay predicción disponible';

                    // if (in_array($subscription->email, ['aleavellaneda1@gmail.com', 'santiagomediabilla@gmail.com'])) {
                    //  if (in_array($subscription->email, ['aleavellaneda1@gmail.com'])) {

                    // Crear un registro de EmailLog y recuperar el ID
                    $emailLog = EmailLog::create([
                        'subscription_id' => $subscription->id, // Asegúrate de que este ID sea correcto
                        'service_type' => 'horoscope',
                        'content_id' => array_search($zodiacSign, array_keys($contentHoroscope)),
                        'sent_at' => Carbon::now(),
                        'status' => 'sent' // Estado exitoso
                    ]);

                    // Incluir el ID del log en el contenido del correo
                    $content = [
                        'email_id' => $emailLog->id, // Usar el ID del registro de EmailLog
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
                        'upgrade_link' => $upgradeLink,
                        'unsubscribe_link' => $unsubscribeLink,
                        'preferences_link' => $preferencesLink,
                    ];

                    // Enviar el correo
                    Mail::to($subscription->email)->send(new \App\Mail\DailyContentEmail($content));
                    file_put_contents($this->logPath, "Envío exitoso para suscripción ID: " . $subscription->subscription_id . "\n" . "\n", FILE_APPEND);
                    // Loguear el contenido enviado de manera optimizada
                    // $logData = json_encode($content, JSON_PRETTY_PRINT);
                    // file_put_contents($this->logPath, $logData . "\n", FILE_APPEND);
                    //  }


                } else {
                    file_put_contents($this->logPath, "No se encontraron datos adicionales para la suscripción ID: " . $subscription->subscription_id . "\n" . "\n", FILE_APPEND);
                }
            } catch (\Exception $e) {
                // Loguear el estado del envío fallido en el archivo de log
                file_put_contents($this->logPath, "Error en el envío para suscripción ID: " . $subscription->subscription_id . ". Error: " . $e->getMessage() . "\n" . "\n", FILE_APPEND);

                // Registrar el fallo en EmailLog
                EmailLog::create([
                    'subscription_id' => $subscription->id,
                    'service_type' => 'horoscope',
                    'content_id' => array_search($zodiacSign ?? null, array_keys($contentHoroscope)), // 'null' si no hay signo disponible
                    'sent_at' => Carbon::now(),
                    'status' => 'failed' // Estado de fallo
                ]);
            }
        }

        // Enviar log a Discord al final del proceso
        $this->sendLogToDiscord($subscriptionCount);
    }

    protected function sendLogToDiscord($subscriptionCount)
    {
        $logUrl = url('logs/' . $this->logFileName);

        // Enviar el resumen y el enlace del log a Discord
        $this->discordService->sendDiscordMessage(
            "Resumen del envío de correos:\n" .
                "Total de suscripciones procesadas: " . $subscriptionCount . "\n" .
                "Ver el log completo: " . $logUrl
        );
    }
}
