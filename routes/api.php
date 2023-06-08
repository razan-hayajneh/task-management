<?php

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

Route::group(['middleware' => ['auth-check'], 'namespace' => 'App\Http\Controllers\API'], function () {

    //    /***************************** AuthController Start *****************************/
    //    client
    Route::post('register', 'AuthAPIController@register');
    Route::post('login',  'AuthAPIController@login');
    Route::group(['middleware' => ['jwt.verify']], function () {
        //        # User profile
        Route::post('logout',  'AuthAPIController@logout');
        Route::get('get-profile-info', 'ProfileAPIController@show');
        Route::post('update-profile-info', 'ProfileAPIController@update');
        Route::post('update-profile-image', 'ProfileAPIController@updateImage');
        Route::group(['middleware' => ['admin-check']], function () {
            Route::resource('admins', AdminAPIController::class);
            Route::resource('team-members', TeamMemberAPIController::class);
            Route::resource('task-categories', TaskCategoryAPIController::class);
            Route::resource('permissions', PermissionAPIController::class);
        });
        Route::group(['middleware' => ['team-member-check']], function () {
            Route::resource('projects', ProjectAPIController::class);
            Route::get('project-status', 'ProjectStatusAPIController@index');
            Route::resource('project-members', ProjectMemberAPIController::class);
            Route::resource('tasks', TaskAPIController::class);
            Route::resource('task-members', TaskMemberAPIController::class);
            Route::get('my-tasks', 'MyTasksAPIController@index');
            Route::resource('reports', ReportAPIController::class);
            Route::resource('notifications', NotificationAPIController::class);
        });
    });
});
