<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::query()
            ->orderBy('order')
            ->get();

        return response()->json($services)->withHeaders([
            'Cache-Control' => 'public, max-age=300', // Cache for 5 minutes
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer'],
        ]);

        $service = Service::create($data);

        return response()->json($service, 201);
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'title' => ['sometimes', 'string', 'max:255'],
            'subtitle' => ['sometimes', 'nullable', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'icon' => ['sometimes', 'nullable', 'string', 'max:255'],
            'order' => ['sometimes', 'nullable', 'integer'],
        ]);

        $service->update($data);

        return response()->json($service->fresh());
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return response()->json(null, 204);
    }
}
