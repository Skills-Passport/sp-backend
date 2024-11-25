<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function user(Request $request) : UserResource
    {
        return new UserResource($request->user()->load('roles'));
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
}