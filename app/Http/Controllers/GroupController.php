<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GroupController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $relations = $request->query('with') ? explode(',', $request->query('with')) : [];
        $relations[] = 'students';
        $relations[] = 'teachers';
        $relations[] = 'skills';

        $groups = Group::with($relations)->filter($request)->paginate($request->query('per_page', 10));

        return GroupResource::collection($groups);
    }

    public function show(Group $group): GroupResource
    {
        $group->load('students', 'teachers', 'skills');

        return new GroupResource($group);
    }

    public function addGroup(Request $request, Group $group)
    {
        $group = Group::create($request->all());

        return response()->json($group, 201);
    }

    public function addStudent(Request $request, Group $group)
    {
        $group->students()->attach($request->student_id);

        return response()->json($group, 201);
    }
}
