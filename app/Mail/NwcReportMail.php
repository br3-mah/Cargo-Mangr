<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NwcReportMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public readonly array $summary,
        public readonly array $fileInfo
    ) {
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        $periodStart = $this->summary['period_start'] ?? null;
        $periodEnd = $this->summary['period_end'] ?? null;

        $subject = 'NWC Daily Report';
        if ($periodStart && $periodEnd) {
            $subject .= sprintf(
                ' (%s - %s)',
                $periodStart->toDateString(),
                $periodEnd->toDateString()
            );
        }

        return $this->subject($subject)
            ->view('emails.nwc-report', [
                'summary' => $this->summary,
            ])
            ->attachFromStorageDisk(
                $this->fileInfo['disk'],
                $this->fileInfo['path'],
                $this->fileInfo['filename'],
                ['mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
            );
    }
}
