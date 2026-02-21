<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use GeoIp2\Database\Reader;

/**
 * Class LandingController
 *
 * Controlador para manejar las vistas de la página de destino.
 *
 * @package App\Http\Controllers
 */
class LandingController extends Controller
{
    /**
     * @var string|null Directorio de vistas definido en la variable de entorno.
     */
    private ?string $viewDirectory;

    /**
     * LandingController constructor.
     *
     * Inicializa el directorio de vistas desde la variable de entorno.
     */
    public function __construct()
    {
        $this->viewDirectory = env('VIEW_DIRECTORY');
    }

    /**
     * Muestra la página de destino.
     *
     * Si se pasa el parámetro "gclid" en la URL, se guarda en la sesión.
     *
     * @param Request $request La solicitud HTTP entrante.
     * @return View La vista de la página de destino.
     */
    public function show(Request $request): View
    {
        // Obtiene y guarda 'gclid' en la sesión si existe en la URL
        if ($gclid = $request->query('gclid')) {
            $request->session()->put('gclid', $gclid);
        }

        // Determina la vista de la página de destino basada en el parámetro 'v'
        $viewName = $request->query('v') ? 'mihoroscopo/landing_' . $request->query('v') : 'mihoroscopo/landing';

        #$testIp = '38.0.101.76'; // Argentina
        #$testIp = '237.84.2.178'; // Brasil
        #$testIp = '38.0.101.76'; // Chile
        #$testIp = '38.0.101.76'; // Colombia

        // Verifica si se envió el parámetro 'country'
        $country = $request->query('country');

        if (!$country) {
            // Si no se envía, intenta determinarlo por la IP
            $country = $this->getCountryByIp($request->ip());
        }

        // Si aún no hay un país (por ejemplo, IP no reconocida), puedes establecer un valor por defecto
        $country = $country ?? 'unknown';
        // Renderiza la vista pasando el país como parámetro
        return view($viewName, compact('country'));
    }



    private function getCountryByIp(string $ip): string
    {
        try {
            // Ruta al archivo GeoLite2-Country.mmdb
            $reader = new Reader(storage_path('geoip/GeoLite2-Country.mmdb'));

            // Busca la información del país usando la IP
            $record = $reader->country($ip);

            return $record->country->isoCode; // Devuelve el código ISO del país (ej: "AR", "US")
        } catch (\Exception $e) {
            return 'global'; // Código predeterminado si falla la detección
        }
    }
}
