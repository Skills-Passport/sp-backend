<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProfileController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $profiles = Profile::with($request->query('with', []))->paginate($request->query('per_page', 10));

        return ProfileResource::collection($profiles);
    }

    public function show(Request $request, Profile $profile): ProfileResource
    {
        $profile->load($request->query('with', []));

        return new ProfileResource($profile);
    }
}
