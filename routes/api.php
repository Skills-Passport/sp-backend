<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Teachers\SkillController as TeacherSkillController;
use App\Http\Controllers\Students\SkillController as StudentSkillController;
use App\Http\Controllers\Admin\SkillController as AdminSkillController;
use App\Http\Controllers\Students\CompetencyController as StudentCompetencyController;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['prefix' => 'student'], function () {
        Route::get('/skills', [StudentSkillController::class, 'index']);
        // add skills to user
        Route::get('/competencies/{user}', [StudentCompetencyController::class, 'getCompetencies']);
        Route::group(['prefix' => 'skills'], function () {
            Route::post('/{skill}/add', [StudentSkillController::class, 'addSkill']);
        });
    });

    Route::group(['prefix' => 'teacher', 'middleware' => 'teacher'], function () {
        Route::get('/skills', [TeacherSkillController::class, 'index']);
    });

    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
        Route::get('/skills', [AdminSkillController::class, 'index']);
    });

    Route::get('/events', [EventController::class, 'getEvents']);
    Route::get('/roles', [RoleController::class, 'getRoles']);
});

Route::get('/competencies',[StudentCompetencyController::class, 'test']);
