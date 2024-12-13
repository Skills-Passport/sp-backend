<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\HasRole;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Resources\UserResource;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    public function user(Request $request): UserResource
    {
        return new UserResource($request->user()->with($request->query('with') ? explode(',', $request->query('with')) : []));
    }

    public function getRoles()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    public function getRole($role)
    {
        $role = Role::find($role);

        return response()->json($role);
    }

    public function notifications(Request $request): AnonymousResourceCollection
    {
        return NotificationResource::collection($request->user()->notifications);
    }

    public function teachers(): AnonymousResourceCollection
    {
        $teachers = User::role('teacher')->get();
        return UserResource::collection($teachers);
    }

    public function setPersonalCoach(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'personal_coach_id' => ['required', 'exists:users,id', new HasRole('teacher')],
        ]);

        $request->user()->personal_coach = $request->teacher;
        $request->user()->save();

        return response()->json(['message' => 'Personal coach set', 'status' => 'success']);
    }
}
