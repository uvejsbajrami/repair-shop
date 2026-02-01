<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $name,
        public string $email,
        public string $phone,
        public string $messageContent
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Contact Message from ' . $this->name,
            replyTo: [$this->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
