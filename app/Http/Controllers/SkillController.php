<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\Feedback;
use App\Models\Timeline;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateRatingRequest;
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
        $studentId = $request->user()->id;
        $timelines = $skill->timeline()->whereHas('timelineable', function ($query) use ($studentId) {
            $query->where('user_id', $studentId);
        })->paginate($request->query('per_page', 10));

        return response()->json($timelines);
    }

    public function getResource(): string
    {
        $Resoruce = request()->user()->hasRole('student') ? StudentSkillResource::class : EducatorSkillResource::class;

        return $Resoruce;
    }

    public function updateRating(UpdateRatingRequest $request, Skill $skill): JsonResponse
    {
        DB::transaction(function () use ($request, $skill) {
            $user = $request->user();

            $userSkillPivot = $user->skills()->where('skill_id', $skill->id)->first()->pivot;

            $user->ratings()->create([
                'skill_id' => $skill->id,
                'previous_rating' => $userSkillPivot->last_rating,
                'new_rating' => $request->rating,
            ]);
            Feedback::create([
                'user_id' => $request->user()->id,
                'skill_id' => $skill->id,
                'created_by' => $request->user()->id,
                'title' => 'Rating updated',
                'content' => $request->feedback,
            ]);

            $request->user()->skills()->updateExistingPivot($skill->id, ['last_rating' => $request->rating]);
        });

        return response()->json(['message' => 'Rating updated successfully']);
    }
}
