<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\HasRole;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Resources\UserResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\FeedbackRequestResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    public function user(Request $request): UserResource
    {
        return new UserResource($request->user()->load($this->loadRelations($request)));
    }

    public function students(Request $request): AnonymousResourceCollection
    {
        $user = $request->user();
        if ($user->hasPermissionTo('view all students')) {
            $students = User::role('student')->with($this->loadRelations($request))->filter($request)->paginate($request->query('per_page') ?? 10);
        } else {
            $groups = $user->groups;
            $students = User::role('student')->whereHas('groups', function ($query) use ($groups) {
                $query->whereIn('group_id', $groups->pluck('id'));
            })->with($this->loadRelations($request))->filter($request)->paginate($request->query('per_page') ?? 10);
        }

        $students->each(function ($student) use ($user) {
            $student->groups = $student->groups->filter(function ($group) use ($user) {
                return $user->groups->contains('id', $group->id);
            });
        });

        return UserResource::collection($students);
    }

    public function student(Request $request, User $student): UserResource
    {
        $student->load($this->loadRelations($request));
        $student->groups = $student->groups->filter(function ($group) use ($request) {
            return $request->user()->groups->contains('id', $group->id);
        });

        $student->groups->each(function ($group) use ($student) {
            $group->skills = $group->skills->filter(function ($skill) use ($student) {
                return $student->skills->contains('id', $skill->id);
            });
        });

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
        $threeDaysAgo = Carbon::now()->subDays(3);

        $notifications = $request->user()->notifications()
            ->where('created_at', '>=', $threeDaysAgo)
            ->paginate($request->query('per_page') ?? 10);

        return NotificationResource::collection($notifications);
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
