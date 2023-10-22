<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PublicMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public $details, public $subject, public $from, public $files){}

    public function envelope(): Envelope
    {
        return new Envelope(
            from : new Address($this->from[0]['address'], $this->from[0]['name']),
            subject: $this->subject,
        );
    }

    public function content(): Content
    {
        return new Content(markdown : 'public-mail');
    }

    public function attachments(): array
    {
        $attachments = [];
        if ($this->files) {
            foreach ($this->files as $file => $name) {
                array_push($attachments, Attachment::fromPath(public_path($file))
                    ->as($name['name'])->withMime($name['mime']));
            }
        }

        return $attachments;
    }
}
