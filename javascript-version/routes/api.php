<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TrainingCourseController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\SessController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\SubjectModuleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PaymentController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('api')->group(function () {
    Route::resource('subjects', SubjectController::class);
});

Route::middleware('api')->group(function () {
    Route::resource('trainingcourses', TrainingCourseController::class);
});

Route::middleware('api')->group(function () {
    Route::resource('modules', ModuleController::class);
});

Route::middleware('api')->group(function () {
    Route::resource('sesses', SessController::class);
});

Route::middleware('api')->group(function () {
    Route::resource('trainers', TrainerController::class);
});

Route::middleware('api')->group(function () {
    Route::resource('trainees', TraineeController::class);
});

Route::middleware('api')->group(function () {
    Route::resource('seances', SeanceController::class);
});

Route::middleware('api')->group(function () {
    Route::resource('subjectmodule', SubjectModuleController::class);
});

Route::middleware('api')->group(function () {
    Route::resource('payments', PaymentController::class);
});


Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);
Route::middleware('auth:sanctum')->post('/logout', [
    LoginController::class,
    'logout'
]);
