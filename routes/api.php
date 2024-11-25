<?php

use App\Models\Endorsement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\CompetencyController;
use App\Http\Controllers\EndorsementController;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', [UserController::class, 'user']);
    Route::get('/competencies', [CompetencyController::class, 'index']);
    Route::get('/roles', [UserController::class, 'getRoles']);


    Route::group(['prefix' => 'student'], function () {
        Route::group(['prefix' => 'skills'], function () {
            Route::get('/', [SkillController::class, 'index']);
            Route::get('/{skill}', [SkillController::class, 'show']);
            Route::post('/{skill}/add', [SkillController::class, 'addSkill']);
        });
    });

    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
        Route::get('/skills', [SkillController::class, 'index']);
    });

    Route::group(['prefix' => 'teacher', 'middleware' => 'teacher'], function () {
        Route::get('/skills', [SkillController::class, 'index']);
        Route::delete('/skills/{skill}', [SkillController::class, 'destroy']);
    });
    
    Route::group(['prefix' => 'skills'], function () {
        Route::get('/{skill}/feedbacks', [FeedbackController::class, 'skillFeedback']);
        Route::get('/{skill}/endorsements', [EndorsementController::class, 'skillEndorsements']);
        Route::post('/{skill}/timeline', [SkillController::class, 'skillTimeline']);
    });
});