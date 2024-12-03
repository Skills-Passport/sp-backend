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

    public function myCompetencies(Request $request): AnonymousResourceCollection
    {
        $user = $request->user();

        $competencies = $user->competencies();

        return CompetencyResource::collection($competencies);
    }

    public function show(Competency $competency): CompetencyResource
    {
        $competency->load(['skills', 'skills.endorsements']);

        return new CompetencyResource($competency);
    }
}
