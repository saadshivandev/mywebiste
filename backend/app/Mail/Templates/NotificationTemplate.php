<?php

namespace App\Mail\Templates;

use App\Mail\Base\BaseMailTemplate;
use App\Models\ContactMessage;

/**
 * Email template for notifying portfolio owner of new contact.
 */
class NotificationTemplate extends BaseMailTemplate
{
    public function __construct(
        private readonly ContactMessage $contact
    ) {}

    protected function buildContent(): string
    {
        $contact = $this->contact;

        return
            $this->simpleHeader(
                title: 'New Contact Message',
                subtitle: 'Someone submitted your portfolio contact form.'
            ) .
            $this->content($this->buildDetails()) .
            $this->footer('Sent from your portfolio contact form');
    }

    private function buildDetails(): string
    {
        $contact = $this->contact;

        $html = "<div style=\"font-size: 14px; color: #334155; line-height: 1.6;\">";

        // Name
        $html .= $this->detailRow('Name', $this->escape($contact->name));

        // Email (as link)
        $html .= $this->detailRow('Email', $this->escape($contact->email), isLink: true);

        // Service type (optional)
        if ($contact->service_type) {
            $html .= $this->detailRow('Service', ucfirst($contact->service_type) . ' Developer');
        }

        // Subject (optional)
        if ($contact->subject) {
            $html .= $this->detailRow('Subject', $this->escape($contact->subject));
        }

        // Divider and message
        $html .= $this->divider();
        $html .= "<p style=\"margin: 0 0 8px;\"><strong>Message:</strong></p>";
        $html .= "<div style=\"background-color: #f8fafc; padding: 16px; border-radius: 8px; white-space: pre-wrap; color: #475569;\">{$this->escape($contact->message)}</div>";

        $html .= "</div>";

        return $html;
    }
}

