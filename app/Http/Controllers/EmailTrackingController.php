<?php
// app/Http/Controllers/EmailTrackingController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailLog;
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
}
