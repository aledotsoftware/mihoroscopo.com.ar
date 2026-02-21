<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class DlocalGoService
{

    /**
     * Obtiene los detalles de una suscripción en DlocalGo.
     *
     * @param string $subscriptionId El ID de la suscripción a consultar.
     * @return array La respuesta de la API de DlocalGo en formato array.
     * @throws Exception Si ocurre un error en la solicitud o en la respuesta.
     */
    public function getSubscription($subscriptionId)
    {
        $apiKey = config('services.dlocalgo.key');
        $baseUrl = config('services.dlocalgo.url');

        // Configuración de cURL
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $baseUrl . '/v1/subscription/' . $subscriptionId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $apiKey,
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
            // Intenta obtener mensaje de error del cuerpo si es JSON
            $decoded = json_decode($response, true);
            $msg = $decoded['message'] ?? $response;
            throw new Exception("Error dLocalGo: " . $msg . " Código HTTP: " . $httpCode);
        }
    }
}
