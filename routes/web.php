<?php

use App\Http\Controllers\Api\ResultController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResultController as ControllersResultController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('subjects', SubjectController::class);
    Route::get('papers/show/{subject}', [PaperController::class, 'subjectPapers'])->name('papers.shows');
    Route::resource('papers', PaperController::class);
    Route::get('questions/add-option/{choicemultiple}', [QuestionController::class, 'addOption'])->name('questions.addoption');
    Route::get('questions/show/{paper}', [QuestionController::class, 'subjectPaperQuestions'])->name('questions.shows');
    Route::resource('questions', QuestionController::class);
    Route::get('submit-test', [ResultController::class, 'create'])->name('test');
    Route::post('submit-test', [ResultController::class, 'submitTest'])->name('submit-test');
    Route::resource('options', OptionController::class);
    Route::resource('results', ControllersResultController::class);
});