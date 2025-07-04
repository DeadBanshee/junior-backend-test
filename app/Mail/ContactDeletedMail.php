<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactDeletedMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $contact;

    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    public function build()
    {
        return $this->subject('Your contact has been deleted from our list')
                    ->view('contact_deleted');
    }
}
