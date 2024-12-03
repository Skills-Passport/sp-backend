<?php

use App\Http\Controllers\CompetencyController;
use App\Http\Controllers\EndorsementController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\UserController;
use App\Models\Group;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', [UserController::class, 'user'])->name('user');
    Route::get('/competencies', [CompetencyController::class, 'index'])->name('competencies');
    Route::get('/roles', [UserController::class, 'getRoles'])->name('roles');

    Route::group(['prefix' => 'student'], function () {
        Route::group(['prefix' => 'skills'], function () {
            Route::get('/', [SkillController::class, 'index'])->name('skills');
            Route::get('/{skill}', [SkillController::class, 'show'])->name('skill');
            Route::post('/{skill}/add', [SkillController::class, 'addSkill'])->name('addSkill');
        });
        Route::group(['prefix' => 'competencies'], function () {
            Route::get('/', [CompetencyController::class, 'myCompetencies'])->name('competencies');
            Route::get('/{competency}', [CompetencyController::class, 'show'])->name('competency'); 
        });
        Route::group(['prefix' => 'groups'], function () {
            Route::get('/', [GroupController::class, 'mygroups'])->name('groups');
        });
        Route::group(['prefix' => 'profiles'], function () {
            Route::get('/', [ProfileController::class, 'index'])->name('profiles');
            Route::get('/{profile}', [ProfileController::class, 'show'])->name('profile');
        });
        Route::group(['prefix' => 'endorsements'], function () {
            Route::post('/recent', [EndorsementController::class, 'recentEndorsements'])->name('recentEndorsements');
            Route::post('/request', [EndorsementController::class, 'requestEndorsement'])->name('requestEndorsement');
            Route::get('/{endorsementRequest}', [EndorsementController::class, 'showEndorsementRequest'])->name('showEndorsementRequest');
        });
    });

    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
        Route::get('/skills', [SkillController::class, 'index'])->name('skills');
    });

    Route::group(['prefix' => 'teacher', 'middleware' => 'teacher'], function () {
        Route::get('/skills', [SkillController::class, 'index'])->name('skills');
        Route::delete('/skills/{skill}', [SkillController::class, 'destroy'])->name('deleteSkill');
    });

    Route::group(['prefix' => 'skills'], function () {
        Route::get('/{skill}/feedbacks', [FeedbackController::class, 'skillFeedback'])->name('skillFeedback');
        Route::get('/{skill}/endorsements', [EndorsementController::class, 'skillEndorsements'])->name('skillEndorsements');
        Route::post('/{skill}/timeline', [SkillController::class, 'skillTimeline'])->name('skillTimeline');
    });

    Route::group(['prefix' => 'groups'], function () {
        Route::get('/', [GroupController::class, 'index'])->name('groups');
        Route::get('/{group}', [GroupController::class, 'show'])->name('group');
        Route::post('/{group}/join', [GroupController::class, 'joinGroup'])->name('joinGroup');
        Route::post('/{group}/leave', [GroupController::class, 'leaveGroup'])->name('leaveGroup');
    });

    Route::get('/test', function () {
        Group::factory()->count(1)->create();
    });
});
