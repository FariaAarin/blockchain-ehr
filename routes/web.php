<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PathologyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [AdminController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::group(['prefix' => 'doctor', 'middleware' => ['auth']], function(){
    Route::get('/', [DoctorController::class, 'index'])->name('doctor.list'); 
    Route::post('/store', [DoctorController::class, 'store'])->name('doctor.store'); 
    Route::post('/update', [DoctorController::class, 'update'])->name('doctor.update'); 
    Route::get('/destroy/{id}', [DoctorController::class, 'destroy'])->name('doctor.destroy'); 
   
});

Route::group(['prefix' => 'patient', 'middleware' => ['auth']], function(){
    Route::get('/', [PatientController::class, 'index'])->name('patient.list'); 
    Route::post('/store', [PatientController::class, 'store'])->name('patient.store'); 
    Route::post('/update', [PatientController::class, 'update'])->name('patient.update'); 
    Route::get('/destroy/{id}', [PatientController::class, 'destroy'])->name('patient.destroy');
    
    Route::get('/prescribe', [PatientController::class, 'prescribe'])->name('patient.prescribe');
    Route::post('/prescribeStore', [PatientController::class, 'prescribeStore'])->name('prescribe.store');
    Route::get('/prescribe/list', [PatientController::class, 'prescribeList'])->name('prescribe.list');
    Route::get('/prescription/print', [PatientController::class, 'prescriptionPrint'])->name('prescription.print');
   
   
});

Route::group(['prefix' => 'pathology', 'middleware' => ['auth']], function(){
    Route::get('/', [PathologyController::class, 'index'])->name('pathology.list'); 
    Route::post('/store', [PathologyController::class, 'store'])->name('pathology.store'); 
    Route::post('/update', [PathologyController::class, 'update'])->name('pathology.update'); 
    Route::get('/destroy/{id}', [PathologyController::class, 'destroy'])->name('pathology.destroy'); 
   
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
