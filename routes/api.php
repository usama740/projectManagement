<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectAttributeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TimesheetController;



Route::middleware('auth:api')->group(function () {

    Route::put('/user', [UserController::class, 'updateUser']);
    Route::get('/user', [UserController::class, 'getUsers']);
    Route::get('/user/{id}', [UserController::class, 'getUserById']);
    Route::post('/logout', [LoginController::class, 'logout']);

    Route::post('/attribute', [ProjectAttributeController::class, 'createAttribute']);
    Route::put('/attribute/{id}', [ProjectAttributeController::class, 'updateAttribute']);
    Route::delete('/attribute/{id}', [ProjectAttributeController::class, 'deleteAttribute']);
    Route::get('/attribute', [ProjectAttributeController::class, 'fetchAttributeList']);
    Route::get('/attribute/{id}', [ProjectAttributeController::class, 'fetchAttributeById']);

    Route::post('/project', [ProjectController::class, 'createProject']);
    Route::get('/project/{id}', [ProjectController::class, 'fetchProjectById']);
    Route::get('/project', [ProjectController::class, 'getProjects']);
    Route::put('/project/{id}', [ProjectController::class, 'updateProject']);
    Route::get('/projects-with-attributes', [ProjectController::class, 'fetchProjectsWithAttributes']);
    Route::delete('/project/{id}', [ProjectController::class, 'deleteProject']);


    Route::post('/timesheet', [TimesheetController::class, 'saveTimesheet']);
    Route::put('/timesheet/{id}', [TimesheetController::class, 'updateTimesheet']);
    Route::get('/timesheet/{id}', [TimesheetController::class, 'fetchTimesheetById']);
    Route::get('/timesheet', [TimesheetController::class, 'getTimesheetList']);
    Route::delete('/timesheet/{id}', [TimesheetController::class, 'deleteTimesheetById']);

});

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [UserController::class, 'saveUser']);









