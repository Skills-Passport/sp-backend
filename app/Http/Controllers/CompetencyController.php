<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\Competency;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CompetencyResource;
use App\Http\Requests\CreateUpdateCompetencyRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CompetencyController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Competency::with($this->loadRelations($request))->filter($request);
        $competencies = $query->paginate($request->query('per_page', 10));

        return CompetencyResource::collection($competencies);
    }

    public function competency(Request $request, Competency $competency): CompetencyResource
    {
        $competency->load($this->loadRelations($request));

        return new CompetencyResource($competency);
    }

    public function myCompetencies(Request $request): AnonymousResourceCollection
    {
        $competencies = Competency::withUserSkills($request->user()->id)->filter($request)->paginate($request->query('per_page', 10));

        return CompetencyResource::collection($competencies);
    }

    public function show(Request $request, Competency $competency): CompetencyResource
    {
        $userId = $request->user()->id;

        $competency->loadUserSkills($userId);

        return new CompetencyResource($competency);
    }

    public function create(CreateUpdateCompetencyRequest $request): CompetencyResource|JsonResponse
    {
        DB::beginTransaction();

        try {
            $competency = Competency::create($request->only(['title', 'desc', 'overview']));

            if ($request->has('profiles')) {
                $competency->profiles()->sync($request->profiles);
            }

            if ($request->has('skills')) {
                foreach ($request->skills as $skill) {
                    $skill = Skill::find($skill);
                    $skill->competency_id = $competency->id;
                    $skill->save();
                }
            }

            DB::commit();

            return new CompetencyResource($competency->load(['skills', 'profiles']));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create competency',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(CreateUpdateCompetencyRequest $request, Competency $competency): CompetencyResource|JsonResponse
    {
        DB::beginTransaction();

        try {
            $competency->update($request->only(['title', 'desc', 'overview']));

            if ($request->has('profiles')) {
                $competency->profiles()->sync($request->profiles);
            }
            DB::commit();

            return new CompetencyResource($competency->load(['skills', 'profiles']));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to update competency',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Competency $competency): JsonResponse
    {
        $competency->delete();

        return response()->json([
            'message' => 'Competency deleted successfully',
        ]);
    }
}
