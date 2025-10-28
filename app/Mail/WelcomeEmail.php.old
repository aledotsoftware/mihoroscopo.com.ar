<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    private $viewDirectory;


    public function __construct($name)
    {
        $this->name = $name;
        $this->viewDirectory = env('VIEW_DIRECTORY');
    }

    public function build()
    {
        return $this->view( $this->viewDirectory.'/emails.welcome')
                    ->with([
                        'name' => $this->name,
                    ]);
    }
}
