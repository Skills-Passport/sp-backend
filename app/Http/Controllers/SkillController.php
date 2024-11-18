<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Educator\SkillResource;
use App\Http\Requests\Educator\CreateSkillRequest;
use App\Http\Requests\Educator\UpdateSkillRequest;

class SkillController extends Controller
{
    public function index(Request $request)
    {
        $relations = $request->query('with') ? explode(',', $request->query('with')) : [];

        $skills = Skill::with($relations)->filter($request)->paginate($request->query('per_page', 10));

        $competencies = $request->user()->competencies()->toArray();
        return SkillResource::collection($skills)->additional(['meta' => ['competencies' => $competencies]]);
    }

    public function show(Skill $skill): JsonResponse
    {
        if (!$skill)
            return response()->json(['message' => 'Skill not found'], 404);

        return response()->json($skill);
    }

    public function store(CreateSkillRequest $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $skill = new Skill();
        $skill->name = $request->name;
        $skill->save();
        return response()->json($skill, 201);
    }

    public function update(UpdateSkillRequest $request, Skill $skill): JsonResponse
    {
        if (!$skill)
            return response()->json(['message' => 'Skill not found'], 404);

        $skill->update($request->all());

        return response()->json($skill);
    }

    public function destroy(Skill $skill): JsonResponse
    {
        if (!$skill)
            return response()->json(['message' => 'Skill not found'], 404);

        $skill->delete();
        return response()->json($skill);
    }
    public function addSkill(Request $request, Skill $skill)
    {
        $request->user()->skills()->attach($skill->id);
        return response()->json(['message' => 'Skill added successfully']);
    }
}
