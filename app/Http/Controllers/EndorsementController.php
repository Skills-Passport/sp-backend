<?php

namespace App\Http\Controllers;

use App\Models\Endorsement;
use App\Models\Skill;
use Illuminate\Http\Request;

class EndorsementController extends Controller
{
    public function index(Request $request)
    {
        $endorsements = Endorsement::filter($request)->paginate($request->query('per_page', 10));

        return response()->json($endorsements);
    }

    public function skillEndorsements(Request $request, Skill $skill)
    {
        $endorsements = auth()->user()->endorsements()
            ->where('skill_id', $skill->id)
            ->paginate($request->query('per_page', 10));

        return response()->json($endorsements);
    }
}
