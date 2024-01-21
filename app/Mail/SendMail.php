<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Modules\MailApplications\Models\MailApplication;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public MailApplication $mailApplication;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(MailApplication $mailApplication)
    {
        $this->mailApplication = $mailApplication;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->subject('Сообщение от модератора')->from('info@site.ru', 'info@site.ru')->view(
            'Mail.Message',
            [
                'name' => $this->mailApplication->application->name,
                'mess' => $this->mailApplication->text,
            ]
        );
    }
}
