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
        $this->webhookUrl = config('discord.webhook_url');
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
        // ⚡ Bolt: Background execution optimization.
        // What: Wrapped the synchronous Guzzle HTTP POST request to Discord inside Laravel's `defer()` helper.
        // Why: Discord notifications are sent frequently during high-throughput webhook processing and batch commands.
        //      Making a synchronous external API call blocks the HTTP thread, increasing endpoint latency and risking timeouts
        //      from external providers (like Mercado Pago / dLocalGo) calling our webhooks.
        // Impact: Drastically reduces HTTP response times and prevents external API network latency from blocking the application.
        defer(function () use ($message, $imageUrl) {
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
                \Illuminate\Support\Facades\Log::error("Error al enviar el mensaje a Discord: " . $e->getMessage());
            }
        });
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
