<?php

namespace App\Mail;

use App\Models\Repair;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class SendRepairTrackCode extends Mailable
{
    use Queueable, SerializesModels;

    public Repair $repair;
    public string $shopLocale;

    public function __construct(Repair $repair)
    {
        $this->repair = $repair->load('shop.settings');
        $this->shopLocale = $this->repair->shop?->settings?->language_code ?? 'en';
    }

    public function envelope(): Envelope
    {
        App::setLocale($this->shopLocale);

        return new Envelope(
            subject: __('emails.repair_tracking_subject'),
        );
    }

    public function content(): Content
    {
        App::setLocale($this->shopLocale);

        return new Content(
            view: 'emails.send-repair-track-code',
            with: [
                'repair' => $this->repair,
                'trackingUrl' => url('/track-repair?tracking_code=' . $this->repair->tracking_code),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
