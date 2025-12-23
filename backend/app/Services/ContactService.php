<?php

namespace App\Services;

use App\Mail\ContactAutoReply;
use App\Mail\ContactNotification;
use App\Models\ContactMessage;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Service class for handling contact message operations.
 */
class ContactService
{
    /**
     * Store a new contact message and send notification emails.
     */
    public function store(array $data): ContactMessage
    {
        $contact = ContactMessage::create($data);

        $this->sendEmails($contact);

        return $contact;
    }

    /**
     * Get all contact messages ordered by newest first.
     */
    public function getAll(): Collection
    {
        return ContactMessage::query()
            ->latest()
            ->get();
    }

    /**
     * Update the status of a contact message.
     */
    public function updateStatus(ContactMessage $contact, string $status): ContactMessage
    {
        $contact->status = $status;

        if ($status === 'read' && ! $contact->read_at) {
            $contact->read_at = now();
        }

        $contact->save();

        return $contact->fresh();
    }

    // =========================================================================
    // EMAIL METHODS
    // =========================================================================

    /**
     * Send all notification emails for a new contact message.
     */
    private function sendEmails(ContactMessage $contact): void
    {
        $this->sendOwnerNotification($contact);
        $this->sendAutoReply($contact);
    }

    /**
     * Send notification email to the portfolio owner.
     */
    private function sendOwnerNotification(ContactMessage $contact): void
    {
        $recipient = config('mail.contact_notification_email');

        if (! $recipient) {
            Log::warning('ContactService: Owner notification email not configured', [
                'hint' => 'Set CONTACT_NOTIFICATION_EMAIL in .env',
            ]);
            return;
        }

        $this->sendEmail(
            recipient: $recipient,
            mailable: new ContactNotification($contact),
            context: 'owner notification',
            contactId: $contact->id
        );
    }

    /**
     * Send auto-reply thank you email to the person who submitted the form.
     */
    private function sendAutoReply(ContactMessage $contact): void
    {
        $ownerName = $this->getOwnerName();

        $this->sendEmail(
            recipient: $contact->email,
            mailable: new ContactAutoReply($contact, $ownerName),
            context: 'auto-reply',
            contactId: $contact->id
        );
    }

    /**
     * Send an email with error handling and logging.
     */
    private function sendEmail(
        string $recipient,
        object $mailable,
        string $context,
        int $contactId
    ): void {
        try {
            Mail::to($recipient)->send($mailable);

            Log::info("ContactService: Sent {$context} email", [
                'contact_id' => $contactId,
                'recipient' => $recipient,
            ]);
        } catch (\Throwable $e) {
            Log::error("ContactService: Failed to send {$context} email", [
                'contact_id' => $contactId,
                'recipient' => $recipient,
                'error' => $e->getMessage(),
            ]);
        }
    }

    // =========================================================================
    // HELPER METHODS
    // =========================================================================

    /**
     * Get the portfolio owner's name from the profile.
     */
    private function getOwnerName(): string
    {
        $profile = Profile::first();

        return $profile?->name ?? 'Saad';
    }
}
