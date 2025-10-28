<?php

namespace App\Services;

class GoogleConversionService
{
    protected $conversionUrl;

    public function __construct()
    {
        // URL del endpoint de conversión de Google
        $this->conversionUrl = 'https://www.google.com/pagead/conversion/';
    }

    /**
     * Envía una conversión a Google Ads usando cURL.
     *
     * @param string $gclid GCLID capturado del clic original.
     * @param float $conversionValue El valor de la conversión en ARS.
     * @return bool
     */
    public function sendConversion($gclid, $conversionValue)
    {
        // Datos de conversión
        $data = [
            'send_to' => 'AW-16701477464/cImNCN2cvNIZENik8Zs-', // Reemplaza por tu ID de etiqueta de conversión
            'value' => $conversionValue,
            'currency_code' => 'ARS',
            'gclid' => $gclid,
        ];

        // Configuración de cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->conversionUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Captura la respuesta y el código de error
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);

        // Cierra la conexión cURL
        curl_close($ch);

        // Verifica si hubo un error con cURL
        if ($curlError) {
            logger()->error('Error cURL:', ['error' => $curlError]);
            return false;
        }

        // Verifica si la solicitud fue exitosa
        if ($httpCode === 200) {
            return true;
        } else {
            logger()->error('Error al enviar la conversión', ['response' => $response, 'http_code' => $httpCode]);
            return false;
        }
    }
}
