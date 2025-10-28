<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MercadoPagoService;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use App\Models\ExtradataHoroscope;


class SubscriptionController extends Controller
{

    private $mercadoPagoService;

    /**
     * Constructor de la clase.
     *
     * Inicializa el servicio de MercadoPago utilizando el token de acceso
     * configurado en el archivo de configuración.
     *
     * @return void
     */
    public function __construct()
    {
        $this->mercadoPagoService = new MercadoPagoService(config('mercado_pago.access_token'));
    }

    /**
     * Guarda datos adicionales relacionados con el horóscopo de una suscripción.
     *
     * Este método almacena información adicional en la tabla `ExtradataHoroscope`
     * para una suscripción específica, incluyendo el signo zodiacal, el gclid y el nombre del usuario.
     *
     * @param int    $subscriptionId  ID de la suscripción asociada.
     * @param string $zodiacSign      Signo zodiacal del usuario.
     * @param string|null $gclid      ID de clic de Google Ads (opcional).
     * @param string $name            Nombre del usuario.
     *
     * @return void
     */
    private function saveExtraData($subscriptionId, $name, $zodiacSign, $gclid, $gbraid, $wbraid, $li_fat_id, $li_ed, $sub_days, $cost, $click_id, $web_push_creative_id, $mobile_brand, $city_name, $browser_family, $os_type, $price, $region_name, $spot_id, $domain)
    {
        $extradataHoroscope = new ExtradataHoroscope();
        $extradataHoroscope->subscription_id = $subscriptionId;
        $extradataHoroscope->signo = $zodiacSign;
        $extradataHoroscope->gclid = $gclid;
        $extradataHoroscope->name = $name;
        $extradataHoroscope->li_fat_id = $li_fat_id;
        $extradataHoroscope->li_ed = $li_ed;
        $extradataHoroscope->sub_days = $sub_days;
        $extradataHoroscope->cost = $cost;
        $extradataHoroscope->click_id = $click_id;
        $extradataHoroscope->web_push_creative_id = $web_push_creative_id;
        $extradataHoroscope->mobile_brand = $mobile_brand;
        $extradataHoroscope->city_name = $city_name;
        $extradataHoroscope->browser_family = $browser_family;
        $extradataHoroscope->os_type = $os_type;
        $extradataHoroscope->price = $price;
        $extradataHoroscope->region_name = $region_name;
        $extradataHoroscope->spot_id = $spot_id;
        $extradataHoroscope->domain = $domain;
        $extradataHoroscope->gbraid = $gbraid;
        $extradataHoroscope->wbraid = $wbraid;

        $extradataHoroscope->save();
    }

    /**
     * Crea y guarda una nueva suscripción en la base de datos.
     *
     * Este método almacena los datos de suscripción en la tabla `Subscription`,
     * configurando el servicio, el correo electrónico, el tipo de pago, el estado y otros detalles.
     *
     * @param string $email              Correo electrónico del usuario.
     * @param string $paymentType        Tipo de suscripción (gratuita o paga).
     * @param string $externalReference  Referencia única para la suscripción.
     * @param string $subscriptionId     ID de la suscripción (para el tipo paga).
     * @param string $status             Estado inicial de la suscripción.
     *
     * @return Subscription              La instancia de la suscripción creada.
     */
    private function createSubscription($email, $paymentType, $externalReference, $subscriptionId, $status, $country,   $currency,  $paymentProvider)
    {

        $subscription = new Subscription();
        $subscription->service_id = 1;
        $subscription->payment_provider_id = $paymentProvider;
        $subscription->email = $email;
        $subscription->external_reference = $externalReference;
        $subscription->payment_type = $paymentType;
        $subscription->subscription_id = $subscriptionId;
        $subscription->status = $status;
        $subscription->currency = $currency;
        $subscription->country = $country;
        $subscription->save();
        return $subscription;
    }





