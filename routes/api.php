<?php

use App\Http\Controllers\CompetencyController;
use App\Http\Controllers\EndorsementController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', [UserController::class, 'user']);
    Route::group(['prefix' => 'competencies'], function () {
        Route::get('/', [CompetencyController::class, 'index']);
        Route::get('/{competency}', [CompetencyController::class, 'competency']);
    });

    Route::get('/roles', [UserController::class, 'getRoles']);

    Route::group(['prefix' => 'student'], function () {
        Route::group(['prefix' => 'skills'], function () {
            Route::get('/', [SkillController::class, 'index']);
            Route::get('/{skill}', [SkillController::class, 'show']);
            Route::post('/{skill}/add', [SkillController::class, 'addSkill']);
            Route::post('/{skill}/rating_update', [SkillController::class, 'updateRating']);
            ROute::post('/{skill}/feedback', [FeedbackController::class, 'ratingUpdateFeedback']);
        });
        Route::group(['prefix' => 'competencies'], function () {
            Route::get('/', [CompetencyController::class, 'myCompetencies']);
            Route::get('/{competency}', [CompetencyController::class, 'show']);
        });
        Route::group(['prefix' => 'groups'], function () {
            Route::get('/', [GroupController::class, 'mygroups']);
            Route::get('/{group}/skills', [SkillController::class, 'groupSkills']);
            Route::get('/{group}/join', [GroupController::class, 'joinGroup']);
            Route::get('/{group}/leave', [GroupController::class, 'leaveGroup']);
        });
        Route::group(['prefix' => 'profiles'], function () {
            Route::get('/', [ProfileController::class, 'index']);
            Route::get('/{profile}', [ProfileController::class, 'show']);
        });
        Route::group(['prefix' => 'endorsements'], function () {
            Route::get('/recent', [EndorsementController::class, 'recentEndorsements']);
            Route::post('/request', [EndorsementController::class, 'requestEndorsement']);
        });
        Route::group(['prefix' => 'feedbacks'], function () {
            Route::post('/request', [FeedbackController::class, 'requestFeedback']);
            Route::post('/{feedbackRequest}/respond', [FeedbackController::class, 'respondFeedbackRequest']);
        });
        Route::get('/teachers', [UserController::class, 'teachers']);
        Route::put('/personal_coach', [UserController::class, 'setPersonalCoach']);
        Route::group(['prefix' => 'requests'], function () {
            Route::get('/', [UserController::class, 'requests']);
        });
    });

    Route::group(['prefix' => 'teacher', 'middleware' => 'teacher'], function () {
        Route::resource('skills', SkillController::class)->only(['index', 'show', 'create', 'update', 'destroy']);
        Route::resource('groups', GroupController::class)->only(['index', 'show', 'create', 'update', 'destroy']);
        Route::group(['prefix' => 'students'], function () {
            Route::get('/', [UserController::class, 'students']);
            Route::get('/{student}', [UserController::class, 'student']);
        });
    });

    Route::group(['prefix' => 'skills'], function () {
        Route::get('/{skill}/feedbacks', [FeedbackController::class, 'skillFeedback']);
        Route::get('/{skill}/endorsements', [EndorsementController::class, 'skillEndorsements']);
        Route::get('/{skill}/timeline', [SkillController::class, 'skillTimeline']);
    });

    Route::group(['prefix' => 'groups'], function () {
        Route::get('/', [GroupController::class, 'index']);
        Route::get('/{group}', [GroupController::class, 'show']);
    });
    Route::group(['prefix' => 'notifications'], function () {
        Route::get('/', [UserController::class, 'notifications']);
        Route::get('/{notification}/read', [UserController::class, 'markAsRead']);
    });
});

Route::get('/endorsements/request/{endorsementRequest}', [EndorsementController::class, 'showEndorsementRequest']);
Route::post('/endorsements/request/{endorsementRequest}', [EndorsementController::class, 'endorseEndorsementRequest']);
