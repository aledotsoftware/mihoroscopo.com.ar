<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyRemarketingEmail extends Mailable
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
        $this->content = $content;
        $this->viewDirectory = env('VIEW_DIRECTORY');
    }

    public function build()
    {
        return $this->subject('Activa tu suscripción, ¡tu horóscopo te espera! – Mi Horóscopo')
                    ->view($this->viewDirectory . '/emails.daily_remarketing')
                    ->with('content', $this->content);
    }
}
