<?php
namespace App\Services;
use Exception;

use Illuminate\Support\Facades\Http;

class MercadoPagoService
{

    /**
     * Obtiene los detalles de una suscripción en Mercado Pago.
     *
     * @param string $subscriptionId El ID de la suscripción(Mercado pago) a consultar.
     * @return array La respuesta de la API de Mercado Pago en formato array.
     * @throws Exception Si ocurre un error en la solicitud o en la respuesta.
     */
    public function getSubscription($subscriptionId)
    {

        // Configuración de cURL
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mercadopago.com/preapproval/' . $subscriptionId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . config('mercado_pago.access_token'),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        // Comprobar si se produjo un error en cURL
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            curl_close($curl);
            throw new Exception("cURL Error: " . $error_msg);
        }

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Procesar la respuesta
        if ($httpCode == 200) {


                $response = json_decode($response, true);

                return $response;

        } else {
            throw new Exception("Error: " . $response . " Código HTTP: " . $httpCode);
        }
    }


    /**
     * Obtiene los detalles de un pago en Mercado Pago.
     *
     * @param string $paymentId El ID del pago a consultar.
     * @return string La respuesta de la API de Mercado Pago en formato JSON.
     * @throws Exception Si ocurre un error en la solicitud o en la respuesta.
     */

    public function getPayment($paymentId)
    {

        // Configuración de cURL
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mercadopago.com/v1/payments/' . $paymentId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . config('mercado_pago.access_token'),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        // Comprobar si se produjo un error en cURL
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            curl_close($curl);
            throw new Exception("cURL Error: " . $error_msg);
        }

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Procesar la respuesta
        if ($httpCode == 200) {

            return $response;

        } else {
            throw new Exception("Error: " . $response . " Código HTTP: " . $httpCode);
        }
    }


    /**
     * Crea una suscripción en Mercado Pago.
     *
     * @param string $payerEmail El correo electrónico del pagador.
     * @param string $frequencyType El tipo de frecuencia de la suscripción (ej. 'days', 'months').
     * @param string $externalReference Referencia externa para identificar la suscripción.
     * @return string La respuesta de la API de Mercado Pago en formato JSON.
     * @throws Exception Si ocurre un error en la solicitud o en la respuesta.
     */
    public function createSubscription($payerEmail, $frequencyType, $externalReference)
    {

        // Inicializa las variables
    $reason = '';
    $transactionAmount = 30; // Valor por defecto

    // Ajusta el reason y transaction_amount según el frequencyType


    switch ($frequencyType) {
        case 'days':
            $reason = env('SUBSCRIPTION_DAILY_REASON');
            $transactionAmount = env('SUBSCRIPTION_DAILY_AMOUNT');
            $frequency = env('SUBSCRIPTION_DAILY_FREQUENCY');
            $frequencyType = env('SUBSCRIPTION_DAILY_FREQUENCY_TYPE');
            break;
        case 'days7':
            $reason = env('SUBSCRIPTION_WEEKLY_REASON');
            $transactionAmount = env('SUBSCRIPTION_WEEKLY_AMOUNT');
            $frequency = env('SUBSCRIPTION_WEEKLY_FREQUENCY');
            $frequencyType = env('SUBSCRIPTION_WEEKLY_FREQUENCY_TYPE');
            break;
        case 'months':
            $reason = env('SUBSCRIPTION_MONTHLY_REASON');
            $transactionAmount = env('SUBSCRIPTION_MONTHLY_AMOUNT');
            $frequency = env('SUBSCRIPTION_MONTHLY_FREQUENCY');
            $frequencyType = env('SUBSCRIPTION_MONTHLY_FREQUENCY_TYPE');
            break;
        default:
            $reason = env('DEFAULT_REASON');
            $transactionAmount = env('DEFAULT_AMOUNT');
            $frequency = env('DEFAULT_FREQUENCY');
            break;
    }


        $data = [
            "reason" => $reason,
            "external_reference" => $externalReference,
            "payer_email" => $payerEmail,
            "auto_recurring" => [
                "frequency" =>$frequency, // 1=  se renueva 1 vez al mes /28 = se renueva cada 28 meses
                "frequency_type" => $frequencyType,
                "transaction_amount" => $transactionAmount,
                "currency_id" => "ARS",
                "statement_descriptor" => env('STATEMENT_DESCRIPTOR'), // Personaliza aquí
            ],
            "back_url" => env('BACK_URL'),
            "status" => "pending",
            "payment_methods_allowed" => [
                "payment_types" => [

                ],
                "payment_methods" => [

                ]
            ]
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mercadopago.com/preapproval',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . config('mercado_pago.access_token'),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        // Check for cURL errors
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            curl_close($curl);
            throw new Exception("cURL Error: " . $error_msg);
        }

        curl_close($curl);

        return $response;
    }





}
