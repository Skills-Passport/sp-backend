<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Scopes\ActiveScope;
use Illuminate\Http\Request;
use App\Http\Resources\GroupResource;
use App\Http\Requests\CreateUpdateGroupRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GroupController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $groupsQuery = Group::with($this->loadRelations($request))->filter($request);
        if ($request->user()->hasRole('teacher') && $request->query('is_archived') == 'true') {
            $groupsQuery->withoutGlobalScope(ActiveScope::class)
                ->whereNotNull('archived_at');
        }
        $groups = $groupsQuery->paginate($request->query('per_page', 10));

        return GroupResource::collection($groups);
    }

    public function mygroups(Request $request): AnonymousResourceCollection
    {
        $user = $request->user();

        $groups = $user->groups()->with($this->loadRelations($request))->filter($request)->paginate($request->query('per_page', 10));

        return GroupResource::collection($groups);
    }

    public function show(Group $group): GroupResource
    {
        $group->load('students', 'teachers', 'skills');

        return new GroupResource($group);
    }

    public function create(CreateUpdateGroupRequest $request): GroupResource
    {
        $group = Group::create($request->all());

        if ($request->has('skills')) {
            $group->skills()->attach($request->skills);
        }

        if ($request->has('teachers')) {
            $group->teachers()->attach($request->teachers);
        }

        if ($request->has('students')) {
            $group->students()->attach($request->students);
        }
        return GroupResource::make($group->load('students', 'teachers', 'skills'));
    }

    public function update(CreateUpdateGroupRequest $request, Group $group): GroupResource
    {
        $group->update($request->all());

        if ($request->has('skills')) {
            $group->skills()->sync($request->skills);
        }

        if ($request->has('teachers')) {
            $group->teachers()->sync($request->teachers);
        }

        if ($request->has('students')) {
            $group->students()->sync($request->students);
        }
        return GroupResource::make($group->load('students', 'teachers', 'skills'));
    }

    public function delete(Group $group)
    {
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
