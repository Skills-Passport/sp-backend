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
    Route::get('/teachers', [UserController::class, 'teachers']);

    Route::group(['prefix' => 'competencies'], function () {
        Route::get('/', [CompetencyController::class, 'index']);
        Route::get('/{competency}', [CompetencyController::class, 'competency']);
    });

    Route::group(['prefix' => 'student', 'middleware' => 'role:Student'], function () {
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
        Route::put('/personal_coach', [UserController::class, 'setPersonalCoach']);
        Route::group(['prefix' => 'requests'], function () {
            Route::get('/', [UserController::class, 'requests']);
        });
    });

    Route::group(['prefix' => 'educator', 'middleware' => 'educator'], function () {
        Route::group(['prefix' => 'skills'], function () {
            Route::group(['middleware' => 'can:view skills'], function () {
                Route::get('/', [SkillController::class, 'index']);
                Route::get('/{skill}', [SkillController::class, 'show']);
            });
            Route::post('/create', [SkillController::class, 'create'])->middleware('can:create skills');
            Route::put('/{skill}', [SkillController::class, 'update'])->middleware('can:update skills');
            Route::delete('/{skill}', [SkillController::class, 'destroy'])->middleware('can:delete skills');
        });

        Route::group(['prefix' => 'users'], function () {
            Route::group(['middleware' => 'can:view users'], function () {
                Route::get('/', [UserController::class, 'index']);
                Route::get('/{user}', [UserController::class, 'show']);
            });
            Route::post('/{user}', [UserController::class, 'update'])->middleware('can:update users');
            Route::delete('/{user}', [UserController::class, 'destroy'])->middleware('can:delete users');
        });

        Route::group(['prefix' => 'groups'], function () {
            Route::group(['middleware' => 'can:view groups'], function () {
                Route::get('/', [GroupController::class, 'index']);
                Route::get('/{group}', [GroupController::class, 'show']);
                Route::get('/{group}/students', [GroupController::class, 'students']);
            });
            Route::post('/create', [GroupController::class, 'create'])->middleware('can:create groups');
            Route::put('/{group}', [GroupController::class, 'update'])->middleware('can:update groups');
            Route::delete('/{group}', [GroupController::class, 'destroy'])->middleware('can:delete groups');
        });

        Route::group(['prefix' => 'students', 'middleware' => 'can:view students'], function () {
            Route::get('/', [UserController::class, 'students']);
            Route::group(['prefix' => '{student}'], function () {
                Route::get('', [UserController::class, 'student']);
                Route::get('/endorsements/recent', [EndorsementController::class, 'recentEndorsements']);
                Route::get('/feedbacks/recent', [FeedbackController::class, 'recentFeedbacks']);
                Route::get('/{skill}', [SkillController::class, 'studentSkill']);
                Route::get('/{skill}/timeline', [SkillController::class, 'StudentSkillTimeline']);
                Route::get('/skills/{skill}/feedbacks', [FeedbackController::class, 'studentSkillFeedbacks']);
            });
        });

        Route::group(['prefix' => 'profiles'], function () {
            Route::group(['middleware' => 'can:view profiles'], function () {
                Route::get('/', [ProfileController::class, 'index']);
                Route::get('/{profile}', [ProfileController::class, 'show']);
            });
            Route::post('/create', [ProfileController::class, 'create'])->middleware('can:create profiles');
            Route::put('/{profile}', [ProfileController::class, 'update'])->middleware('can:update profiles');
            Route::delete('/{profile}', [ProfileController::class, 'destroy'])->middleware('can:delete profiles');
        });

        Route::group(['prefix' => 'competencies'], function () {
            Route::group(['middleware' => 'can:view competencies'], function () {
                Route::get('/', [CompetencyController::class, 'index']);
                Route::get('/{competency}', [CompetencyController::class, 'competency']);
            });
            Route::post('/create', [CompetencyController::class, 'create'])->middleware('can:create competencies');
            Route::put('/{competency}', [CompetencyController::class, 'update'])->middleware('can:update competencies');
            Route::delete('/{competency}', [CompetencyController::class, 'destroy'])->middleware('can:delete competencies');
        });

        Route::group(['prefix' => 'requests'], function () {
            Route::group(['middleware' => 'can:view requests'], function () {
                Route::get('/feedbacks', [UserController::class, 'requests']);
                Route::get('/endorsements', [UserController::class, 'endorsementRequests']);
                Route::get('/count', [UserController::class, 'requestsCount']);
            });
            Route::group(['middleware' => 'can:review requests'], function () {
                Route::post('/endorsement/{endorsementRequest}/respond', [EndorsementController::class, 'respondEndorsementRequest']);
                Route::post('/feedbacks/{feedbackRequest}/respond', [FeedbackController::class, 'respondFeedbackRequest']);
                Route::post('/endorsement/{endorsementRequest}/approve', [EndorsementController::class, 'approveEndorsementRequest']);
                Route::post('/endorsement/{endorsementRequest}/reject', [EndorsementController::class, 'rejectEndorsementRequest']);
            });
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
Route::get('/roles', [UserController::class, 'getRoles']);
Route::get('/endorsements/request/{endorsementRequest}', [EndorsementController::class, 'showEndorsementRequest']);
Route::post('/endorsements/request/{endorsementRequest}', [EndorsementController::class, 'endorseEndorsementRequest']);
