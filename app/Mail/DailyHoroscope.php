<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyHoroscope extends Mailable
{
    use Queueable, SerializesModels;
    private $viewDirectory;
    public $horoscope;

    public function __construct($horoscope)
    {
        $this->viewDirectory = env('VIEW_DIRECTORY');
        $this->horoscope = $horoscope;
    }

    public function build()
    {
        return $this->view('emails.daily-horoscope')
                    ->with([
                        'horoscope' => $this->horoscope,
                    ]);
    }
}
