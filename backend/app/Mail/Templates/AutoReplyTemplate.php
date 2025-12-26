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
                title: "Thank You, {$name}! / Bedankt, {$name}!",
                subtitle: 'Your message has been received successfully. / Uw bericht is succesvol ontvangen.',
                icon: '✓'
            ) .
            $this->content(
                // English Section
                $this->languageSection('English', [
                    "Hi {$name},",
                    'Thank you for reaching out! I\'ve received your message and I\'m excited to learn more about your project.',
                    'I typically respond within <strong>24-48 hours</strong>. In the meantime, feel free to check out my portfolio to see more of my work.',
                ]) .
                // Dutch Section
                $this->languageSection('Nederlands', [
                    "Hallo {$name},",
                    'Bedankt voor uw bericht! Ik heb uw bericht ontvangen en ik kijk ernaar uit om meer over uw project te leren.',
                    'Ik reageer meestal binnen <strong>24-48 uur</strong>. Bekijk ondertussen gerust mijn portfolio om meer van mijn werk te zien.',
                ]) .
                // Message Summary (Bilingual)
                $this->highlightBox('Your Message Summary / Uw Bericht Samenvatting', $message) .
                // Signature (Bilingual)
                $this->signatureBilingual($ownerName)
            ) .
            $this->footer('This is an automated response. Please do not reply to this email. / Dit is een automatisch antwoord. Reageer alstublieft niet op deze e-mail.');
    }

    /**
     * Create a language section with title and paragraphs.
     */
    private function languageSection(string $language, array $paragraphs): string
    {
        $border = self::COLORS['border'];
        $heading = self::COLORS['heading'];
        $text = self::COLORS['text'];
        
        $paragraphsHtml = '';
        foreach ($paragraphs as $index => $text) {
            $isLast = $index === count($paragraphs) - 1;
            $paragraphsHtml .= $this->paragraph($text, $isLast);
        }
        
        return <<<HTML
        <div style="margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid {$border};">
            <h2 style="margin: 0 0 16px; font-size: 18px; font-weight: 600; color: {$heading};">{$language}</h2>
            {$paragraphsHtml}
        </div>
        HTML;
    }

    /**
     * Create a bilingual signature.
     */
    private function signatureBilingual(string $name): string
    {
        $text = self::COLORS['text'];
        $heading = self::COLORS['heading'];

        return <<<HTML
        <p style="margin: 24px 0 0; font-size: 15px; color: {$text}; line-height: 1.6;">
            Looking forward to connecting with you soon!<br>
            <span style="color: {$text};">Ik kijk ernaar uit om binnenkort contact met u op te nemen!</span>
        </p>
        <p style="margin: 20px 0 0; font-size: 15px; color: {$text};">
            Best regards / Met vriendelijke groet,<br>
            <strong style="color: {$heading};">{$name}</strong>
        </p>
        HTML;
    }
}

