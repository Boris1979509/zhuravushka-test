<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class SuccessfulRegistration extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var User $user
     */
    public $user;

    /**
     * SuccessfulRegistration constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this->subject(__('SubjectRegisterTitle') )
            ->markdown('emails.auth.registration');
    }
}
