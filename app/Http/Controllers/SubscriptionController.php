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
        // ⚡ Bolt: Database write optimization.
        // What: Replaced new ExtradataHoroscope()->save() with DB::table('extradata_horoscopes')->insert().
        // Why: Avoids hydrating a full Eloquent model and dispatching lifecycle events just to insert
        //      a single related record during the highly concurrent subscription creation flow.
        // Impact: Eliminates memory allocation overhead and reduces CPU cycles during checkout.
        ExtradataHoroscope::insert([
            'subscription_id' => $subscriptionId,
            'signo' => $zodiacSign,
            'gclid' => $gclid,
            'name' => $name,
            'li_fat_id' => $li_fat_id,
            'li_ed' => $li_ed,
            'sub_days' => $sub_days,
            'cost' => $cost,
            'click_id' => $click_id,
            'web_push_creative_id' => $web_push_creative_id,
            'mobile_brand' => $mobile_brand,
            'city_name' => $city_name,
            'browser_family' => $browser_family,
            'os_type' => $os_type,
            'price' => $price,
            'region_name' => $region_name,
            'spot_id' => $spot_id,
            'domain' => $domain,
            'gbraid' => $gbraid,
            'wbraid' => $wbraid,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
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
     * @param array $columns Columnas a obtener.
     * @return Subscription|null Retorna la suscripción si existe o null si no existe.
     */
    private function getSubscriptionByEmail($email, $columns = ['*'])
    {
        // Asumimos que existe un modelo `Subscription` que permite buscar la suscripción por correo
        return Subscription::select($columns)->where('email', $email)->first();
    }

    /**
     * Obtiene una suscripción existente por referencia externa.
     *
     * @param string $externalReference La referencia externa de la suscripción.
     * @param array $columns Columnas a obtener.
     * @return Subscription|null Retorna la suscripción si existe o null si no existe.
     */
    private function getSubscriptionByExternalReference($externalReference, $columns = ['*'])
    {
        // Asumimos que existe un modelo `Subscription` que permite buscar la suscripción por externalReference

        return Subscription::select($columns)->where('external_reference', $externalReference)->first();
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
        // ⚡ Bolt: Memory optimization.
        // What: Restricted columns in getSubscriptionByEmail using select() via optional $columns parameter.
        // Why: The 'subscriptions' table contains massive TEXT/JSON columns ('response', 'payload') that consume large
        //      amounts of memory when hydrated. Since this flow only reads 'status' and 'external_reference', fetching
        //      all columns is incredibly wasteful under concurrent checkouts.
        // Impact: Drastically reduces memory consumption and hydration overhead per checkout request.
        $existingSubscription = $this->getSubscriptionByEmail($email, ['id', 'email', 'status', 'external_reference']);

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

        // ⚡ Bolt: Memory optimization.
        // What: Restricted columns in getSubscriptionByExternalReference using select() via optional $columns parameter.
        // Why: The 'subscriptions' table contains massive TEXT/JSON columns ('response', 'payload'). We only need a few
        //      fields for the MercadoPago request and the Eloquent save() operation correctly handles partial models.
        // Impact: Drastically reduces memory consumption and hydration overhead per reactivation request.
        $subscription =  $this->getSubscriptionByExternalReference($externalReference, ['id', 'email', 'service_id', 'payment_type', 'subscription_id', 'status', 'external_reference']);


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
        // ⚡ Bolt: Memory & CPU optimization.
        // What: Replaced 'subscriptions.*' with explicit column names in the select() clause.
        // Why: The 'subscriptions' table contains large TEXT/JSON columns ('response', 'payload')
        //      that consume significant memory when hydrated. Since the view only needs a few status fields,
        //      fetching all columns is extremely wasteful.
        // Impact: Drastically reduces memory footprint and network transfer time for rendering the preferences page.
        $subscription = DB::table('subscriptions')
            ->join('extradata_horoscopes', 'subscriptions.id', '=', 'extradata_horoscopes.subscription_id')
            ->where('subscriptions.external_reference', $externalReference)
            ->orderBy('extradata_horoscopes.subscription_id', 'ASC')
            ->select(
                'subscriptions.id',
                'subscriptions.external_reference',
                'subscriptions.payment_type',
                'subscriptions.status',
                'subscriptions.subscription_id',
                'extradata_horoscopes.signo',
                'extradata_horoscopes.gclid',
                'extradata_horoscopes.name'
            )
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

        // ⚡ Bolt: Memory and CPU optimization.
        // What: Replaced fetching the full Eloquent model and saving it with a select query and mass update.
        // Why: The full model is not needed if the subscription doesn't need to be redirected to MercadoPago,
        //      and even if it does, we only need the 'status' and 'subscription_id' fields. This avoids hydrating
        //      all columns of the Subscription model into memory and eliminates a SELECT query when possible.
        // Impact: Reduces memory overhead and database operations per request.
        $subscription = DB::table('subscriptions')
            ->select('id', 'status', 'subscription_id')
            ->where('subscription_id', $id)
            ->first();

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
        DB::table('subscriptions')->where('id', $subscription->id)->update(['status' => 'cancelled']);

        return redirect('/subscription/preferences/' . $id);
    }




    public function reactivate($externalReference)
    {
        // Lógica para reactivar la suscripción
        // ⚡ Bolt: Database and memory optimization.
        // What: Replaced DB::table()->first() followed by an update with a single DB::table()->update() call,
        //      using the affected row count to determine success.
        // Why: The application previously queried the database to fetch the first row (consuming memory to hydrate
        //      the object array representation) only to check its existence before running a mass update. This
        //      can be done in a single query by inspecting the result of the update operation.
        // Impact: Eliminates a redundant SELECT query, lowering database load and removing memory allocation.
        $affectedRows = DB::table('subscriptions')
            ->where('external_reference', $externalReference) // Corrección en la clave del where
            ->update([
                'subscription_id' => $externalReference,
                'status' => 'authorized',
                'payment_type' => 'gaia'
            ]);

        if ($affectedRows > 0) {
            // Redirigir a preferencias
            return redirect('/subscription/preferences/' . $externalReference);
        } else {
            // Manejo en caso de no encontrar la suscripción
            return response()->json(['error' => 'Suscripción no encontrada'], 404);
        }
    }


    public function update($externalReference)
    {
        // ⚡ Bolt: Memory & CPU optimization.
        // What: Removed 'extradata_horoscopes' join and restricted select to only 'id' and 'external_reference'.
        // Why: The 'subscriptions' table contains large TEXT/JSON columns ('response', 'payload') that consume
        //      significant memory when hydrated. The 'update.blade.php' view only actually consumes
        //      '$subscription->external_reference' to generate reactivation links. The join and full select
        //      are completely unnecessary and slow down the endpoint.
        // Impact: Drastically reduces memory footprint and database overhead for rendering the subscription update page.
        $subscription = DB::table('subscriptions')
            ->where('external_reference', $externalReference)
            ->select('id', 'external_reference')
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
