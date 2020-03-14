<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RestPass extends Mailable
{
    use Queueable, SerializesModels;

    public $UserToken;

    /**
     * Create a new message instance.
     * 
     *
     * @return void
     */
    public function __construct($UserToken)
    {
        //
        $this->UserToken=$UserToken;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('RestPassMail')
        ->from('deadman962011@localhost.com');

    }
}
