<?php

namespace App\Http\Controllers;

use App\Models\Competency;
use Illuminate\Http\Request;
use App\Http\Resources\CompetencyResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CompetencyController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $competencies = Competency::all();
        return CompetencyResource::collection($competencies);
    }
}