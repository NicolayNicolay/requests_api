<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $text;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $text)
    {
        $this->text = $text;
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
                'mess' => $this->text,
            ]
        );
    }
}
