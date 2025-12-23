<?php

namespace App\Mail\Templates;

use App\Mail\Base\BaseMailTemplate;
use App\Models\ContactMessage;

/**
 * Email template for auto-reply to contact form submissions.
 */
class AutoReplyTemplate extends BaseMailTemplate
{
    public function __construct(
        private readonly ContactMessage $contact,
        private readonly string $ownerName
    ) {}

    protected function buildContent(): string
    {
        $name = $this->escape($this->contact->name);
        $message = $this->escape($this->contact->message);
        $ownerName = $this->escape($this->ownerName);

        return
            $this->header(
                title: "Thank You, {$name}!",
                subtitle: 'Your message has been received successfully.',
                icon: '✓'
            ) .
            $this->content(
                $this->paragraph("Hi {$name},") .
                $this->paragraph('Thank you for reaching out! I\'ve received your message and I\'m excited to learn more about your project.') .
                $this->paragraph('I typically respond within <strong>24-48 hours</strong>. In the meantime, feel free to check out my portfolio to see more of my work.') .
                $this->highlightBox('Your Message Summary', $message) .
                $this->signature($ownerName)
            ) .
            $this->footer('This is an automated response. Please do not reply to this email.');
    }
}