    /**
     * Obtiene una suscripción existente por correo electrónico.
     *
     * @param string $email El correo electrónico del usuario.
     * @return Subscription|null Retorna la suscripción si existe o null si no existe.
     */
    private function getSubscriptionByEmail($email)
    {
        // Asumimos que existe un modelo `Subscription` que permite buscar la suscripción por correo
        return Subscription::where('email', $email)->first();
    }

    /**
     * Obtiene una suscripción existente por correo electrónico.
     *
     * @param string $email El correo electrónico del usuario.
     * @return Subscription|null Retorna la suscripción si existe o null si no existe.
     */
    private function getSubscriptionByExternalReference($externalReference)
    {
        // Asumimos que existe un modelo `Subscription` que permite buscar la suscripción por externalReference

        return Subscription::where('external_reference', $externalReference)->first();
    }



    public function subscribe(Request $request)
    {
        $email = $request->input('email');
        $zodiacSign = $request->input('zodiacSign');
        $name = $request->input('name');
        $country = $request->input('country');
        $gclid = $request->input('gclid');
        $gbraid = $request->input('gbraid');
        $wbraid = $request->input('wbraid');
        $li_fat_id = $request->input('li_fat_id');
        $li_ed = $request->input('li_ed');
        $sub_days = $request->input('sub_days');
        $cost = $request->input('cost');
        $click_id = $request->input('click_id');
        $web_push_creative_id = $request->input('web_push_creative_id');
        $mobile_brand = $request->input('mobile_brand');
        $city_name = $request->input('city_name');
        $browser_family = $request->input('browser_family');
        $os_type = $request->input('os_type');
        $price = $request->input('price');
        $region_name = $request->input('region_name');
        $spot_id = $request->input('spot_id');
        $domain = $request->input('domain');
        $deviceua = $request->input('deviceua');


        $paymentType = $request->input('subscription');

        // Verificar si el correo ya tiene una suscripción
        $existingSubscription = $this->getSubscriptionByEmail($email);

        if ($existingSubscription) {
            // Si la suscripción existe y está pendiente o activa, devolver el punto de inicio existente
            if (in_array($existingSubscription->status, ['pending', 'authorized'])) {
                $init_point = url('/subscription/preferences/' . $existingSubscription->external_reference);
                return response()->json([
                    'message' => 'Ya existe una suscripción activa para este correo.',
                    'init_point' => $init_point
                ], 200);
            }

            // Si la suscripción existe pero está cancelada o expirada, actualizarla
            $externalReference = $existingSubscription->external_reference;
            $subscription = $existingSubscription;
        } else {
            // Si no existe, crear una nueva referencia y suscripción
            $externalReference = $country . "-" . crc32(time() . mt_rand(10, 99));

            // Determinar el proveedor de pagos y moneda según el país
            $paymentProvider = strtoupper($country) === 'AR' ? 1 : $this->getPaymentProviderByCountry($country);
            $currency = $this->getCurrencyByCountry($country);

            $subscription = $this->createSubscription(
                email: $email,
                paymentType: $paymentType,
                externalReference: $externalReference,
                subscriptionId: null,
                status: 'pending',
                country: $country,
                currency: $currency,
                paymentProvider: $paymentProvider
            );

            // Guardar datos adicionales del usuario
            $this->saveExtraData(
                subscriptionId: $subscription->id,
                name: $name,
                zodiacSign: $zodiacSign,
                gclid: $gclid,
                gbraid: $gbraid,
                wbraid: $wbraid,
                li_fat_id: $li_fat_id,
                li_ed: $li_ed,
                sub_days: $sub_days,
                cost: $cost,
                click_id: $click_id,
                web_push_creative_id: $web_push_creative_id,
                mobile_brand: $mobile_brand,
                city_name: $city_name,
                browser_family: $browser_family,
                os_type: $os_type,
                price: $price,
                region_name: $region_name,
                spot_id: $spot_id,
                domain: $domain


            );
        }

        // Procesar según el proveedor de pagos
        if ($subscription->payment_provider_id == 1 || strtoupper($country) === 'AR') {
            // MercadoPago
            $response = $this->mercadoPagoService->createSubscription($email, $paymentType, $externalReference);

            if (is_string($response)) {
                $response = json_decode($response);
            }
        } else {
            // dLocalGo - Obtener URL de checkout según país
            $countryCode = strtoupper($country);
            $initPoint = env("{$countryCode}_INIT_POINT") ?? env('GLOBAL_INIT_POINT');
            // en el caso de dLocalGo, el init_point es algo asi https://checkout-sbx.dlocalgo.com/validate/subscription/YD32lX5u3Ch2WeYFTNbMMQn2zu3wDQCa?external_reference=uy-2868797439&email=alejandr@gmail.com
            // se completa con el external_reference y el email
            //  $initPoint = $initPoint . "?external_reference=" . $externalReference . "&email=" . $email;


            $response = (object)[
                'init_point' => $initPoint,
                'subscription_id' => $externalReference
            ];
        }

        if (!is_object($response)) {
            return response()->json([
                'error' => 'Error al procesar el pago',
                'message' => 'No se pudo procesar la solicitud correctamente'
            ], 400);
        }

        // Actualizar la suscripción con el ID correspondiente
        if (isset($response->subscription_id)) {
            $subscription->update([
                'subscription_id' => $response->subscription_id,
                'status' => 'pending'
            ]);
        }

        // Verificar y retornar el punto de inicio
        if (isset($response->init_point) && !empty($response->init_point)) {
            return response()->json(['init_point' => $response->init_point])
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'POST')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        }
    }





















    public function reactivateSubscription($externalReference, $paymentType)
    {
        // Realizar la consulta para obtener los datos de la suscripción
        // Convertir el resultado en un objeto Subscription usando external_reference

        $subscription =  $this->getSubscriptionByExternalReference($externalReference);


        // Depurar el objeto Subscription
        if ($subscription) {
            $response = $this->mercadoPagoService->createSubscription($subscription->email, $paymentType, $externalReference);

            // Manejar la respuesta
            if (is_string($response)) {
                $response = json_decode($response);
            }

            if (is_object($response) && isset($response->subscription_id)) {
                // Actualizar la suscripción
                $subscription->service_id = 1;
                $subscription->payment_type = $paymentType;
                $subscription->subscription_id = $response->subscription_id;
                $subscription->status = 'authorized';
                $subscription->save();
                if (isset($response->init_point) && !empty($response->init_point)) {
                    return redirect($response->init_point);
                }
            }
        }
        // }

        // Manejar error en la creación de la suscripción
        return response()->json(['error' => 'No se pudo generar la suscripción.'], 400)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'POST')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }


    public function preferences($externalReference)
    {
        // Realizar la consulta con INNER JOIN
        $subscription = DB::table('subscriptions')
            ->join('extradata_horoscopes', 'subscriptions.id', '=', 'extradata_horoscopes.subscription_id')
            ->where('subscriptions.external_reference', $externalReference)
            ->orderBy('extradata_horoscopes.subscription_id', 'ASC')
            ->select('subscriptions.*', 'extradata_horoscopes.signo', 'extradata_horoscopes.gclid', 'extradata_horoscopes.name')
            ->first();

        // Depurar el resultado de la consulta
        //  var_dump($subscription);

        // Verificar si se encontró una suscripción
        if (!$subscription) {
            // Manejar el caso cuando no se encuentra la suscripción
            return redirect()->back()->withErrors(['No se encontró la suscripción.']);
        }

        // // Pasar el registro completo a la vista
        return view('admin.subscription.preferences', [
            'subscription' => $subscription,
        ]);
    }

    /**
     * Procesa la solicitud de cancelación de suscripción.
     *
     * Determina el tipo de suscripción basado en el formato del ID y realiza
     * acciones específicas según el estado de la suscripción.
     * Si el estado es "authorized" y el tipo de suscripción no contiene guion,
     * redirige a la página de detalles de MercadoPago. En cualquier otro caso,
     * actualiza el estado de la suscripción a "cancelled" y redirige a la página
     * de preferencias.
     *
     * @param string $id El identificador de la suscripción. (`subscriptions`.`subscription_id`)
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     *         Redirige a la página de detalles de MercadoPago o a la página de
     *         preferencias si la cancelación es exitosa. Devuelve un error JSON
     *         si la suscripción no se encuentra.
     */
    public function processUnsubscribe($id)
    {
        // Determinar el tipo de suscripción basado en el formato del ID
        $subscriptionType = strpos($id, '-') !== false ? 'tipo_con_guion' : 'tipo_sin_guion';

        // Buscar la suscripción
        $subscription = Subscription::where('subscription_id', $id)->first();

        // Verificar si la suscripción existe
        if (!$subscription) {
            return response()->json(['error' => 'No se encontró la suscripción.'], 404);
        }

        // Redirigir a la página de detalles en MercadoPago si está autorizada
        if ($subscriptionType == 'tipo_sin_guion' && $subscription->status === "authorized") {
            $url = "https://www.mercadopago.com.ar/subscriptions/details/" . $subscription->subscription_id;
            return redirect($url);
        }

        // En todos los demás casos, cancelar la suscripción y redirigir a preferencias
        $subscription->status = 'cancelled';
        $subscription->save();

        return redirect('/subscription/preferences/' . $id);
    }




    public function reactivate($externalReference)
    {
        // Lógica para reactivar la suscripción
        $subscription = DB::table('subscriptions')
            ->where('external_reference', $externalReference) // Corrección en la clave del where
            ->first();

        if ($subscription) {
            // Actualiza los campos necesarios
            DB::table('subscriptions')
                ->where('external_reference', $externalReference)
                ->update([
                    'subscription_id' => $externalReference,
                    'status' => 'authorized',
                    'payment_type' => 'gaia'
                ]);

            // Redirigir a preferencias
            return redirect('/subscription/preferences/' . $externalReference);
        } else {
            // Manejo en caso de no encontrar la suscripción
            return response()->json(['error' => 'Suscripción no encontrada'], 404);
        }
    }


    public function update($externalReference)
    {






        $subscription = DB::table('subscriptions')
            ->join('extradata_horoscopes', 'subscriptions.id', '=', 'extradata_horoscopes.subscription_id')
            ->where('subscriptions.external_reference', $externalReference)
            ->orderBy('extradata_horoscopes.subscription_id', 'ASC')
            ->select('subscriptions.*', 'extradata_horoscopes.*')
            ->first();

        // Pasar el registro completo a la vista
        return view('admin.subscription.update', [
            'subscription' => $subscription,
        ]);
    }


    /**
     * Determina el proveedor de pagos según el país.
     * 
     * @param string $country Código ISO del país (ej: 'AR', 'MX', etc)
     * @return int ID del proveedor de pagos:
     *             1 = MercadoPago (solo para Argentina)
     *             2 = dLocalGo (resto de países)
     */
    private function getPaymentProviderByCountry($country)
    {
        // MercadoPago (ID=1) solo está disponible para Argentina
        // dLocalGo (ID=2) se usa para el resto de países
        if ($country == 'AR') {
            return 1; // MercadoPago
        }
        return 2; // dLocalGo
    }

    //getCurrencyByCountr
    private function getCurrencyByCountry($country)
    {

        switch ($country) {
            case 'AR':
                return 'ARS';
            case 'BO':
                return 'BOB';
            case 'BR':
                return 'BRL';
            case 'CL':
                return 'CLP';
            case 'CO':
                return 'COP';
            case 'CR':
                return 'CRC';
            case 'EC':
                return 'USD';
            case 'GT':
                return 'GTQ';
            case 'ID':
                return 'IDR';
            case 'KE':
                return 'KES';
            case 'MX':
                return 'MXN';
            case 'MY':
                return 'MYR';
            case 'NG':
                return 'NGN';
            case 'PA':
                return 'USD';
            case 'PE':
                return 'PEN';
            case 'PY':
                return 'PYG';
            case 'UY':
                return 'UYU';
            default:
                return 'USD';
        }
    }
}
