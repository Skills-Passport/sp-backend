<?php

namespace App\Http\Controllers;

use App\Http\Resources\Educator\SkillResource as EducatorSkillResource;
use App\Http\Resources\Student\SkillResource as StudentSkillResource;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SkillController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $relations = $request->query('with') ? explode(',', $request->query('with')) : [];
        $relations[] = 'competency';
        $skills = Skill::with($relations)->filter($request)->paginate($request->query('per_page', 10));
        $competencies = $skills->pluck('competency')->unique()->values()->toArray();
        $resoruce = $this->getResource();

        return $resoruce::collection($skills)->additional(['meta' => ['competencies' => $competencies]]);
    }

    public function show(Skill $skill): StudentSkillResource|EducatorSkillResource
    {
        $resource = $this->getResource();

        $skill = Skill::with(['competency', 'competency.profiles'])->find($skill->id);

        return new $resource($skill);
    }

    public function addSkill(Request $request, Skill $skill): JsonResponse
    {
        $request->user()->skills()->attach($skill->id);

        return response()->json(['message' => 'Skill added successfully']);
    }

    public function skillTimeline(Request $request, Skill $skill): JsonResponse
    {
        $timeline = $skill->timeline()->paginate($request->query('per_page', 10));

        return response()->json($timeline);
    }

    public function getResource(): string
    {
        $Resoruce = request()->user()->hasRole('student') ? StudentSkillResource::class : EducatorSkillResource::class;

        return $Resoruce;
    }
}
