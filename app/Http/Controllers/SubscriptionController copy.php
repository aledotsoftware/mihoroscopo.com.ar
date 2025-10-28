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
    private function saveExtraData($subscriptionId, $zodiacSign, $gclid, $name)
    {
        $extradataHoroscope = new ExtradataHoroscope();
        $extradataHoroscope->subscription_id = $subscriptionId;
        $extradataHoroscope->signo = $zodiacSign;
        $extradataHoroscope->gclid = $gclid;
        $extradataHoroscope->name = $name;
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
    private function createSubscription($email, $paymentType, $externalReference, $subscriptionId, $status)
    {
        $subscription = new Subscription();
        $subscription->service_id = 1;
        $subscription->email = $email;
        $subscription->external_reference = $externalReference;
        $subscription->payment_type = $paymentType;
        $subscription->subscription_id = $subscriptionId;
        $subscription->status = $status;
        $subscription->save();
        return $subscription;
    }





    // private function createSubscription($email, $paymentType, $externalReference, $subscriptionId, $status)
    // {
    //     return Subscription::create([
    //         'service_id' => 1,
    //         'email' => $email,
    //         'external_reference' => $externalReference,
    //         'payment_type' => $paymentType,
    //         'subscription_id' => $subscriptionId,
    //         'status' => $status,
    //     ]);
    // }



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

    /**
     * Crea una suscripción para el usuario en función del tipo de pago solicitado.
     *
     * Este método verifica si el usuario ya tiene una suscripción activa. Si la suscripción es gratuita,
     * redirige a la página de preferencias. Si la suscripción es paga y está pendiente o fallida, crea
     * un nuevo pago. Si no existe una suscripción previa, crea una nueva basada en el tipo de pago.
     *
     * @param \Illuminate\Http\Request $request La solicitud HTTP que contiene los datos del usuario
     *        (correo, tipo de suscripción, identificador gclid, nombre y signo zodiacal).
     *
     * @return \Illuminate\Http\JsonResponse Retorna un JSON con el punto de inicio (init_point) de la
     *         suscripción o un mensaje de error en caso de que la suscripción no se pueda crear.
    //  */
    // public function subscribe(Request $request)
    // {
    //     $email = $request->input('email');
    //     $paymentType = $request->input('subscription');
    //     $gclid = $request->input('gclid');
    //     $name = $request->input('name');
    //     $zodiacSign = $request->input('zodiacSign');
    //     $country = $request->input('country');

    //     // Generar un valor de referencia único
    //     $externalReference =  $country . "-" . crc32(time() . mt_rand(10, 99));

    //     // Verificar si el correo ya tiene una suscripción
    //     $existingSubscription = $this->getSubscriptionByEmail($email);
    //     if ($existingSubscription) {
    //         $init_point = url('/subscription/preferences/' . $existingSubscription->external_reference);

    //         // Si la suscripción es paga, verificar estado de pago
    //         if ($existingSubscription->status === 'pending' || $existingSubscription->status === 'cancelled') {
    //             // Crear un nuevo pago para la suscripción
    //             $response = $this->mercadoPagoService->createSubscription($email, $paymentType, $existingSubscription->external_reference);
    //             if (is_string($response)) {
    //                 $response = json_decode($response);
    //             }

    //             if (is_object($response) && isset($response->init_point)) {
    //                 return response()->json(['init_point' => $response->init_point])
    //                     ->header('Access-Control-Allow-Origin', '*')
    //                     ->header('Access-Control-Allow-Methods', 'POST')
    //                     ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    //             }
    //         } else {
    //             // El pago está activo, no se permite crear otra suscripción
    //             return response()->json([
    //                 'message' => 'Ya existe una suscripción activa para este correo.',
    //                 'init_point' => $init_point

    //             ], 200);
    //         }
    //     }

    //     switch ($country) {
    //         case 'ar':
    //             $response = $this->mercadoPagoService->createSubscription($email, $paymentType, $externalReference);

    //             if (is_string($response)) {
    //                 $response = json_decode($response);
    //             }

    //             if (is_object($response) && isset($response->subscription_id)) {
    //                 $subscription = $this->createSubscription($email, $paymentType, $externalReference, $response->subscription_id, 'pending');
    //                 $this->saveExtraData($subscription->id, $zodiacSign, $gclid, $name);

    //                 if (isset($response->init_point) && !empty($response->init_point)) {
    //                     return response()->json(['init_point' => $response->init_point])
    //                         ->header('Access-Control-Allow-Origin', '*')
    //                         ->header('Access-Control-Allow-Methods', 'POST')
    //                         ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    //                 }
    //             }

    //             break;


    //         case 'py': // Paraguay
    //             $init_point = env('AR_INIT_POINT', 'https://mihoroscopo.com.ar/blog/welcome');

    //             break;


    //         case 'uy': // Uruguay
    //             $init_point = env('UY_INIT_POINT', 'https://checkout-sbx.dlocalgo.com/validate/subscription/YD32lX5u3Ch2WeYFTNbMMQn2zu3wDQCa');
    //             break;

    //         default: // Global o países no especificados
    //             $init_point = env('GLOBAL_INIT_POINT', 'https://checkout-sbx.dlocalgo.com/validate/subscription/ByXcNzEUDCblNRiRqvrutYNofZmo07bu');
    //             break;
    //     }


    //     if (isset($init_point)) {

    //         $init_point = $init_point . "?external_reference=" . $externalReference . "&email=" . $email;

    //         $subscription = $this->createSubscription($email, $paymentType, $externalReference, $externalReference, 'pending');


    //         return response()->json(['init_point' => $init_point])
    //             ->header('Access-Control-Allow-Origin', '*')
    //             ->header('Access-Control-Allow-Methods', 'POST')
    //             ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    //     }

    //     // Manejar error en la creación de la suscripción
    //     return response()->json(['error' => 'No se pudo generar la suscripción.'], 400)
    //         ->header('Access-Control-Allow-Origin', '*')
    //         ->header('Access-Control-Allow-Methods', 'POST')
    //         ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    // }



























    public function subscribe(Request $request)
    {
        $email = $request->input('email');
        $paymentType = $request->input('subscription');
        $gclid = $request->input('gclid');
        $name = $request->input('name');
        $zodiacSign = $request->input('zodiacSign');
        $country = $request->input('country');
        $country = strtoupper($country);
        // Generar un valor de referencia único
        $externalReference = $country . "-" . crc32(time() . mt_rand(10, 99));

        // Verificar si el correo ya tiene una suscripción
        $existingSubscription = $this->getSubscriptionByEmail($email);

        if ($existingSubscription) {


            // Respetar el país almacenado en la suscripción existente
            $country = $existingSubscription->country ?? $country;
            // Pasar a mayúsculas el país
            $country = strtoupper($country);

            // Si la suscripción está pendiente o cancelada, procesar el pago
            if (in_array($existingSubscription->status, ['pending', 'cancelled'])) {    

                // al ser mercado pago suscription id como referencia externa
                

                var_dump($existingSubscription->subscription_id);
                $init_point = $this->getInitPointByCountry($country, $email, $existingSubscription->subscription_id, $paymentType, $existingSubscription);



                if ($init_point) {
                    return response()->json(['init_point' => $init_point])
                        ->header('Access-Control-Allow-Origin', '*')
                        ->header('Access-Control-Allow-Methods', 'POST')
                        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
                }
            } else {
                // Si la suscripción está activa, devolver el link de administración
                $adminPoint = url('/subscription/preferences/' . $existingSubscription->external_reference);
                return response()->json([
                    'message' => 'Ya existe una suscripción activa para este correo.',
                    'init_point' => $adminPoint
                ], 200);
            }
        }


        // Procesar la suscripción para nuevos usuarios según el país



        $init_point = $this->getInitPointByCountry($country, $email, $externalReference, $paymentType);

        if ($init_point) {
            // Crear una nueva suscripción
            $this->createSubscription($email, $paymentType, $externalReference, $externalReference, 'pending');

            return response()->json(['init_point' => $init_point])
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'POST')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        }

        // Manejar error en la creación de la suscripción
        return response()->json(['error' => 'No se pudo generar la suscripción.'], 400)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'POST')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }

    /**
     * Obtiene el init_point según el país y el estado de la suscripción.
     *
     * @param string $country
     * @param string $email
     * @param string $externalReference
     * @return string|null
     */
    private function getInitPointByCountry(string $country, string $email, string $externalReference, string $paymentType = 'daily'): ?string
    {
        switch ($country) {
            case 'AR': // Argentina

                $response = $this->mercadoPagoService->createSubscription($email, $paymentType, $externalReference);



                if (is_string($response)) {
                    $response = json_decode($response);
                }
                if (is_object($response) && isset($response->init_point)) {
                    return $response->init_point;
                }
                break;

            case 'BO': //  Paraguay
                $init_point = env('BO_INIT_POINT', 'https://mihoroscopo.com.ar/blog/welcome');
                return $init_point . "?external_reference={$externalReference}&email={$email}";
            case 'BR': // brasil

                $init_point = env('BR_INIT_POINT', 'https://mihoroscopo.com.ar/blog/welcome');
                return $init_point . "?external_reference={$externalReference}&email={$email}";
            case 'CH': // chile
                $init_point = env('CH_INIT_POINT', 'https://mihoroscopo.com.ar/blog/welcome');
                return $init_point . "?external_reference={$externalReference}&email={$email}";

            case 'CO': // colombia
                $init_point = env('CO_INIT_POINT', 'https://mihoroscopo.com.ar/blog/welcome');
                return $init_point . "?external_reference={$externalReference}&email={$email}";

            case 'CR': // Costa Rica
                $init_point = env('CR_INIT_POINT', 'https://mihoroscopo.com.ar/blog/welcome');
                return $init_point . "?external_reference={$externalReference}&email={$email}";

            case 'EC': // Ecuador
                $init_point = env('EC_INIT_POINT', 'https://mihoroscopo.com.ar/blog/welcome');
                return $init_point . "?external_reference={$externalReference}&email={$email}";

            case 'GT': // guatemala
                $init_point = env('GT_INIT_POINT', 'https://mihoroscopo.com.ar/blog/welcome');
                return $init_point . "?external_reference={$externalReference}&email={$email}";

            case 'ID': // indonesia
                $init_point = env('ID_INIT_POINT', 'https://mihoroscopo.com.ar/blog/welcome');
                return $init_point . "?external_reference={$externalReference}&email={$email}";

            case 'KE': // Kenya
                $init_point = env('KE_INIT_POINT', 'https://mihoroscopo.com.ar/blog/welcome');
                return $init_point . "?external_reference={$externalReference}&email={$email}";
            case 'MX': // mexico
                $init_point = env('MX_INIT_POINT', 'https://mihoroscopo.com.ar/blog/welcome');
                return $init_point . "?external_reference={$externalReference}&email={$email}";

            case 'MY': // MALASIA   
                $init_point = env('MY_INIT_POINT', 'https://mihoroscopo.com.ar/blog/welcome');
                return $init_point . "?external_reference={$externalReference}&email={$email}";

                #nigeria
            case 'NG':
                $init_point = env('NG_INIT_POINT', 'https://mihoroscopo.com.ar/blog/welcome');
                return $init_point . "?external_reference={$externalReference}&email={$email}";

                #panama
            case 'PA':
                $init_point = env('PA_INIT_POINT', 'https://mihoroscopo.com.ar/blog/welcome');
                return $init_point . "?external_reference={$externalReference}&email={$email}";

                #peru
            case 'PE':
                $init_point = env('PE_INIT_POINT', 'https://mihoroscopo.com.ar/blog/welcome');
                return $init_point . "?external_reference={$externalReference}&email={$email}";

            case 'PY': // Paraguay
                $init_point = env('PY_INIT_POINT', 'https://mihoroscopo.com.ar/blog/welcome');
                return $init_point . "?external_reference={$externalReference}&email={$email}";

            case 'UY': // Uruguay
                $init_point = env('UY_INIT_POINT', 'https://mihoroscopo.com.ar/blog/welcome');
                return $init_point . "?external_reference={$externalReference}&email={$email}";

            default: // Global o países no especificados
                $init_point = env('GLOBAL_INIT_POINT', 'https://mihoroscopo.com.ar/blog/welcome');
                return $init_point . "?external_reference={$externalReference}&email={$email}";
        }

        return null;
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
}
