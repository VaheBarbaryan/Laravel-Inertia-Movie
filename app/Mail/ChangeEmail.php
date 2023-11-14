<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChangeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $body;
    public $subject;

    public function __construct($subject, $body)
    {
        $this->body = $body;
        $this->subject = $subject;
    }

    public function build() {
        return $this->subject($this->subject)
            ->view('emails.changeEmail')
            ->with($this->body);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
//    public function envelope()
//    {
//        return new Envelope(
//            subject: 'Change Email',
//        );
//    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
//    public function content()
//    {
//        return new Content(
//            view: 'view.name',
//        );
//    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
