<?php

namespace App\Mail;

use App\Models\Shop;
use App\Models\ShopPlan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PlanExpired extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Shop $shop,
        public ShopPlan $shopPlan,
    ) {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Your {$this->shopPlan->plan->name} Plan Has Expired - MobileShop",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.plan-expired',
            with: [
                'shop' => $this->shop,
                'shopPlan' => $this->shopPlan,
                'plan' => $this->shopPlan->plan,
            ],
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
