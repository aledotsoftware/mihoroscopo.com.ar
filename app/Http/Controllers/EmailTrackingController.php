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
            // ⚡ Bolt: Database update optimization.
            // What: Replaced EmailLog::find()->update() with a direct where()->update() query.
            // Why: Avoids executing an unnecessary SELECT query and prevents loading the
            //      entire Eloquent model into memory just to update a single timestamp column.
            // Impact: Eliminates O(1) memory overhead and 1 database query per tracking request,
            //         significantly improving throughput for this highly concurrent endpoint.
            EmailLog::where('id', $emailId)->update([
                'opened_at' => Carbon::now(),
            ]);
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

        if ($emailLogId && $url) {
            try {
                // Registrar el click
                EmailClick::create([
                    'email_log_id' => $emailLogId,
                    'url' => $url,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            } catch (\Exception $e) {
                // Log error but continue redirect
                \Log::error('Error tracking email click: ' . $e->getMessage());
            }
        }

        // Redirigir a la URL original
        if ($url) {
            return redirect($url);
        }

        // Fallback si no hay URL
        return redirect('/');
    }
}
