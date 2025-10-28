<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\GoogleConversionService;
use App\Models\ExtradataHoroscope;
use App\Models\ContentHoroscope;
use App\Models\EmailLog;

class SendConvertion extends Command
{
    protected $signature = 'cron:SendConvertion';
    protected $description = 'Send conversion data to Google Ads based on recurring payments';
    protected $googleConversionService;

    public function __construct(GoogleConversionService $googleConversionService)
    {
        parent::__construct();
        $this->googleConversionService = $googleConversionService;
    }

    public function handle()
    {








        // Valores de ejemplo
        $gclid = "Cj0KCQjw9Km3BhDjARIsAGUb4nxNw8o8xi2kDX7spfft28WIne98roCRyY7Pa_eQvpEXs5a6FiWrLZkaAhVAEALw_wcB";
        $conversionValue = 1990.99;

        // Crea una instancia del servicio
        $googleConversionService = new GoogleConversionService();

        // Envía la conversión
        $success = $googleConversionService->sendConversion($gclid, $conversionValue);

        if ($success) {
            echo "Conversión enviada correctamente.";
        } else {
            echo "Error al enviar la conversión.";
        }
    }
}
