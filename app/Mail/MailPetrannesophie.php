<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailPetrannesophie extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $weekday;
    public $formattedDate;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, $weekday, $formattedDate)
    {
        $this->order = $order;
        $this->weekday = $weekday;
        $this->formattedDate = $formattedDate;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '❀ Nieuwe bestelling ❀',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.bestelling_voltooid', // this is your Blade view
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
