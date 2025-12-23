<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Services\ContactService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function __construct(
        private ContactService $contactService
    ) {}

    /**
     * Store a new contact message.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'service_type' => ['nullable', 'in:frontend,backend,fullstack'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        $contact = $this->contactService->store($validated);

        return response()->json([
            'message' => 'Thank you, your message has been sent.',
            'data' => $contact,
        ], 201);
    }

    /**
     * List all contact messages (admin only).
     */
    public function index(): JsonResponse
    {
        $contacts = $this->contactService->getAll();

        return response()->json($contacts);
    }

    /**
     * Update contact message status (admin only).
     */
    public function updateStatus(Request $request, ContactMessage $contact): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:new,read,archived'],
        ]);

        $contact = $this->contactService->updateStatus($contact, $validated['status']);

        return response()->json($contact);
    }
}
