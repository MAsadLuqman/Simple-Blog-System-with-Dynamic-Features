<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;

class SendAuthMail extends Mailable
{
    use Queueable, SerializesModels;

    public  $link;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct( $user)
    {
        $id= Crypt::encryptString($user->id);
        $time = Crypt::encryptString(now()->addMinutes(5));
        $this->user=$user;
        $this->link = route('sendmail', ['id' => $id, 'time' => $time]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Your Email Address',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'EmailSend',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
