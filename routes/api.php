<?php

use App\Http\Controllers\API\AuthAPIController;
use App\Http\Controllers\API\MyTasksAPIController;
use App\Http\Controllers\API\PermissionAPIController;
use App\Http\Controllers\API\ProfileAPIController;
use App\Http\Controllers\API\ProjectMemberAPIController;
use App\Http\Controllers\API\ProjectStatusAPIController;
use App\Http\Controllers\API\TaskMemberAPIController;
use App\Http\Controllers\API\TeamMemberAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['auth-check'], 'namespace' => 'App\Http\Controllers\API'], function () {

    //    /***************************** AuthController Start *****************************/
    //    client
    Route::post('register', [AuthAPIController::class, 'register']);
    Route::post('login', [AuthAPIController::class, 'login']);
    Route::group(['middleware' => ['jwt.verify']], function () {
        //        # User profile
        Route::post('logout', [AuthAPIController::class, 'logout']);
        Route::get('get-profile-info', [ProfileAPIController::class, 'show']);
        Route::post('update-profile-info', [ProfileAPIController::class, 'update']);
        Route::post('update-profile-image', [ProfileAPIController::class, 'updateImage']);
        Route::group(['middleware' => ['admin-check']], function () {
            Route::resource('admins', AdminAPIController::class);
            Route::resource('team-members', TeamMemberAPIController::class);
            Route::resource('task-categories', TaskCategoryAPIController::class);
            Route::resource('permissions', PermissionAPIController::class);
        });
        Route::group(['middleware' => ['team-member-check']], function () {
            Route::get('all-permissions', [PermissionAPIController::class, 'getAll']);
            Route::get('all-team-members', [TeamMemberAPIController::class, 'getAll']);
            Route::get('task-categories', [TaskCategoryAPIController::class,'index']);
            Route::resource('projects', ProjectAPIController::class);
            Route::get('project-status', [ProjectStatusAPIController::class, 'index']);
            Route::resource('project-members', ProjectMemberAPIController::class);
            Route::get('all-project-members', [ProjectMemberAPIController::class, 'getProjectTeamMembers']);
            Route::resource('tasks', TaskAPIController::class);
            Route::resource('task-members', TaskMemberAPIController::class);
            Route::get('my-tasks', [MyTasksAPIController::class,'index']);
            Route::resource('reports', ReportAPIController::class);
            Route::resource('notifications', NotificationAPIController::class);
        });
    });
});
