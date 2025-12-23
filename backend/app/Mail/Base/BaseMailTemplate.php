<?php

namespace App\Mail\Base;

/**
 * Base email template with reusable components and styles.
 * All email templates should extend this class.
 */
abstract class BaseMailTemplate
{
    /**
     * Brand colors for consistent styling.
     */
    protected const COLORS = [
        'primary' => '#14b8a6',
        'primary_dark' => '#0d9488',
        'text' => '#334155',
        'text_light' => '#64748b',
        'text_muted' => '#94a3b8',
        'heading' => '#0f172a',
        'background' => '#f8fafc',
        'card' => '#ffffff',
        'border' => '#e2e8f0',
        'link' => '#2563eb',
    ];

    /**
     * Build the complete email HTML.
     */
    abstract protected function buildContent(): string;

    /**
     * Get the email HTML wrapped in the base layout.
     */
    public function render(): string
    {
        return $this->wrapInLayout($this->buildContent());
    }

    /**
     * Wrap content in the email layout.
     */
    protected function wrapInLayout(string $content): string
    {
        $bg = self::COLORS['background'];
        $card = self::COLORS['card'];

        return <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background-color: {$bg};">
            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: {$bg}; padding: 32px 16px;">
                <tr>
                    <td align="center">
                        <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 560px; background-color: {$card}; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                            {$content}
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        HTML;
    }

    // =========================================================================
    // REUSABLE COMPONENTS
    // =========================================================================

    /**
     * Create a header section with icon.
     */
    protected function header(string $title, string $subtitle, ?string $icon = null): string
    {
        $border = self::COLORS['border'];
        $heading = self::COLORS['heading'];
        $textLight = self::COLORS['text_light'];
        $primary = self::COLORS['primary'];
        $primaryDark = self::COLORS['primary_dark'];

        $iconHtml = $icon
            ? "<div style=\"width: 60px; height: 60px; margin: 0 auto 16px; background: linear-gradient(135deg, {$primary} 0%, {$primaryDark} 100%); border-radius: 50%; line-height: 60px; font-size: 28px; color: white; text-align: center;\">{$icon}</div>"
            : '';

        return <<<HTML
        <tr>
            <td style="padding: 32px 32px 24px; text-align: center; border-bottom: 1px solid {$border};">
                {$iconHtml}
                <h1 style="margin: 0; font-size: 24px; font-weight: 600; color: {$heading};">{$title}</h1>
                <p style="margin: 12px 0 0; font-size: 15px; color: {$textLight};">{$subtitle}</p>
            </td>
        </tr>
        HTML;
    }

    /**
     * Create a simple header without icon.
     */
    protected function simpleHeader(string $title, string $subtitle): string
    {
        $border = self::COLORS['border'];
        $heading = self::COLORS['heading'];
        $textLight = self::COLORS['text_light'];

        return <<<HTML
        <tr>
            <td style="padding: 32px 32px 24px; border-bottom: 1px solid {$border};">
                <h1 style="margin: 0; font-size: 20px; font-weight: 600; color: {$heading};">{$title}</h1>
                <p style="margin: 8px 0 0; font-size: 14px; color: {$textLight};">{$subtitle}</p>
            </td>
        </tr>
        HTML;
    }

    /**
     * Create a content section.
     */
    protected function content(string $html): string
    {
        return <<<HTML
        <tr>
            <td style="padding: 32px;">
                {$html}
            </td>
        </tr>
        HTML;
    }

    /**
     * Create a paragraph.
     */
    protected function paragraph(string $text, bool $isLast = false): string
    {
        $color = self::COLORS['text'];
        $margin = $isLast ? '0' : '0 0 20px';

        return "<p style=\"margin: {$margin}; font-size: 15px; color: {$color}; line-height: 1.6;\">{$text}</p>";
    }

    /**
     * Create a highlighted box (for quotes, summaries, etc).
     */
    protected function highlightBox(string $label, string $content): string
    {
        $bg = self::COLORS['background'];
        $textLight = self::COLORS['text_light'];
        $text = self::COLORS['text'];

        return <<<HTML
        <div style="background-color: {$bg}; border-radius: 8px; padding: 20px; margin: 24px 0;">
            <p style="margin: 0 0 12px; font-size: 13px; font-weight: 600; color: {$textLight}; text-transform: uppercase; letter-spacing: 0.5px;">{$label}</p>
            <p style="margin: 0; font-size: 14px; color: {$text}; line-height: 1.6; white-space: pre-wrap;">{$content}</p>
        </div>
        HTML;
    }

    /**
     * Create a detail row (label: value).
     */
    protected function detailRow(string $label, string $value, bool $isLink = false): string
    {
        $link = self::COLORS['link'];

        $valueHtml = $isLink
            ? "<a href=\"mailto:{$value}\" style=\"color: {$link}; text-decoration: none;\">{$value}</a>"
            : $value;

        return "<p style=\"margin: 0 0 12px;\"><strong>{$label}:</strong> {$valueHtml}</p>";
    }

    /**
     * Create a divider.
     */
    protected function divider(): string
    {
        $border = self::COLORS['border'];

        return "<hr style=\"border: none; border-top: 1px solid {$border}; margin: 20px 0;\">";
    }

    /**
     * Create a signature.
     */
    protected function signature(string $name, string $closing = 'Best regards'): string
    {
        $text = self::COLORS['text'];
        $heading = self::COLORS['heading'];

        return <<<HTML
        <p style="margin: 24px 0 0; font-size: 15px; color: {$text}; line-height: 1.6;">Looking forward to connecting with you soon!</p>
        <p style="margin: 20px 0 0; font-size: 15px; color: {$text};">{$closing},<br><strong style="color: {$heading};">{$name}</strong></p>
        HTML;
    }

    /**
     * Create a footer section.
     */
    protected function footer(string $text): string
    {
        $border = self::COLORS['border'];
        $muted = self::COLORS['text_muted'];

        return <<<HTML
        <tr>
            <td style="padding: 24px 32px; border-top: 1px solid {$border}; text-align: center;">
                <p style="margin: 0; font-size: 13px; color: {$muted};">{$text}</p>
            </td>
        </tr>
        HTML;
    }

    // =========================================================================
    // UTILITIES
    // =========================================================================

    /**
     * Escape HTML special characters.
     */
    protected function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}

