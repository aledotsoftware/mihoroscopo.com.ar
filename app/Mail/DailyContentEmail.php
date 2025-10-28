<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyContentEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $content;
    private $viewDirectory;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->viewDirectory = env('VIEW_DIRECTORY');
        $this->content = $content;
    }

    public function build()
    {
        return $this->subject('Tu horóscopo de hoy: ¿Qué te depara el destino? – Mi Horóscopo')
                    ->view( $this->viewDirectory.'/emails.daily_content')
                    ->with('content', $this->content);
    }
}
