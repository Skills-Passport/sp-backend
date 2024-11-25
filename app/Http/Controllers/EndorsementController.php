<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\Endorsement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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