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
        return SkillResource::collection($skills);
    }
}
