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
        Route::group(['middleware' => ['team-member-check']], function () {
            Route::get('task-categories', 'TaskCategoryAPIController@index');
            Route::get('getCountOfTaskInProject', 'TaskCountAPIController@getCountOfTaskInProject');
            Route::get('getCountOfFinishedTaskInProject', 'TaskCountAPIController@getCountOfFinishedTaskInProject');
            Route::resource('projects', ProjectAPIController::class);
            Route::resource('project-members', ProjectMemberAPIController::class);
            Route::resource('tasks', TaskAPIController::class);
            Route::resource('task-members', TaskMemberAPIController::class);
            Route::get('/task-status/{id}', 'TaskAPIController@updateStatus');
            Route::get('my-tasks', 'MyTasksAPIController@index');
            Route::resource('reports', ReportAPIController::class);
            Route::resource('notifications', NotificationAPIController::class);
            Route::get('timelines', 'TimelineAPIController@index');
        });
    });
});


