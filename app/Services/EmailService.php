<?php

namespace App\Services;

use App\Mail\WelcomeEmail;
use App\Mail\DailyHoroscope;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function sendWelcomeEmail($name, $email)
    {
        // Crea un objeto ficticio de usuario si es necesario para el mailable
        $user = (object) ['name' => $name, 'email' => $email];
        Mail::to($email)->send(new WelcomeEmail($user));
    }

    public function sendDailyHoroscope($horoscope, $email)
    {
        Mail::to($email)->send(new DailyHoroscope($horoscope));
    }
}
