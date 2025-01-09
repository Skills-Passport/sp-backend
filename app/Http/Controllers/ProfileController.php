<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $profiles = Profile::with($this->loadRelations($request))->paginate($request->query('per_page', 10));

        return ProfileResource::collection($profiles);
    }

    public function show(Request $request, Profile $profile): ProfileResource
    {
        $profile->load($this->loadRelations($request));

        return new ProfileResource($profile);
    }

    public function create(CreateUpdateProfileRequest $request): ProfileResource|JsonResponse
    {
        DB::beginTransaction();

        try {
            $profile = Profile::create($request->only(['title', 'desc', 'color', 'icon']));

            if ($request->has('competencies')) {
                $profile->competencies()->sync($request->competencies);
            }

            DB::commit();

            return new ProfileResource($profile);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to create profile',
                'error' => $e->getMessage(),
            ], 500);
        }

    }

    public function update(CreateUpdateProfileRequest $request, Profile $profile): ProfileResource
    {
        DB::beginTransaction();

        try {
            $profile->update($request->only(['title', 'desc', 'color', 'icon']));

            if ($request->has('competencies')) {
                $profile->competencies()->sync($request->competencies);
            }

            DB::commit();

            return new ProfileResource($profile->load('competencies'));
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to update profile',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Profile $profile): JsonResponse
    {
        $profile->delete();

        return response()->json('Profile deleted successfully', 200);
    }
}
