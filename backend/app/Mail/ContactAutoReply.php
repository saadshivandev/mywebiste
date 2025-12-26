<?php

namespace App\Mail;

use App\Mail\Templates\AutoReplyTemplate;
use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Auto-reply email sent to users who submit the contact form.
 */
class ContactAutoReply extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ContactMessage $contact,
        public string $ownerName = 'Saad'
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Thank you for reaching out, {$this->contact->name}! / Bedankt voor uw bericht!",
        );
    }

    public function content(): Content
    {
        $template = new AutoReplyTemplate($this->contact, $this->ownerName);

        return new Content(
            htmlString: $template->render(),
        );
    }
}
