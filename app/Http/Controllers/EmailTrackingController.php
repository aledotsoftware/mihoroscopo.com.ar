<?php
// app/Http/Controllers/EmailTrackingController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailLog;
use App\Models\EmailClick;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class EmailTrackingController extends Controller
{
    public function trackOpen(Request $request)
    {
        // Recuperar el parámetro 'email_id' de la URL
        $emailId = $request->query('email');

        // Verificar si el email_id existe
        if ($emailId) {
            // ⚡ Bolt: Performance optimization.
            // What: Wrapped the synchronous database update inside Laravel's defer() helper.
            // Why: Updating the database synchronously delays the delivery of the tracking pixel.
            //      Deferring the update allows the server to respond to the client immediately,
            //      moving the I/O-bound query to a background process after the response is sent.
            // Impact: Drastically reduces response time for the tracking endpoint.
            defer(function () use ($emailId) {
                // ⚡ Bolt: Database update optimization.
                // What: Replaced EmailLog::find()->update() with a direct where()->update() query.
                // Why: Avoids executing an unnecessary SELECT query and prevents loading the
                //      entire Eloquent model into memory just to update a single timestamp column.
                // Impact: Eliminates O(1) memory overhead and 1 database query per tracking request,
                //         significantly improving throughput for this highly concurrent endpoint.
                EmailLog::where('id', $emailId)->update([
                    'opened_at' => Carbon::now(),
                ]);
            });
        }

        // Ruta a la imagen del logo
        $logoPath = public_path('assets/images/logo.png'); // Asegúrate de que la imagen exista en esta ruta

        // Si no existe el archivo, puedes retornar un error o una imagen por defecto
        if (!file_exists($logoPath)) {
            abort(404, 'Logo not found');
        }

        // ⚡ Bolt: File serving optimization.
        // What: Replaced Response::make(file_get_contents($path)) with response()->file($path).
        // Why: file_get_contents() loads the entire binary image into PHP's allocated memory
        //      before constructing the response string, causing OOMs under high concurrency.
        //      response()->file() streams the file directly from disk and automatically generates
        //      client-side caching headers (Last-Modified, ETag) to prevent re-downloads.
        // Impact: Reduces peak memory usage drastically per request and enables browser caching.
        return response()->file($logoPath);
    }

    public function trackClick(Request $request)
    {
        $emailLogId = $request->query('email');
        $url = $request->query('url');

        $ip = $request->ip();
        $userAgent = $request->userAgent();

        if ($emailLogId && $url) {
            // Registrar el click
            // ⚡ Bolt: Performance optimization.
            // What: Wrapped the synchronous database insert inside Laravel's defer() helper.
            // Why: Tracking email clicks synchronously delays the redirect to the target URL.
            //      By deferring the insert, the server responds with a 302 redirect instantly,
            //      improving the perceived performance for the user. Request properties are captured
            //      before the defer block as they may not be available when execution occurs.
            // Impact: Drastically reduces latency before redirecting the user.
            defer(function () use ($emailLogId, $url, $ip, $userAgent) {
                try {
                    // ⚡ Bolt: Database write optimization.
                    // What: Replaced EmailClick::create() with DB::table('email_clicks')->insert().
                    // Why: Avoids executing an unnecessary Eloquent Model hydration cycle on a high-concurrency
                    //      tracking endpoint where we don't need the resulting object.
                    // Impact: Eliminates memory allocation overhead per tracked click.
                    \Illuminate\Support\Facades\DB::table('email_clicks')->insert([
                        'email_log_id' => $emailLogId,
                        'url' => $url,
                        'ip_address' => $ip,
                        'user_agent' => $userAgent,
                        'clicked_at' => Carbon::now(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                } catch (\Exception $e) {
                    // Log error but continue redirect
                    \Log::error('Error tracking email click: ' . $e->getMessage());
                }
            });
        }

        // Redirigir a la URL original
        if ($url) {
            return redirect($url);
        }

        // Fallback si no hay URL
        return redirect('/');
    }
}
