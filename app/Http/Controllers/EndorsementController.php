<?php

namespace App\Http\Controllers;

use App\Events\EndorsementRequested;
use App\Events\ExternalEndorsementRequested;
use App\Events\ExternalEndorsementRequestFilled;
use App\Http\Requests\RequestEndorsementRequest;
use App\Http\Requests\RespondEndorsementRequest;
use App\Http\Resources\EndorsementRequestResource;
use App\Http\Resources\EndorsementResource;
use App\Models\Endorsement;
use App\Models\EndorsementRequest;
use App\Models\Skill;
use App\Models\User;
use App\Notifications\EndorsementReceivedNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

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
            ->where('skill_id', $skill->id)->with($this->loadRelations($request))
            ->paginate($request->query('per_page', 10));

        return EndorsementResource::collection($endorsements);
    }

    public function recentEndorsements(Request $request, ?User $user = null)
    {
        if (! $user) {
            $user = auth()->user();
        }
        $endorsements = $user->endorsements()->filter($request)->with($this->loadRelations($request))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->paginate($request->query('per_page', 10));

        return EndorsementResource::collection($endorsements);
    }

    public function requestEndorsement(RequestEndorsementRequest $request)
    {

        $skill = Skill::find($request->skill);
        $requestee = User::find($request->requestee);
        $requestee_email = ! $requestee ? $request->requestee_email : null;
        if (! $request->user()->hasPersonalCoach() && $requestee_email) {
            return response()->json(['message' => 'You need to have a personal coach to request an endorsement', 'error' => 'no_personal_coach'], 403);
        }

        $title = $request->title;

        if (! $requestee_email) {
            event(new EndorsementRequested($request->user(), $requestee, $skill, $title));
        } else {
            event(new ExternalEndorsementRequested($request->user(), $requestee_email, $skill, $title));
        }

        return response()->json(['message' => 'Endorsement request sent']);
    }

    public function showEndorsementRequest(EndorsementRequest $endorsementRequest)
    {
        if ($endorsementRequest->isFilled()) {
            return response()->json(['message' => 'This endorsement request has already been filled'], 410);
        }

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

        event(new ExternalEndorsementRequestFilled($endorsementRequest, $data));
    }

    public function respondEndorsementRequest(RespondEndorsementRequest $request, EndorsementRequest $endorsementRequest): \Illuminate\Http\JsonResponse
    {
        $endormsnet = $endorsementRequest->respond($request->only(['title', 'rating', 'created_by', 'content', 'skill_id', 'user_id']));

        $endormsnet->user->notify(new EndorsementReceivedNotification($endormsnet));

        return response()->json(['message' => 'Endorsement submitted successfully']);
    }

    private function approveEndorsementRequest(EndorsementRequest $endorsementRequest): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($endorsementRequest->toArray(), [
            'title' => 'required',
            'requester_id' => 'required',
            'requestee_id' => 'required',
            'skill_id' => 'required',
            'requestee_email' => 'required',
            'data' => 'required',
            'status' => 'in:filled',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'This request dose not have all the required data', 'error' => 'missing_data'], 400);
        }
        $endorsement = $endorsementRequest->approve();

        $endorsement->user->notify(new EndorsementReceivedNotification($endorsement));

        return response()->json(['message' => 'Endorsement approved successfully']);
    }

    public function rejectEndorsementRequest(EndorsementRequest $endorsementRequest): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($endorsementRequest->toArray(), [
            'status' => 'in:filled',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'This request dose not have all the required data', 'error' => 'missing_data'], 400);
        }

        $endorsementRequest->update([
            'status' => EndorsementRequest::STATUS_REJECTED,
        ]);

        return response()->json(['message' => 'Endorsement request rejected']);
    }
}
