<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeedbackRequestResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Rules\HasRole;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function user(Request $request): UserResource
    {
        return new UserResource($request->user()->load($this->loadRelations($request)));
    }

    public function students(Request $request): AnonymousResourceCollection
    {
        $students = User::role('student')->with($this->loadRelations($request))->filter($request)->paginate($request->query('per_page') ?? 10);

        return UserResource::collection($students);
    }

    public function student(Request $request, User $student): UserResource
    {
        $student->load($this->loadRelations($request));
        return new UserResource($student);
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
        return NotificationResource::collection($request->user()->unreadNotifications);
    }

    public function markAsRead(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->user()->unreadNotifications->markAsRead();

        return response()->json(['message' => 'Notifications marked as read']);
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

        $request->user()->personal_coach = $request->personal_coach_id;
        $request->user()->save();

        return response()->json(['message' => 'Personal coach set', 'status' => 'success']);
    }

    public function requests(Request $request): AnonymousResourceCollection
    {
        $feedbackRequests = $request->user()->feedbackRequests()->where('status', 'pending')->with(
            $this->loadRelations($request)
        )->paginate($request->query('per_page') ?? 10);

        return FeedbackRequestResource::collection($feedbackRequests);
    }
}
