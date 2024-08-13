<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminDashboarController;
use App\Http\Controllers\AdminTeachersMagmentController;
use App\Http\Controllers\AdminAditionalInfoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', function () {
    return redirect('/');
});
Route::get('/faq', [HomeController::class, 'faq']);
Route::get('/about', [HomeController::class, 'about']);

// Section for add teachers, staff and students
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', [AdminDashboarController::class, 'index']);
    Route::group(['prefix' => 'profesores'], function () {
        Route::get('/', [AdminTeachersMagmentController::class, 'index']);
        Route::get('/agregar', [AdminTeachersMagmentController::class, 'addTeacher']);
        Route::post('/agregar', [AdminTeachersMagmentController::class, 'saveTeacher']);
        Route::get('/editar/{id}', [AdminTeachersMagmentController::class, 'editTeacher']);
        Route::post('/editar/{id}', [AdminTeachersMagmentController::class, 'updateTeacher']);
    });
    Route::group(['prefix' => 'info-adicional'], function () {
        Route::get('/', [AdminAditionalInfoController::class, 'index']);
        Route::group(['prefix' => 'como-nos-encontraste'], function () {
            Route::get('/', [AdminAditionalInfoController::class, 'comoNosEncontraste']);
            Route::get('/agregar', [AdminAditionalInfoController::class, 'addComoNosEncontraste']);
            Route::post('/agregar', [AdminAditionalInfoController::class, 'saveComoNosEncontraste']);
            Route::get('/editar/{id}', [AdminAditionalInfoController::class, 'editComoNosEncontraste']);
            Route::post('/editar/{id}', [AdminAditionalInfoController::class, 'updateComoNosEncontraste']);
        });
        Route::group(['prefix' => 'catedras'], function () {
            Route::get('/', [AdminAditionalInfoController::class, 'catedras']);
            Route::get('/agregar', [AdminAditionalInfoController::class, 'addCatedra']);
            Route::post('/agregar', [AdminAditionalInfoController::class, 'saveCatedra']);
            Route::get('/editar/{id}', [AdminAditionalInfoController::class, 'editCatedra']);
            Route::post('/editar/{id}', [AdminAditionalInfoController::class, 'updateCatedra']);
        });
    });
});
