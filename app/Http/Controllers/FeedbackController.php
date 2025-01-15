<?php

namespace App\Http\Controllers;

use App\Events\FeedbackAnswered;
use App\Events\FeedbackRequested;
use App\Http\Requests\CreateFeedbackRequest;
use App\Http\Requests\RequestFeedbackRequest;
use App\Http\Requests\RespondFeedbackRequest;
use App\Http\Resources\FeedbackResource;
use App\Models\Feedback;
use App\Models\FeedbackRequest;
use App\Models\Group;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FeedbackController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $feedbacks = Feedback::filter($request)->paginate($request->query('per_page', 10));

        return FeedbackResource::collection($feedbacks);
    }

    public function skillFeedback(Request $request, Skill $skill): AnonymousResourceCollection
    {
        $feedbacks = auth()->user()->feedbacks()
            ->where('skill_id', $skill->id)->with($this->loadRelations($request))
            ->paginate($request->query('per_page', 10));

        return FeedbackResource::collection($feedbacks);
    }

    public function ratingUpdateFeedback(CreateFeedbackRequest $request, Skill $skill): FeedbackResource
    {
        $feedback = new Feedback($request->safe());
        $feedback->skill_id = $skill->id;
        $feedback->user_id = auth()->id();
        $feedback->created_by = auth()->id();
        $feedback->save();

        return new FeedbackResource($feedback);
    }

    public function recentFeedbacks(Request $request, ?User $user = null): AnonymousResourceCollection
    {
        if (! $user) {
            $user = auth()->user();
        }
        $feedbacks = $user->feedbacks()->filter($request)->with($this->loadRelations($request))
            ->where('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->paginate($request->query('per_page', 10));

        return FeedbackResource::collection($feedbacks);
    }

    public function requestFeedback(RequestFeedbackRequest $request): JsonResponse
    {
        $skill = Skill::find($request->skill_id);
        $requestee = User::find($request->user_id);
        $group = $request->group_id ? Group::find($request->group_id) : null;

        event(new FeedbackRequested($request->user(), $requestee, $skill, $request->title, $group));

        return response()->json(['message' => 'Feedback request sent successfully']);
    }

    public function respondFeedbackRequest(RespondFeedbackRequest $request, FeedbackRequest $feedbackRequest): JsonResponse
    {
        if ($feedbackRequest->recipient_id !== auth()->id()) {
            return response()->json(['message' => 'Feedback request not found'], 404);
        }

        $feedbackRequest->update(['status' => FeedbackRequest::STATUS_ANSWERED]);
        event(new FeedbackAnswered($request->content, $request->title, $feedbackRequest));

        return response()->json(['message' => 'Feedback sent successfully']);
    }

    public function studentSkillFeedbacks(Request $request, User $student, Skill $skill): AnonymousResourceCollection
    {
        $feedbacks = $student->feedbacks()->filter($request)->with($this->loadRelations($request))
            ->where('skill_id', $skill->id)
            ->paginate($request->query('per_page', 10));

        return FeedbackResource::collection($feedbacks);
    }
}
