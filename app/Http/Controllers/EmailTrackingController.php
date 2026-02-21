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
            // Buscar el log del correo en la base de datos
            $emailLog = EmailLog::find($emailId);

            if ($emailLog) {
                // Actualizar el campo 'opened_at' en la base de datos para registrar la apertura
                $emailLog->update([
                    'opened_at' => Carbon::now(),
                ]);
            }
        }

        // Ruta a la imagen del logo
        $logoPath = public_path('assets/images/logo.png'); // Asegúrate de que la imagen exista en esta ruta

        // Si no existe el archivo, puedes retornar un error o una imagen por defecto
        if (!file_exists($logoPath)) {
            abort(404, 'Logo not found');
        }

        // Devolver la imagen del logo
        return Response::make(file_get_contents($logoPath), 200, [
            'Content-Type' => 'image/png',
            'Content-Length' => filesize($logoPath)
        ]);
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
