<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::query()
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        return response()->json($skills)->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'level' => ['nullable', 'integer'],
            'order' => ['nullable', 'integer'],
        ]);

        $skill = Skill::create($data);

        return response()->json($skill, 201);
    }

    public function update(Request $request, Skill $skill)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'category' => ['sometimes', 'nullable', 'string', 'max:255'],
            'level' => ['sometimes', 'nullable', 'integer'],
            'order' => ['sometimes', 'nullable', 'integer'],
        ]);

        $skill->update($data);

        return response()->json($skill->fresh());
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return response()->json(null, 204);
    }
}
