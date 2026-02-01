<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PlanApplicationApproveOrReject extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public $application,
        public $plan,
        public $rejectionMessage = null,
        public $planEndAt = null,
    ) {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $status = $this->application->status === 'approved' ? 'Approved' : 'Rejected';

        return new Envelope(
            subject: "Application {$status} - {$this->plan->name}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.application-approved-rejected',
            with: [
                'application' => $this->application,
                'plan' => $this->plan,
                'rejectionMessage' => $this->rejectionMessage,
                'planEndAt' => $this->planEndAt,
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
