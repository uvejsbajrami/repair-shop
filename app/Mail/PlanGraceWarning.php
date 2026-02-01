<?php

namespace App\Mail;

use App\Models\Shop;
use App\Models\ShopPlan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PlanGraceWarning extends Mailable
{
    use Queueable, SerializesModels;

    public int $daysLeft;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Shop $shop,
        public ShopPlan $shopPlan,
    ) {
        $this->daysLeft = now()->diffInDays($this->shopPlan->grace_ends_at, false);
        if ($this->daysLeft < 0) {
            $this->daysLeft = 0;
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Warning: Your {$this->shopPlan->plan->name} Plan is in Grace Period - MobileShop",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.plan-grace-warning',
            with: [
                'shop' => $this->shop,
                'shopPlan' => $this->shopPlan,
                'plan' => $this->shopPlan->plan,
                'daysLeft' => $this->daysLeft,
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
