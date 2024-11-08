<?php

namespace App\Http\Controllers\Students;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompetencyController extends Controller
{
    public function getCompetencies(Request $request , User $user)
    {
        $user = $request->user() ?? $user;
        $skills = $user->skills;
        $competencies = [];
        foreach ($skills as $skill){
            $skill->competency->rating;
            $skill->competency->withCount('skills')->withCount('endorsements');
            $competencies[] = $skill->competency;
        }
        return response()->json(['competencies' => $competencies]);
    }
}
