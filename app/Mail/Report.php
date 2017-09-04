<?php

namespace chemiatria\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use chemiatria\User;

class Report extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $states;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $states)
    {
        //
        $this->user = $user;
        $this->states = $states;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      //dd($this->states);
        return $this->subject('Update from Chemiatria on ' . $this->user->name)
            ->view('emails.update');
    }
}
