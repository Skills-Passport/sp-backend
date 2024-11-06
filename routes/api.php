<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Teachers\SkillController;


Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });










    Route::group(['prefix' => 'student'], function () {
    });



    Route::group(['prefix' => 'teacher', 'middleware' => 'teacher'], function () {
        Route::get('/skills', [SkillController::class, 'getSkills']);
    });














});

Route::get('/events', [EventController::class, 'getEvents']);
Route::get('/roles', [RoleController::class, 'getRoles']);
