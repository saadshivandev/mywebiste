<?php

namespace App\Mail;

use App\Mail\Templates\NotificationTemplate;
use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Notification email sent to the portfolio owner when someone submits the contact form.
 */
class ContactNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ContactMessage $contact
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New Contact: {$this->contact->name}",
        );
    }

    public function content(): Content
    {
        $template = new NotificationTemplate($this->contact);

        return new Content(
            htmlString: $template->render(),
        );
    }
}
