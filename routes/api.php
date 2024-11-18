<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\CompetencyController;
// use App\Http\Controllers\Students\SkillController as StudentSkillController;
// use App\Http\Controllers\Students\CompetencyController as StudentCompetencyController;


// PENDING FOR TESTING
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/competencies', [CompetencyController::class, 'getCompetencies']);
    Route::get('/events', [EventController::class, 'getEvents']);
    Route::get('/roles', [RoleController::class, 'getRoles']);
});


Route::group(['prefix' => 'student', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/competencies', [CompetencyController::class, 'getCompetencies']);

    Route::group(['prefix' => 'skills'], function () {
        Route::get('/', [SkillController::class, 'index']);
        Route::post('/{skill}/add', [SkillController::class, 'addSkill']);
    });
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin,auth:sanctum'], function () {
    Route::get('/skills', [SkillController::class, 'index']);
});

Route::group(['prefix' => 'teacher', 'middleware' => 'teacher,auth:sanctum'], function () {
    Route::get('/skills', [SkillController::class, 'index']);
    Route::delete('/skills/{skill}', [SkillController::class, 'destroy']);
});


