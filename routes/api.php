<?php

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


Route::resource('certificates', App\Http\Controllers\API\CertificateAPIController::class)
    ->except(['create', 'edit']);

Route::resource('courses', App\Http\Controllers\API\CourseAPIController::class)
    ->except(['create', 'edit']);

Route::resource('events', App\Http\Controllers\API\EventAPIController::class)
    ->except(['create', 'edit']);

Route::resource('form-submissions', App\Http\Controllers\API\FormSubmissionAPIController::class)
    ->except(['create', 'edit']);

Route::resource('gallery-items', App\Http\Controllers\API\GalleryItemAPIController::class)
    ->except(['create', 'edit']);

Route::resource('involvement-submissions', App\Http\Controllers\API\InvolvementSubmissionAPIController::class)
    ->except(['create', 'edit']);

Route::resource('license-classes', App\Http\Controllers\API\LicenseClassAPIController::class)
    ->except(['create', 'edit']);

Route::resource('resources', App\Http\Controllers\API\ResourceAPIController::class)
    ->except(['create', 'edit']);

Route::resource('trainers', App\Http\Controllers\API\TrainerAPIController::class)
    ->except(['create', 'edit']);

Route::resource('training-programs', App\Http\Controllers\API\TrainingProgramAPIController::class)
    ->except(['create', 'edit']);

Route::resource('useful-links', App\Http\Controllers\API\UsefulLinkAPIController::class)
    ->except(['create', 'edit']);

Route::resource('users', App\Http\Controllers\API\UserAPIController::class)
    ->except(['create', 'edit']);

Route::post('/certificates/register', [App\Http\Controllers\API\CertificateAPIController::class, 'register']);
Route::post('/certificates/kenstane', [App\Http\Controllers\API\CertificateAPIController::class, 'registerKenya']);