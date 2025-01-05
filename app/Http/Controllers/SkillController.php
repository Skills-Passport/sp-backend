<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\Skill;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\SkillResource;
use App\Http\Resources\TimelineResource;
use App\Http\Requests\UpdateRatingRequest;
use App\Http\Requests\CreateUpdateSkillRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SkillController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $skills = Skill::with($this->loadRelations($request))->filter($request)->paginate($request->query('per_page', 10));
        $competencies = $skills->filter(function ($skill) {
            return $skill->competency && is_null($skill->competency->deleted_at);
        })->pluck('competency')->unique()->values()->toArray();
        return SkillResource::collection($skills)->additional(['meta' => ['competencies' => $competencies]]);
    }

    public function show(Request $request, Skill $skill): SkillResource
    {

        $skill = Skill::with($this->loadRelations($request, ['competency', 'competency.profiles', 'groups']))->find($skill->id);

        return new SkillResource($skill);
    }

    public function create(CreateUpdateSkillRequest $request): SkillResource
    {
        $skill = Skill::create($request->all());

        return new SkillResource($skill->load('competency'));
    }

    public function update(CreateUpdateSkillRequest $request, Skill $skill): SkillResource
    {
        $skill->update($request->all());

        return new SkillResource($skill->load('competency'));
    }

    public function destroy(Skill $skill): JsonResponse
    {
        if (!auth()->user()->hasPermissionTo('delete skills')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $skill->delete();

        return response()->json(['message' => 'Skill deleted successfully']);
    }

    public function addSkill(Request $request, Skill $skill): JsonResponse
    {
        if ($request->user()->skills->contains($skill)) {
            return response()->json(['message' => 'Skill already added'], 400);
        }
        $request->user()->skills()->attach($skill->id);

        return response()->json(['message' => 'Skill added successfully']);
    }

    public function skillTimeline(Request $request, Skill $skill): AnonymousResourceCollection
    {
        $timelines = $skill->timeline($request->user())->with(['timelineable', 'timelineable.createdBy'])->get();
        $timelines = $timelines->map(function ($timeline) {
            $timeline->type = class_basename($timeline->timelineable_type);

            return $timeline;
        });

        return TimelineResource::collection($timelines);
    }

    public function StudentSkillTimeline(Request $request, User $student, Skill $skill): AnonymousResourceCollection
    {
        $timelines = $skill->timeline($student)->with(['timelineable', 'timelineable.createdBy'])->get();
        $timelines = $timelines->map(function ($timeline) {
            $timeline->type = class_basename($timeline->timelineable_type);

            return $timeline;
        });

        return TimelineResource::collection($timelines);
    }

    public function updateRating(UpdateRatingRequest $request, Skill $skill): JsonResponse
    {
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
            'title' => 'Rating updated',
            'content' => $request->feedback,
        ]);
        $request->user()->skills()->updateExistingPivot($skill->id, ['last_rating' => $request->rating]);

        return response()->json(['message' => 'Rating updated successfully']);
    }

    public function groupSkills(Request $request, Group $group): AnonymousResourceCollection
    {
        $user_skills = $request->user()->skills->pluck('id');
        $skills = $group->skills()->whereIn('id', $user_skills)->get();

        return SkillResource::collection($skills);
    }

    public function studentSkill(Request $request, User $student, Skill $skill): SkillResource
    {
        $skill = $student->skills()->where('skill_id', $skill->id)->withPivot('last_rating')->first();

        if (!$skill->exists()) {
            return response()->json(['message' => 'Skill already added'], 400);
        }
        $skill->load($this->loadRelations($request, ['competency', 'groups']));

        return new SkillResource($skill);
    }
}
