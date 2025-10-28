<?php
namespace App\Services;

class DiscordService
{
    /**
     * URL del webhook de Discord para enviar mensajes.
     *
     * @var string
     */
    private $webhookUrl;


    /**
     * Crea una nueva instancia de DiscordService.
     *
     * @param string $botId El ID del bot de Discord.
     */
    public function __construct($botId)
    {
        $this->botId = $botId;
        $this->webhookUrl = "https://discord.com/api/webhooks/1281123979431776327/5lGlZtlIF4r6MLsRH0TM3jRWtUwsNdNTlgZBtZ9dtfjj8pJUPKZSvafECx-VeqL-r90H";
    }

    /**
     * Envía un mensaje a un canal de Discord mediante un webhook.
     *
     * @param string $message El mensaje que se va a enviar.
     * @param string|null $imageUrl URL de la imagen opcional que se adjuntará al mensaje.
     * @return void
     */
    public function sendDiscordMessage($message, $imageUrl = null)
    {
        try {
            $client = new \GuzzleHttp\Client();

            // Configurar la estructura del mensaje
            $messageData = [
                'content' => $message,
            ];

            // Agregar la URL de la imagen si está disponible
            if ($imageUrl) {
                $messageData['content'] .= "\nImage URL:  https://static.tudexnetworks.com/$imageUrl";
            }

            // Realizar la solicitud POST con multipart/form-data
            $response = $client->post($this->webhookUrl, [
                'multipart' => $this->prepareMultipartFormData($messageData),
            ]);

            // Verificar si la petición fue exitosa
            $responseBody = $response->getBody()->getContents();
        } catch (\Exception $e) {
            echo "Error al enviar el mensaje a Discord: " . $e->getMessage();
        }
    }


    /**
     * Prepara los datos para el formulario de datos multipartes.
     *
     * @param array $data Datos a preparar.
     * @return array Datos preparados.
     */
    private function prepareMultipartFormData($data)
    {
        $formData = [];
        $boundary = 'boundary'; // Puedes ajustar el límite según sea necesario

        foreach ($data as $name => $content) {
            $formData[] = [
                'name' => $name,
                'contents' => is_array($content) ? json_encode($content) : $content,
            ];
        }

        return array_merge([
            ['name' => 'payload_json', 'contents' => json_encode($data)],
        ], $formData, [
            ['name' => 'boundary', 'contents' => $boundary],
        ]);
    }
}
