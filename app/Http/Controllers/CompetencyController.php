<?php

namespace App\Http\Controllers;

use App\Models\Competency;
use Illuminate\Http\Request;

class CompetencyController extends Controller
{

    public function getCompetencies(Request $request)
    {
        if (Competency::all()->isEmpty())
            Competency::factory()->count(8)->create();
        $skills = $request->user()->skills;
        $competencies = [];
        foreach ($skills as $skill) {
            $skill->competency->rating;
            $skill->competency->withCount('skills')->withCount('endorsements');
            $competencies[] = $skill->competency;
        }
        return response()->json(['competencies' => $competencies]);
    }
}
