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
        $competencies = Competency::all();

        return CompetencyResource::collection($competencies);
    }
}
