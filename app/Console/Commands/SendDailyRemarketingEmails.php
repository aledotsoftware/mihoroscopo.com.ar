<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Services\DiscordService;
use App\Models\EmailLog;

class SendDailyRemarketingEmails extends Command
{
    protected $signature = 'send:daily-remarketing-emails';
    protected $description = 'Send daily content update emails to users with authorized status or an upcoming payment date';
    protected $discordService;
    protected $logFileName;
    protected $logPath;

    public function __construct()
    {
        parent::__construct();

        $this->discordService = new DiscordService(1);  // ID del bot
        $this->logFileName = 'SendDailyRemarketingEmails_' . Carbon::now()->format('Ymd_His') . '.log';
        $this->logPath = public_path('logs/' . $this->logFileName);

        // Crear directorio de logs si no existe
        if (!file_exists(public_path('logs'))) {
            mkdir(public_path('logs'), 0755, true);
        }
    }

    public function handle()
    {
        // Inicializar log
        $this->logMessage("Inicio del proceso");

        // Fecha actual
        $date = Carbon::now()->format('d/m/Y');
        $dateForDatabase = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');

        // ⚡ Bolt: Memory optimization.
        // What: Replaced ->get() with ->chunkById() to process pending subscriptions in batches of 100.
        // Why: Loading all pending subscriptions into memory at once with get() causes massive memory overhead
        //      when the table is large, often leading to OOM (Out Of Memory) exceptions on the server.
        //      chunkById() is used instead of chunk() to prevent skipping records if the processed records
        //      are mutated (which would change their position in the result set when using LIMIT/OFFSET).
        // Impact: Reduces memory usage exponentially from O(N) to O(1) where N is the number of records.
        $query = DB::table('subscriptions')
            ->where('status', 'pending')
            ->whereBetween('created_at', [
                Carbon::now()->subDays(3)->startOfDay(),  // Inicio de hace 3 días
                Carbon::now()->endOfDay()  // Final del día de hoy
            ]);

        // ⚡ Bolt: Database query optimization.
        // What: Removed the initial `$query->count()` database query and replaced it with a running counter.
        // Why: An initial `COUNT(*)` query performs a full scan over matching records, blocking until the total
        //      is evaluated. This is an unnecessary bottleneck when iterating via chunking over the dataset anyway.
        // Impact: Completely eliminates an extra heavy query per command execution, improving processing speed and database resources.
        $subscriptionCount = 0;

        // Procesar cada suscripción en fragmentos para ahorrar memoria
        // Se usa chunkById en lugar de chunk para evitar saltarse registros si el estado cambia durante el procesamiento.
        $query->chunkById(100, function ($subscriptions) use ($date, &$subscriptionCount) {
            $subscriptionCount += count($subscriptions);
            foreach ($subscriptions as $subscription) {
                // if ($subscription->email === 'ayackbrea@gmail.com') {
                $this->processSubscription($subscription, $date);
                // }
            }
        });

        $this->logMessage("Total de suscripciones encontradas y procesadas: $subscriptionCount");

        // Enviar log a Discord
        $this->sendLogToDiscord($subscriptionCount);
    }

    protected function processSubscription($subscription, $date)
    {
        $this->logMessage("Procesando suscripción ID: {$subscription->subscription_id} (Email: {$subscription->email})");

        try {
            // // Crear registro de EmailLog
            $emailLog = EmailLog::create([
                'subscription_id' => $subscription->id,
                'service_type' => 'horoscope',
                'content_id' => 0,
                'sent_at' => Carbon::now(),
                'status' => 'sent'
            ]);

            // Contenido del correo
            $content = [
                'email_id' => $emailLog->id,
                'name' => 'Todo bien',
                'payment_link' => "https://www.mercadopago.com.ar/subscriptions/checkout?preapproval_id={$subscription->subscription_id}"
            ];


            // Enviar el correo
           // Mail::to($subscription->email)->send(new \App\Mail\DailyRemarketingEmail($content));

            // Loguear contenido enviado
            $this->logMessage(json_encode($content, JSON_PRETTY_PRINT));
            $this->logMessage("Envío exitoso para suscripción ID: {$subscription->subscription_id}");
        } catch (\Exception $e) {
            // Loguear error
            $this->logMessage("Error en el envío para suscripción ID: {$subscription->subscription_id}. Error: " . $e->getMessage());
        }
    }

    protected function sendLogToDiscord($subscriptionCount)
    {
        $logUrl = url('logs/' . $this->logFileName);
        $message = "Resumen del envío de correos:\nTotal de suscripciones procesadas: $subscriptionCount\nVer el log completo: $logUrl";
        $this->discordService->sendDiscordMessage($message);
    }

    protected function logMessage($message)
    {
        file_put_contents($this->logPath, Carbon::now() . " - $message\n", FILE_APPEND);
    }
}
