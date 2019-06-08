<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PleaseConfirmYourEmail extends Mailable 
{
    use Queueable, SerializesModels;

    /**
     * The user associated with the email.
     *
     * @var \App\Voter
     */
    public $voter;

    /**
     * Create a new mailable instance.
     *
     * @param \App\Voter $voter
     */
    public function __construct($voter)
    {
        $this->voter = $voter;
    }

    /**
     * Build the email.
     *
     * @return $this
     */
    public function build()
    {   
        $voter = $this->voter;

        return $this->markdown(
            'emails.confirm_email',
            compact('voter')
        );
    }
}
