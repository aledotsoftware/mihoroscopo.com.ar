<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subscription;
    private $viewDirectory;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subscription)
    {
        $this->subscription = $subscription;
        $this->viewDirectory = env('VIEW_DIRECTORY');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('¡Tu suscripción a Mi Horóscopo ha sido confirmada!')
                    ->view( $this->viewDirectory.'/emails.subscription_confirmation')
                    ->with('subscription', $this->subscription);
    }
}
