<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Resources\FeedbackResource;
use App\Http\Requests\CreateFeedbackRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $feedbacks = Feedback::filter($request)->paginate($request->query('per_page', 10));

        return response()->json($feedbacks);
    }

    public function skillFeedback(Request $request, Skill $skill): AnonymousResourceCollection
    {
        $feedbacks = auth()->user()->feedbacks()
            ->where('skill_id', $skill->id)
            ->paginate($request->query('per_page', 10));
        $feedbacks->load('user', 'skill', 'createdBy');
        return FeedbackResource::collection($feedbacks);
    }

    public function store(CreateFeedbackRequest $request, Skill $skill)
    {
        $feedback = new Feedback($request->validated());
        $feedback->skill_id = $skill->id;
        $feedback->user_id = auth()->id();
        $feedback->created_by = auth()->id();
        $feedback->save();

        return new FeedbackResource($feedback);
    }
}
