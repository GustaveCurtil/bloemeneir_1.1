<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderConfirmed extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $weekday;
    public $formattedDate;
    public $uren;
    public $schattigNewVouchers;
    public $charmantNewVouchers;
    public $magnifiekNewVouchers;
    public $schattigOldVouchers;
    public $charmantOldVouchers;
    public $magnifiekOldVouchers;
    public $giftNewVoucher;
    public $giftOldVouchers;

    /**
     * Create a new message instance.
     */
public function __construct(
        $order,
        $weekday,
        $formattedDate,
        $uren,
        $schattigNewVouchers,
        $charmantNewVouchers,
        $magnifiekNewVouchers,
        $schattigOldVouchers,
        $charmantOldVouchers,
        $magnifiekOldVouchers,
        $giftNewVoucher,
        $giftOldVouchers
    ) {
        $this->order = $order;
        $this->weekday = $weekday;
        $this->formattedDate = $formattedDate;
        $this->uren = $uren;
        $this->schattigNewVouchers = $schattigNewVouchers;
        $this->charmantNewVouchers = $charmantNewVouchers;
        $this->magnifiekNewVouchers = $magnifiekNewVouchers;
        $this->schattigOldVouchers = $schattigOldVouchers;
        $this->charmantOldVouchers = $charmantOldVouchers;
        $this->magnifiekOldVouchers = $magnifiekOldVouchers;
        $this->giftNewVoucher = $giftNewVoucher;
        $this->giftOldVouchers = $giftOldVouchers;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '❀ Jouw boeketten bestelling ❀',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.bevestiging', // this is your Blade view
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
