<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Skill;
use App\Models\Endorsement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\EndorsementRequest;
use App\Events\EndorsementRequested;
use App\Http\Resources\EndorsementResource;
use App\Events\ExternalEndorsementRequested;
use App\Http\Requests\RequestEndorsementRequest;
use App\Http\Resources\EndorsementRequestResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EndorsementController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $endorsements = Endorsement::filter($request)->paginate($request->query('per_page', 10));

        return EndorsementResource::collection($endorsements);
    }

    public function skillEndorsements(Request $request, Skill $skill) 
    {
        $endorsements = auth()->user()->endorsements()
            ->where('skill_id', $skill->id)->with($request->query('with') ? explode(',', $request->query('with')) : [])
            ->paginate($request->query('per_page', 10));

        return EndorsementResource::collection($endorsements);
    }

    public function recentEndorsements(Request $request): AnonymousResourceCollection
    {
        $endorsements = auth()->user()->endorsements()->with($request->query('with') ? explode(',', $request->query('with')) : [])
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->paginate($request->query('per_page', 10));

        return EndorsementResource::collection($endorsements);
    }

    public function requestEndorsement(RequestEndorsementRequest $request) : void
    {
        $skill = Skill::find($request->skill);
        $requester = auth()->user();
        $requestee = User::find($request->requestee);
        $requestee_email = !$requestee ? $request->requestee_email : null;
        $title = $request->title;

        if (!$requestee_email) 
            event(new EndorsementRequested($requester, $requestee, $skill, $title));
         else 
            event(new ExternalEndorsementRequested($requester, $requestee_email, $skill, $title));
    }

    public function showEndorsementRequest(EndorsementRequest $endorsementRequest)
    {
        if ($endorsementRequest->isFilled())
            return response()->json(['message' => 'This endorsement request has already been filled'], 410);

        $endorsementRequest->load('skill');
        return new EndorsementRequestResource($endorsementRequest);
    }

    public function endorseEndorsementRequest(Request $request, EndorsementRequest $endorsementRequest)
    {
        $data = [
            'title' => $request->title,
            'supervisor_name' => $request->supervisor_name,
            'supervisor_position' => $request->supervisor_position,
            'supervisor_company' => $request->supervisor_company,
            'rating' => $request->rating,
            'feedback' => $request->feedback,
        ];
        $endorsementRequest->fulfill($data);
    }
    
}
