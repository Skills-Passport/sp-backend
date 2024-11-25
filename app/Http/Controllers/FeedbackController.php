<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Skill;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $feedbacks = auth()->user()->receivedFeedbacks()
            ->where('skill_id', $skill->id)
            ->paginate($request->query('per_page', 10));
        return FeedbackResource::collection($feedbacks);
    }
}
