<?php

namespace App\Http\Controllers\Teachers;

use App\Models\Skill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class SkillController extends Controller
{
    public function getSkills()
    {
        return Skill::withCount('groups')->get();
    }

    public function getSkill($id)
    {
        return Skill::find($id);
    }

    public function addSkill(Request $request)
    {
        $skill = new Skill();
        $skill->name = $request->name;
        $skill->save();
        return $skill;
    }

    public function updateSkill(Request $request, $id)
    {
        $skill = Skill::find($id);
        $skill->name = $request->name;
        $skill->save();
        return $skill;
    }

    public function deleteSkill($id)
    {
        $skill = Skill::find($id);
        $skill->delete();
        return $skill;
    }
}