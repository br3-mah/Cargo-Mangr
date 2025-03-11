<?php

namespace Modules\Cargo\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketSupportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticketData;

    /**
     * Create a new message instance.
     */
    public function __construct($ticketData)
    {
        $this->ticketData = $ticketData;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        try {

            $email = $this->from('noreply@newworldcargo.com', 'Newworld Cargo Support')
            // ->to('nyeleti.bremah@gmail.com')
            ->to('info@newworldcargo.com')
            ->subject('New Support Ticket - ' . $this->ticketData['subject'])
            ->view('cargo::emails.ticket_support')
            ->with(['ticketData' => $this->ticketData]);

        } catch (\Throwable $th) {
            dd($th);
        }

        return $email;
    }
}