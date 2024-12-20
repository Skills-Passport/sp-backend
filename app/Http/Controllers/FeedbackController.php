<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\Skill;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\FeedbackRequest;
use App\Events\FeedbackAnswered;
use App\Events\FeedbackRequested;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\FeedbackResource;
use App\Http\Requests\CreateFeedbackRequest;
use App\Http\Requests\RequestFeedbackRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FeedbackController extends Controller
{
    public function index(Request $request) : AnonymousResourceCollection
    {
        $feedbacks = Feedback::filter($request)->paginate($request->query('per_page', 10));

        return FeedbackResource::collection($feedbacks);
    }

    public function skillFeedback(Request $request, Skill $skill): AnonymousResourceCollection
    {
        $feedbacks = auth()->user()->feedbacks()
            ->where('skill_id', $skill->id)->with($request->query('with') ? explode(',', $request->query('with')) : [])
            ->paginate($request->query('per_page', 10));
        return FeedbackResource::collection($feedbacks);
    }

    public function ratingUpdateFeedback(CreateFeedbackRequest $request, Skill $skill) : FeedbackResource
    {
        $feedback = new Feedback($request->validated());
        $feedback->skill_id = $skill->id;
        $feedback->user_id = auth()->id();
        $feedback->created_by = auth()->id();
        $feedback->save();

        return new FeedbackResource($feedback);
    }

    public function requestFeedback(RequestFeedbackRequest $request) : JsonResponse
    {
        $skill = Skill::find($request->skill_id);
        $requestee = User::find($request->user_id);
        $group = $request->group_id ? Group::find($request->group_id) : null;

        event(new FeedbackRequested($request->user(), $requestee, $skill, $request->title, $group));

        return response()->json(['message' => 'Feedback request sent successfully']);
    }

    public function respondFeedbackRequest(Request $request, FeedbackRequest $feedbackRequest) : JsonResponse
    {
        $request->validate([
            'content' => 'required|string',
        ]);
        if ($feedbackRequest->recipient_id !== auth()->id()) 
            return response()->json(['message' => 'Feedback request not found'], 404);

        $feedbackRequest->update(['status' => FeedbackRequest::STATUS_ANSWERED]);
        event(new FeedbackAnswered($request->content, $request->title, $feedbackRequest));
        return response()->json(['message' => 'Feedback sent successfully']);
    }
}
