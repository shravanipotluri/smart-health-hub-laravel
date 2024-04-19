<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\MedicationDispensationRecordController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/users', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/forgot-password', [UserController::class, 'forgotPassword']);
Route::get('/users', [UserController::class, 'getAllUsers']);


// Route::get('/medical_records', [MedicalRecordController::class, 'index']);
// Route::post('/medical_records', [MedicalRecordController::class, 'store']);
// Route::get('/medical_records/{id}', [MedicalRecordController::class, 'show']);
// Route::put('/medical_records/{id}', [MedicalRecordController::class, 'update']);
// Route::delete('/medical_records/{id}', [MedicalRecordController::class, 'destroy']);


// Route::apiResource('appointments', AppointmentController::class);


// Route::apiResource('prescriptions', PrescriptionController::class);

// Route::apiResource('medication_dispensation_records', MedicationDispensationRecordController::class);


Route::get('/medical-records/{userId}', 'MedicalRecordController@index');
Route::post('/medical-records', 'MedicalRecordController@store');
Route::put('/medical-records/{recordId}', 'MedicalRecordController@update');
Route::delete('/medical-records/{recordId}', 'MedicalRecordController@destroy');



Route::get('/appointments/{userId}', 'AppointmentController@index');
Route::post('/appointments', 'AppointmentController@store');
Route::put('/appointments/{appointmentId}', 'AppointmentController@update');
Route::delete('/appointments/{appointmentId}', 'AppointmentController@destroy');

Route::get('/prescriptions/{userId}', 'PrescriptionController@index');
Route::post('/prescriptions', 'PrescriptionController@store');
Route::put('/prescriptions/{prescriptionId}', 'PrescriptionController@update');
Route::delete('/prescriptions/{prescriptionId}', 'PrescriptionController@destroy');

Route::post('/forums', 'ForumController@store');
Route::get('/forums/posts', 'PostController@index');
Route::post('/forums/{forumId}/posts', 'PostController@store');
Route::put('/posts/{postId}', 'PostController@update');
Route::delete('/posts/{postId}', 'PostController@destroy');

Route::post('/incident-reports', 'IncidentReportController@store');
Route::get('/incident-reports/{userId}', 'IncidentReportController@index');
Route::put('/incident-reports/{reportId}', 'IncidentReportController@update');
Route::delete('/incident-reports/{reportId}', 'IncidentReportController@destroy');

Route::post('/medication-dispensation', 'MedicationDispensationRecordController@store');
Route::get('/medication-dispensation/{patientId}', 'MedicationDispensationRecordController@index');
Route::put('/medication-dispensation/{recordId}', 'MedicationDispensationRecordController@update');
Route::delete('/medication-dispensation/{recordId}', 'MedicationDispensationRecordController@destroy');
