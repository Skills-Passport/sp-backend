<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Scopes\ActiveScope;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use App\Http\Resources\GroupResource;
use App\Http\Requests\CreateUpdateGroupRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GroupController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $groupsQuery = Group::with($this->loadRelations($request))->filter($request);
        if ($request->user()->isTeacher && $request->query('is_archived') == 'true') {
            $groupsQuery->whereNotNull('archived_at');
        } else {
            $groupsQuery->active();
        }
        $groups = $groupsQuery->paginate($request->query('per_page', 10));

        return GroupResource::collection($groups);
    }

    public function mygroups(Request $request): AnonymousResourceCollection
    {
        $user = $request->user();

        $groups = $user->groups()->with($this->loadRelations($request))->filter($request)->active()->paginate($request->query('per_page', 10));

        return GroupResource::collection($groups);
    }


    public function show(Group $group): GroupResource
    {
        $group->load('students', 'teachers', 'skills');

        return new GroupResource($group);
    }

    public function students(Request $request, Group $group): AnonymousResourceCollection
    {
        $students = $group->students()->skillFilter(request())->paginate(request()->query('per_page', 10))->load($this->loadRelations($request));

        return UserResource::collection($students);
    }

    public function create(CreateUpdateGroupRequest $request): GroupResource|JsonResponse
    {
        DB::beginTransaction();

        try {
            $group = Group::create($request->only(['name', 'desc']));
            if ($request->has('skills')) {
                $group->skills()->attach($request->skills);
            }

            if ($request->has('teachers')) {
                $group->teachers()->attach($request->teachers);
                $group->teachers()->attach($request->user()->id, ['role' => 'teacher']);
            }

            if ($request->has('students')) {
                $group->students()->attach($request->students);
            }

            DB::commit();

            return GroupResource::make($group->load('students', 'teachers', 'skills'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create group',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(CreateUpdateGroupRequest $request, Group $group): GroupResource|JsonResponse
    {
        DB::beginTransaction();

        try {
            $group->update($request->only(['name', 'desc', 'archived_at']));

            if ($request->has('skills')) {
                $group->skills()->sync($request->skills);
            }

            if ($request->has('teachers')) {
                $group->teachers()->sync($request->teachers);
            }

            if ($request->has('students')) {
                $group->students()->sync($request->students);
            }

            DB::commit();

            return GroupResource::make($group->load('students', 'teachers', 'skills'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to update group',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Group $group): JsonResponse
    {
        if (!auth()->user()->hasPermissionTo('delete groups') || $group->created_by != auth()->id()) {
            return response()->json('You are not authorized to delete this group', 403);
        }
        $group->delete();

        return response()->json('Group deleted', 200);
    }

    public function joinGroup(Request $request, Group $group)
    {
        $group->students()->attach($request->user()->id);

        return response()->json($group, 201);
    }

    public function leaveGroup(Request $request, Group $group)
    {
        $group->students()->detach($request->user()->id);

        return response()->json('You have left the group', 200);
    }
}
