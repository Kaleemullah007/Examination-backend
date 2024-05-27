<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PaperController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\ResultController;
use App\Http\Controllers\Api\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('papers', [PaperController::class, 'index'])->name('papers');
    Route::get('subjects', [SubjectController::class, 'index'])->name('subjects');
    Route::get('paper-questions', [QuestionController::class, 'index'])->name('paper-questions');
    Route::get('result', [ResultController::class, 'index'])->name('result');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('submit-test', [ResultController::class, 'submitTest'])->name('submit-test');
});