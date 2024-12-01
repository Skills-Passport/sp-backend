<?php

namespace App\Http\Controllers;

use App\Events\EndorsementRequested;
use App\Events\ExternalEndorsementRequested;
use App\Http\Requests\RequestEndorsementRequest;
use App\Http\Resources\EndorsementResource;
use App\Models\Endorsement;
use App\Models\EndorsementRequest;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Carbon;

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
            ->where('skill_id', $skill->id)
            ->paginate($request->query('per_page', 10));

        return response()->json($endorsements);
    }

    public function recentEndorsements(Request $request): AnonymousResourceCollection
    {
        $endorsements = auth()->user()->endorsements()
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->paginate($request->query('per_page', 10));

        return EndorsementResource::collection($endorsements);
    }

    public function requestEndorsement(RequestEndorsementRequest $request)
    {
        $skill = Skill::find($request->skill);
        $requester = auth()->user();
        $requestee = $request->requestee;
        $requestee_email = ! $requestee ? $request->requestee_email : null;
        $title = $request->title;
        if (! $requestee_email) {
            event(new EndorsementRequested($requester, $requestee, $skill, $title));
        } else {
            event(new ExternalEndorsementRequested($requester, $requestee_email, $skill, $title));
        }
    }

    public function showEndorsementRequest(EndorsementRequest $endorsementRequest)
    {
        if ($endorsementRequest->isExpired()) {
            return response()->json(['message' => 'Endorsement request has expired'], 410);
        }
        Job::dispatch(new ExpireAfterThirtyMinutes($endorsementRequest))->delay(now()->addMinutes(30));
        return response()->json($endorsementRequest);
    }
}
