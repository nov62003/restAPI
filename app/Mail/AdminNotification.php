<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $user;

    public function __construct($user) {
        $this->user = $user;
    }

    public function build() {
        return $this->subject("New User Created")
                    ->view("emails.admin_notification");
    }
}