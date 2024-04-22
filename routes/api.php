<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\MedicationDispensationRecordController;
use App\Http\Controllers\HealthcareProviderController;
use Illuminate\Http\Request;

use App\Http\Controllers\ComplianceController;



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
Route::get('/users/role/{role}', 'UserController@getUsersByRole');
Route::put('/users/{id}', 'UserController@update');
Route::delete('/users/{id}', 'UserController@destroy');


// Route::get('/medical_records', [MedicalRecordController::class, 'index']);
// Route::post('/medical_records', [MedicalRecordController::class, 'store']);
// Route::get('/medical_records/{id}', [MedicalRecordController::class, 'show']);
// Route::put('/medical_records/{id}', [MedicalRecordController::class, 'update']);
// Route::delete('/medical_records/{id}', [MedicalRecordController::class, 'destroy']);


// Route::apiResource('appointments', AppointmentController::class);


// Route::apiResource('prescriptions', PrescriptionController::class);

// Route::apiResource('medication_dispensation_records', MedicationDispensationRecordController::class);


Route::get('/medical-records/{userId}', 'MedicalRecordController@index');
Route::get('/medical-records', 'MedicalRecordController@hpIndex');
Route::post('/medical-records', 'MedicalRecordController@store');
Route::put('/medical-records/{recordId}', 'MedicalRecordController@update');
Route::delete('/medical-records/{recordId}', 'MedicalRecordController@destroy');

Route::post('/openai', function (Request $request) {
    $response = Http::withHeaders([
        'Authorization' => 'Bearer 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',
        'Content-Type' => 'application/json'
    ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [['role' => 'user', 'content' => $request->input('prompt')]],
                'max_tokens' => 500
            ]);
    return $response->json();
});

Route::get('/providers', [HealthcareProviderController::class, 'getAllProviders']);
Route::put('/provider/{id}', 'HealthcareProviderController@update');
Route::delete('/provider/{id}', 'HealthcareProviderController@destroy');
Route::get('/providers/{userId}', [HealthcareProviderController::class, 'getProvider']);
Route::get('/appointments/{userId}', 'AppointmentController@index');
Route::get('/appointments/hp/{hpId}', 'AppointmentController@hpindex');
Route::post('/appointments', 'AppointmentController@store');
Route::put('/appointments/{appointmentId}', 'AppointmentController@update');
Route::delete('/appointments/{appointmentId}', 'AppointmentController@destroy');

Route::get('/prescriptions/{userId}', 'PrescriptionController@index');
Route::get('/prescriptions/email/{userEmail}', 'PrescriptionController@emailIndex');
Route::get('/prescriptions/hp/{hpId}', 'PrescriptionController@hpindex');
Route::get('/prescriptions', 'PrescriptionController@getAllPrescriptions');
Route::post('/prescriptions', 'PrescriptionController@store');
Route::put('/prescriptions/{prescriptionId}', 'PrescriptionController@update');
Route::delete('/prescriptions/{prescriptionId}', 'PrescriptionController@destroy');

Route::post('/forums', 'ForumController@store');
Route::get('/forums', 'ForumController@getForums');
Route::put('/forums/{id}', 'ForumController@update');
Route::delete('/forums/{id}', 'ForumController@destroy');
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


Route::get('/facilities', 'FacilityController@showAll');
Route::post('/facilities', 'FacilityController@store');
Route::put('/facilities/{facility}', 'FacilityController@update');
Route::delete('/facilities/{facility}', 'FacilityController@destroy');



Route::get('/compliances', [ComplianceController::class, 'showAll']);
Route::post('/compliances', [ComplianceController::class, 'store']);
Route::put('/compliances/{compliance}', [ComplianceController::class, 'update']);
Route::delete('/compliances/{compliance}', [ComplianceController::class, 'destroy']);