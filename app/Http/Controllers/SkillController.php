<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\Student\SkillResource as StudentSkillResource;
use App\Http\Resources\Educator\SkillResource as EducatorSkillResource;


class SkillController extends Controller
{

    public function index(Request $request): AnonymousResourceCollection
    {
        $relations = $request->query('with') ? explode(',', $request->query('with')) : [];
        $relations[] = 'competency';
        $skills = Skill::with($relations)->filter($request)->paginate($request->query('per_page', 10));
        $competencies = $request->user()->competencies();
        $resoruce = $this->getResource();
        return $resoruce::collection($skills)->additional(['meta' => ['competencies' => $competencies]]);
    }

    public function show(Skill $skill): StudentSkillResource|EducatorSkillResource
    {
        $resource = $this->getResource();

        $skill = auth()->user()->skills()
            ->where('skills.id', $skill->id)
            ->with(['competency', 'competency.profiles'])
            ->firstOrFail();

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