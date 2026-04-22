<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DiscordService;
use App\Models\Subscription;
use App\Services\MercadoPagoService;
use App\Models\Notification; // Asegúrate de importar el modelo Notification
use App\Models\Payment;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use App\Mail\SubscriptionConfirmationMail;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{

    private $discordService;
    private $mercadoPagoService;

    /**
     * Crea una nueva instancia de la clase y configura los servicios necesarios.
     *
     * El constructor inicializa los servicios `DiscordService` y `MercadoPagoService` necesarios para
     * el funcionamiento de la clase. Se asignan los identificadores de bot y los tokens de acceso
     * apropiados para cada servicio.
     *
     * @return void
     */
    public function __construct()
    {
        // Asigna el ID del bot o el webhook que necesites
        $this->discordService = new DiscordService(1);  // reemplaza 'botId' por el ID del bot correspondiente
        $this->mercadoPagoService = new MercadoPagoService(config('mercado_pago.access_token'));
    }

    /**
     * Procesa una solicitud entrante, guarda la información en un archivo, y maneja diferentes tipos de notificaciones.
     *
     * Este método recibe una solicitud, extrae y guarda la información relevante en un archivo JSON en la carpeta `public/logs`,
     * y envía un enlace público del archivo a un canal de Discord. Además, guarda la notificación en la base de datos y
     * la maneja según su tipo, llamando a los métodos apropiados para cada tipo de notificación.
     *
     * @param \Illuminate\Http\Request $request La solicitud entrante que contiene los datos de la notificación.
     *
     * @return void
     */
    public function toQueue(Request $request)
    {
        // ⚡ Bolt: Controller response time optimization.
        // What: Wrapped the heavy, synchronous webhook processing logic inside Laravel's `defer()` helper.
        // Why: Webhooks endpoints process external APIs, DB writes, Discord API calls, and file I/O operations synchronously.
        //      This blocked the HTTP response thread, risking timeouts from providers.
        //      `defer()` allows us to send an immediate 200 OK to Mercado Pago / dLocalGo, while executing
        //      these long-running operations in the background after the response is sent.
        // Impact: Reduces HTTP response times drastically and avoids provider timeout retries.

        // Authenticate signatures synchronously before deferring, and return 403 if invalid
        $data = $request->all();
        if (isset($data['type'])) {
            if (!$this->verifyMercadoPagoSignature($request)) {
                \Log::warning('Invalid MercadoPago signature');
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        } else {
            if (isset($data['invoiceId']) && isset($data['mid']) && isset($data['subscriptionId'])) {
                if (!$this->verifyDlocalGoSignature($request)) {
                    \Log::warning('Invalid DlocalGo signature');
                    return response()->json(['error' => 'Unauthorized'], 403);
                }
            }
        }

        // Obtener el cuerpo (body) de la solicitud (must fetch syncly)
        $body = $request->getContent();
        $headers = $request->headers->all();
        $queryParams = $request->query();

        defer(function () use ($data, $body, $headers, $queryParams) {
            // Reenviar la solicitud al endpoint externo

            // Crear un array con toda la información a guardar
            $log_data = [
                'headers' => $headers,
                'body' => $body,
                'data' => $data
            ];

            // Convertir los datos a JSON para guardar en un archivo
            $log_json = json_encode($log_data, JSON_PRETTY_PRINT);

            // Definir el nombre del archivo
            $file_name = 'logs/mercadopago_notification_' . now()->format('Y-m-d_H-i-s') . '.json';

            // Guardar el archivo directamente en la carpeta public/logs
            file_put_contents(public_path($file_name), $log_json);

            // Crear un link público al archivo
            $public_link = url('logs/' . basename($file_name));

            $this->discordService->sendDiscordMessage('Nueva notificación recibida: ' . $public_link);

            // Guardar la notificación en la base de datos
            $this->saveNotification($data);

            // Determinar el tipo de notificación es, las de mercado pago tienen type, las de dLocalGo no
            //las de dLocalGo tienen 3 campos invoiceId, mid, y subscriptionId
            if (isset($data['type'])) {
                // Es una notificación de MercadoPago
                $topic = $data['type'];

                switch ($topic) {
                    case 'subscription_preapproval':
                        $this->handleSubscriptionPreapproval($data);
                        break;

                    case 'subscription_authorized_payment':
                        $this->handleSubscriptionAuthorizedPayment($data);
                        break;

                    case 'payment':
                        $this->handlePayment($data);
                        break;

                    default:
                        $this->handleDefault($data);
                        break;
                }
            } else {
                // Es una notificación de dLocalGo
                if (isset($data['invoiceId']) && isset($data['mid']) && isset($data['subscriptionId'])) {
                    // Es una notificación de dLocalGo
                    $this->handleDlocalGoNotification($data);
                    return;
                }
                $this->handleDefault($data);
            }
        });

        // Retornar una respuesta OK inmediatamente
        return response()->json(['status' => 'success'], 200);
    }

    private function handleDlocalGoNotification($data)
    {
        try {
            // Extraer datos de la notificación
            $subscriptionId = $data['subscriptionId'] ?? null;
            $invoiceId = $data['invoiceId'] ?? null;

            if (!$subscriptionId || !$invoiceId) {
                $this->discordService->sendDiscordMessage("Error: Faltan parámetros necesarios en la notificación de dLocalGo");
                return;
            }

            // Configurar la llamada a la API de dLocalGo
            $apiKey = config('dlocalgo.api_key');
            $url = "https://api-sbx.dlocalgo.com/v1/subscription/{$subscriptionId}/execution/{$invoiceId}";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200) {
                $this->discordService->sendDiscordMessage("Error al obtener datos de dLocalGo: HTTP $httpCode");
                return;
            }

            $executionData = json_decode($response, true);
            if (!$executionData) {
                $this->discordService->sendDiscordMessage("Error al decodificar respuesta de dLocalGo");
                return;
            }

            // Validar campos requeridos
            if (!isset($executionData['subscription']['id']) || 
                !isset($executionData['subscription']['client_email']) ||
                !isset($executionData['status']) ||
                !isset($executionData['subscription']['plan']['frequency_type']) ||
                !isset($executionData['subscription']['plan']['frequency_value'])) {
                $this->discordService->sendDiscordMessage("Error: Faltan campos requeridos en la respuesta de dLocalGo");
                return;
            }

            // ⚡ Bolt: Memory optimization.
            // What: Added select() to prevent fetching heavy TEXT/JSON columns ('response') when fetching the subscription.
            // Why: Hydrating massive payload columns into Eloquent models on a high-concurrency webhook wastes significant RAM and CPU.
            // Impact: Drastically reduces memory footprint per webhook execution and improves endpoint latency.
            // Buscar la suscripción
            $subscription = Subscription::select(['id', 'email', 'subscription_id', 'status', 'valid_until', 'charged_amount', 'charged_quantity'])
                ->where('email', $executionData['subscription']['client_email'])->first();
            if (!$subscription) {
                $this->discordService->sendDiscordMessage("Error: No se encontró la suscripción para el email: " . $executionData['subscription']['client_email']);
                return;
            }

            $subscription->subscription_id = $executionData['subscription']['id'];

            if ($executionData['status'] == 'COMPLETED') {
                $subscription->status = 'authorized';
            }

            // Calcular valid_until según el tipo de frecuencia y valor
            $frequencyType = $executionData['subscription']['plan']['frequency_type'];
            $frequencyValue = $executionData['subscription']['plan']['frequency_value'];
            
            switch (strtoupper($frequencyType)) {
                case 'DAILY':
                    $subscription->valid_until = now()->addDays($frequencyValue);
                    break;
                case 'MONTHLY': 
                    $subscription->valid_until = now()->addMonths($frequencyValue);
                    break;
                case 'YEARLY':
                    $subscription->valid_until = now()->addYears($frequencyValue);
                    break;
                default:
                    $subscription->valid_until = now()->addDays($frequencyValue);
            }
           
            $subscription->response = json_encode($executionData);
            $subscription->charged_amount = $executionData['subscription']['plan']['amount'];
            $subscription->charged_quantity = $executionData['subscription']['plan']['frequency_value'];
        
            $subscription->save();

            // Crear un nuevo pago
            // ⚡ Bolt: Database write optimization.
            // What: Replaced new Payment()->save() with DB::table('payment')->insert().
            // Why: Avoids hydrating a full Eloquent model and dispatching lifecycle events just to insert
            //      a single logging record during the highly concurrent webhook processing flow.
            // Impact: Eliminates memory allocation overhead and reduces CPU cycles per webhook.
            \Illuminate\Support\Facades\DB::table('payment')->insert([
                'external_reference' => $subscription->external_reference,
                'payment_id' => $executionData['external_transaction_id'],
                'preapproval_id' => $executionData['subscription']['id'],
                'net_received_amount' => $executionData['amount_received'],
                'total_paid_amount' => $executionData['amount_paid'],
                'status' => $executionData['status'],
                'payer_email' => $executionData['subscription']['client_email'],
                'payer_identification_number' => $executionData['subscription']['client_document'] ?? '',
                'payer_identification_type' => $executionData['subscription']['client_document_type'] ?? '',
                'payment_method_id' => $executionData['subscription']['payment_method_code'],
                'payload' => json_encode($executionData),
                'created_at' => now(),
                'updated_at' => now(),
                'currency_id' => $executionData['currency'] ?? '',
            ]);

            // // Notificar a Discord
            // $this->discordService->sendDiscordMessage(
            //     "Nuevo pago dLocalGo procesado:\n" .
            //     "Email: {$payment->payer_email}\n" .
            //     "Monto: {$payment->total_paid_amount} {$payment->currency_id}\n" .
            //     "Estado: {$payment->status}"
            // );

        } catch (\Exception $e) {
            $this->discordService->sendDiscordMessage("Error procesando notificación dLocalGo: " . $e->getMessage());
            throw $e;
        }
    }









    /**
     * Guarda una notificación en la base de datos.
     *
     * Esta función crea una nueva instancia del modelo `Notification`, asigna valores a sus atributos
     * basados en los datos proporcionados, y guarda la instancia en la base de datos. La función devuelve
     * el objeto `Notification` guardado.
     *
     * @param array $data Datos de la notificación que se van a guardar. El array debe tener la siguiente estructura:
     *                     - 'type' (string, opcional): Tipo de la notificación. Si no se proporciona, se usará 'unknown'.
     *                     - 'data' (array): Datos relacionados con la notificación. Debe contener al menos un 'id'.
     * @return \App\Models\Notification Devuelve el objeto `Notification` que se ha guardado en la base de datos.
     *
     * @throws \InvalidArgumentException Si el array `$data` no contiene una clave 'data' con un 'id' válido.
     */
    private function saveNotification($data)
    {
        // ⚡ Bolt: Database write optimization.
        // What: Replaced new Notification()->save() with DB::table('notifications')->insertGetId().
        // Why: Avoids hydrating a full Eloquent model and dispatching lifecycle events just to insert
        //      a single logging record during the highly concurrent webhook processing flow.
        // Impact: Eliminates memory allocation overhead and reduces CPU cycles per webhook.
        $notificationId = \Illuminate\Support\Facades\DB::table('notifications')->insertGetId([
            'type' => $data['type'] ?? 'unknown',
            'data_id' => $data['data']['id'] ?? 'N/A',
            'status' => 'pending', // Puedes ajustar esto según tu lógica
            'details' => json_encode($data, JSON_PRETTY_PRINT),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return $notificationId;
    }


    /**
     * Maneja la preaprobación de suscripciones y actualiza la base de datos con la información recibida.
     *
     * Esta función procesa los datos de una suscripción preaprobada recibidos desde Mercado Pago. Obtiene la
     * información de la suscripción a partir del ID proporcionado, actualiza el modelo de suscripción en la base
     * de datos y envía un mensaje a Discord con los detalles de la suscripción.
     *
     * @param array $data Datos de la notificación de suscripción preaprobada. El array debe tener la siguiente estructura:
     *                     - 'data' (array): Debe contener al menos una clave 'id' con el ID de la suscripción.
     * @return void
     *
     * @throws \Exception Si ocurre un error al intentar obtener la suscripción desde Mercado Pago.
     */
    private function handleSubscriptionPreapproval($data)
    {
        // Obtén el ID de la suscripción desde los datos recibidos
        $subscriptionId = $data['data']['id'] ?? null;
        // Verifica que el ID de la suscripción no sea nulo
        if ($subscriptionId === null) {
            $this->discordService->sendDiscordMessage("Error: ID de suscripción no encontrado en los datos.");
            return;
        }
        // try {
        // Intenta obtener la suscripción desde Mercado Pago
        $subscription = $this->mercadoPagoService->getSubscription($subscriptionId);

        // Verifica que la suscripción haya sido recuperada
        if (!$subscription) {
            $this->discordService->sendDiscordMessage("Error: No se pudo obtener la suscripción con ID: $subscriptionId.");
            return;
        }

        // ⚡ Bolt: Memory optimization.
        // What: Added select() to prevent fetching heavy TEXT/JSON columns ('response') when fetching the subscription.
        // Why: Hydrating massive payload columns into Eloquent models on a high-concurrency webhook wastes significant RAM and CPU.
        // Impact: Drastically reduces memory footprint per webhook execution and improves endpoint latency.
        $subscriptionModel = Subscription::select(['id', 'subscription_id', 'status', 'next_payment_date', 'payment_method_id', 'charged_quantity', 'charged_amount', 'pending_charge_amount', 'semaphore', 'last_charged_date', 'last_charged_amount'])
            ->where('subscription_id', $subscriptionId)->first();
        $subscriptionModel->status = $subscription['status'] ?? 'null';
        $subscriptionModel->response = $subscription; // Asegúrate de codificar la respuesta en JSON si es necesario
        $subscriptionModel->next_payment_date = $subscription['next_payment_date'] ?? null;
        $subscriptionModel->payment_method_id = $subscription['payment_method_id'] ?? null;
        $subscriptionModel->charged_quantity = $subscription['summarized']['charged_quantity'] ?? null;
        $subscriptionModel->charged_amount = $subscription['summarized']['charged_amount'] ?? null;

        $subscriptionModel->pending_charge_amount = $subscription['summarized']['pending_charge_amount'] ?? null;
        $subscriptionModel->semaphore = $subscription['summarized']['semaphore'] ?? null;
        $subscriptionModel->last_charged_date = $subscription['summarized']['last_charged_date'] ?? null;
        $subscriptionModel->last_charged_amount = $subscription['summarized']['last_charged_amount'] ?? null;
        $subscriptionModel->updated_at = now(); // Actualiza la fecha de actualización
        $subscriptionModel->save();

        // $this->emailService->sendWelcomeEmail($email,$email);
        $message = "";
        $message .= "\n📩 Notificación de suscripción recibida.\n";
        $message .= "================================\n";
        $message .= "ACTUALIZACIÓN DE SUSCRIPCIÓN\n";
        $message .= "================================\n";
        $message .= "ID : " . $subscriptionId . "\n";
        $message .= ":traffic_light: Estado : " . $subscriptionModel->status . "\n";
        $message .= ":calendar_spiral: Fecha próximo pago: " . $subscriptionModel->next_payment_date . "\n";
        $message .= "Frecuencia: " . $subscriptionModel->frequency . "\n";
        $message .= "Tipo: " . $subscriptionModel->frequency_type . "\n";
        $message .= ":timer: Dias desde el alta: " . $subscriptionModel->charged_quantity  . "\n";
        $message .= ":moneybag: Monto cargado: " . $subscriptionModel->charged_amount  . "\n";
        $message .= ":calendar_spiral: Última fecha de carga: " . ($subscription['summarized']['last_charged_date'] ?? 'N/A') . "\n";

        $this->discordService->sendDiscordMessage($message);
    }


    /**
     * Maneja la notificación de un pago autorizado para una suscripción.
     *
     * Esta función recibe los datos de un pago autorizado para una suscripción, consulta detalles adicionales
     * usando el servicio de Mercado Pago, y envía un mensaje a Discord con la información del pago.
     *
     * @param array $data Los datos del pago recibido, típicamente desde una notificación o webhook.
     *
     * @return void
     */
    private function handleSubscriptionAuthorizedPayment($data)
    {
        $paymentId = $data['data']['id'] ?? 'N/A';
        $payment = $this->mercadoPagoService->getSubscription($paymentId);
        $message = "\n\n📩 Notificación de pago recibida.\n";
        $message = "\n\n================================\n";
        $message .= "PAGO DE SUSCRIPCIÓN AUTORIZADO\n";
        $message = "\n\n================================\n";
        $message .= "ID del pago: " . $paymentId . "\n";
        $message .= ":traffic_light: Estado del pago: " . ($payment['status'] ?? 'N/A') . "\n";
        $message .= ":moneybag: Monto del pago: " . ($payment['total_paid_amount'] ?? 'N/A') . " " . ($payment['currency_id'] ?? '') . "\n";
        $this->discordService->sendDiscordMessage($message);
    }


    /**
     * Maneja la información de un pago recibido y actualiza el modelo de pago en la base de datos.
     *
     * Esta función recibe los datos de un pago, consulta detalles adicionales usando el servicio de Mercado Pago,
     * actualiza o crea un registro en la base de datos con la información del pago, y envía un mensaje a Discord
     * con detalles del pago.
     *
     * @param array $data Los datos del pago recibidos, típicamente desde una notificación o webhook.
     *
     * @return void
     */


    private function handlePayment($data)
    {
        $paymentId = $data['data']['id'] ?? 'N/A';
        $payment = $this->mercadoPagoService->getPayment($paymentId);


        $payment = json_decode($payment, true); // Decodifica el JSON a un array asociativo


        // ⚡ Bolt: Database write optimization.
        // What: Replaced Payment::where()->first() and new Payment()->save() with DB::table('payment')->updateOrInsert().
        // Why: Avoids executing a SELECT query followed by hydrating a full Eloquent model and dispatching lifecycle events
        //      just to update or insert a single logging record during the highly concurrent webhook processing flow.
        // Impact: Eliminates memory allocation overhead, reduces database queries, and cuts CPU cycles per webhook.
        $payloadString = is_array($payment) ? json_encode($payment) : $payment;
        $externalReference = $payment['external_reference'] ?? 'pending';
        $status = $payment['status'] ?? 'pending';
        $currencyId = $payment['currency_id'] ?? 'pending';
        $totalPaidAmount = $payment['transaction_details']['total_paid_amount'] ?? 0;
        $netReceivedAmount = $payment['transaction_details']['net_received_amount'] ?? 0;

        \Illuminate\Support\Facades\DB::table('payment')->updateOrInsert(
            ['payment_id' => $paymentId],
            [
                'status' => $status,
                'preapproval_id' => $payment['metadata']['preapproval_id'] ?? 'pending',
                'external_reference' => $externalReference,
                'payer_email' => $payment['payer']['email'] ?? 'pending',
                'payer_identification_number' => $payment['payer']['identification']['number'] ?? 'pending',
                'payer_identification_type' => $payment['payer']['identification']['type'] ?? 'pending',
                'payer_first_name' => $payment['payer']['first_name'] ?? 'pending',
                'payer_last_name' => $payment['payer']['last_name'] ?? 'pending',
                'payment_method_id' => $payment['payment_method_id'] ?? 'pending',
                'net_received_amount' => $netReceivedAmount,
                'total_paid_amount' => $totalPaidAmount,
                'currency_id' => $currencyId,
                'payload' => $payloadString,
                'updated_at' => now(),
            ]
        );


        // SE ENVIA EL MAIL AL CORREO CUYO PAYMENT SEA EL CORESPONDIENTE SIEMPRE QUE NO SE HAYA ENVIADO ANTES

        // var_dump($paymentModel->external_reference);

        // ⚡ Bolt: Memory optimization.
        // What: Added select() to prevent fetching heavy TEXT/JSON columns ('response', 'payload') when resolving a subscription for confirmation emails.
        // Why: Hydrating massive payload columns into Eloquent models on a high-concurrency webhook wastes significant RAM and CPU.
        //      We only retrieve the explicit fields needed for the confirmation email (status, amounts, dates) and logic flags.
        // Impact: Drastically reduces memory footprint per webhook execution and improves endpoint latency.
        $subscriptionModel = Subscription::select(['id', 'email', 'first_send', 'external_reference', 'status', 'last_charged_amount', 'next_payment_date', 'currency'])
            ->where('external_reference', $externalReference)->first();

        // //var_dump( $subscriptionModel);



        // $command = new SendDailyContentEmails();

        // // var_dump($subscriptionModel->email);
        // $command->handle($subscriptionModel->email);

        // var_dump($subscriptionModel);
        //$subscriptionModel = Subscription::where('external_reference', $request->input('external_reference'))->first();
        if ($subscriptionModel) {
            if ($subscriptionModel->first_send != 1) {
                // Verifica si el email existe antes de usarlo
                if (!empty($subscriptionModel->email)) {
                    Mail::to($subscriptionModel->email)->send(new SubscriptionConfirmationMail($subscriptionModel));
                    Artisan::call('send:daily-content-emails', ['email' => $subscriptionModel->email]);

                    $subscriptionModel->first_send = 1;
                    $subscriptionModel->save();
                } else {
                    \Log::warning('El modelo Subscription no tiene un email.', ['subscription' => $subscriptionModel]);
                }
            }
        } else {
            \Log::error('El modelo Subscription no existe o no pudo ser cargado.');
            return response()->json(['error' => 'Suscripción no encontrada'], 404);
        }


        $message  = "";
        $message  .= "================================\n";
        $message .= ":dollar: PAGO \n";
        $message .= "================================\n";
        $message .= "ID del pago: " . $paymentId . "\n";
        $message .= ":traffic_light: Estado del pago: " .  $status . "\n";
        // Determinar la bandera basada en el currency_id
        $flag = $this->getCurrencyFlag($currencyId);
        $message .= ":moneybag: Monto del pago: " . $totalPaidAmount . " " . $currencyId . " " . $flag . "\n";
        $message .= ":moneybag: Monto del pago recibido: " . $netReceivedAmount . " " . $currencyId . " " . $flag . "\n";
        $message .= ":link: Referencia externa: " . $externalReference . "\n";
        $message .= ":link: Email de envio: " . $subscriptionModel->email;
        $this->discordService->sendDiscordMessage($message);
    }

    /**
     * Maneja las notificaciones que no tienen detalles específicos.
     *
     * Esta función crea un mensaje estándar para las notificaciones que no tienen detalles
     * específicos y lo envía a través del servicio de Discord.
     *
     * @param mixed $data Datos recibidos que no se utilizan en esta función.
     *
     * @return void
     */
    private function handleDefault($data)
    {
        $message = ":rotating_light: :rotating_light: :rotating_light: :rotating_light: :rotating_light: :rotating_light: :rotating_light: :rotating_light: :rotating_light: :rotating_light: :rotating_light: :rotating_light: :rotating_light: :rotating_light: :rotating_light: :rotating_light: :rotating_light: :rotating_light: :rotating_light: :rotating_light: :rotating_light: :rotating_light: :rotating_light:  notificacion desonocida";
        $this->discordService->sendDiscordMessage($message);
    }


    /**
     * Obtiene la bandera correspondiente a una moneda basada en su ID.
     *
     * Esta función recibe un ID de moneda y devuelve el emoji de la bandera asociada a esa moneda.
     * Si no se encuentra una coincidencia para el ID de moneda, se devuelve una cadena vacía.
     *
     * @param string $currencyId El ID de la moneda para la cual se desea obtener la bandera.
     *
     * @return string El emoji de la bandera correspondiente a la moneda proporcionada, o una cadena vacía si no hay coincidencia.
     */
    private function getCurrencyFlag($currencyId)
    {
        switch ($currencyId) {
            case 'ARS':
                return '🇦🇷'; // Bandera de Argentina
            case 'UYU':
                return '🇺🇾'; // Bandera de Uruguay
            case 'BRL':
                return '🇧🇷'; // Bandera de Brasil
            case 'PYG':
                return '🇵🇾'; // Bandera de Paraguay
            default:
                return ''; // Bandera por defecto si no hay coincidencia
        }
    }

    private function verifyMercadoPagoSignature(Request $request)
    {
        $secret = config('mercado_pago.webhook_secret');
        if (empty($secret)) {
            return true;
        }

        $signatureHeader = $request->header('x-signature');
        $requestId = $request->header('x-request-id');
        $dataId = $request->input('data.id');

        if (empty($signatureHeader) || empty($requestId) || empty($dataId)) {
            return false;
        }

        $parts = explode(',', $signatureHeader);
        $ts = null;
        $v1 = null;

        foreach ($parts as $part) {
            $item = explode('=', trim($part), 2);
            if (count($item) == 2) {
                if ($item[0] == 'ts') $ts = $item[1];
                if ($item[0] == 'v1') $v1 = $item[1];
            }
        }

        if (empty($ts) || empty($v1)) {
            return false;
        }

        $manifest = "id:$dataId;request-id:$requestId;ts:$ts;";
        $sha = hash_hmac('sha256', $manifest, $secret);

        return hash_equals($sha, $v1);
    }

    private function verifyDlocalGoSignature(Request $request)
    {
        $secret = config('dlocalgo.webhook_secret');
        if (empty($secret)) {
            return true;
        }

        $authHeader = $request->header('Authorization');
        if (empty($authHeader)) {
            return false;
        }

        // Usually "Bearer <token>"
        if (strpos($authHeader, 'Bearer ') === 0) {
            $token = substr($authHeader, 7);
            return hash_equals($secret, $token);
        }

        return false;
    }
}
