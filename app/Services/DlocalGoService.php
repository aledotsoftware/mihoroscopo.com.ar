<?php

namespace App\Services;

use Exception;

use Illuminate\Support\Facades\Http;

class DlocalGoService
{

    /**
     * Obtiene los detalles de una suscripción en DlocalGo.
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
                'Authorization: Bearer APP_USR-8219629790209665-062910-420b6ac831a33108c2677609f5d97655-212784792',
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
}
