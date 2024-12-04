<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompetencyResource;
use App\Models\Competency;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CompetencyController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $competencies = Competency::with($request->get('with', []))->get();

        return CompetencyResource::collection($competencies);
    }

    public function competency(Request $request, Competency $competency): CompetencyResource
    {
        $competency->load($request->get('with', []));
        return new CompetencyResource($competency);
    }

    public function myCompetencies(Request $request): AnonymousResourceCollection
    {
        $competencies = Competency::withUserSkills($request->user()->id)->get();
        return CompetencyResource::collection($competencies);
    }


    public function show(Request $request, Competency $competency): CompetencyResource
    {
        $userId = $request->user()->id;

        $competency->loadUserSkills($userId);
        return new CompetencyResource($competency);
    }
}
