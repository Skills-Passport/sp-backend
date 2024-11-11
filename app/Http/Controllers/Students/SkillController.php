<?php

namespace App\Http\Controllers\Students;

use App\Models\Skill;
use App\Modules\Skills\Resources\Students\SkillResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class SkillController extends Controller
{
    public function index(Request $request)
    {
        $relations = $request->query('with') ? explode(',', $request->query('with')) : [];
        $skills = Skill::with($relations)->filter($request)->paginate($request->query('per_page', 10));
        $competencies = $request->user()->competencies()->toArray();
        return $competencies;
    }

    public function addSkill(Request $request, Skill $skill)
    {
        dd($skill);
        $request->user()->skills()->attach($skill->id);
        return response()->json(['message' => 'Skill added successfully']);
    }
}
