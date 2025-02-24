<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Contactos\ContactosController;
use App\Http\Controllers\Psicologos\PsicologosController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Categorias\CategoriaController;
use App\Http\Controllers\Especialidad\EspecialidadController;


Route::controller(AuthController::class)->prefix('auth')->group(function(){
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

Route::controller(UserController::class)->prefix('users')->group(function(){
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN']], function () {
    Route::post('/register', 'register');
    });
});


Route::post('/contactos/create', [ContactosController::class, 'createContact']);
/*Route::prefix('contactos')->group(function () {
    Route::post('/create', [ContactosController::class, 'createContact']); // Asegurar que existe esta ruta
});*/

Route::controller(PsicologosController::class)->prefix('psicologos')->group(function () {
    Route::get('/show', 'showAllPsicologos');
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN']], function () {
        Route::post('/create', 'createPsicologo');
    });
});

Route::controller(CategoriaController::class)->prefix('categorias')->group(function () {
    Route::get('/show', 'showAllCategoria');
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN']], function () {
        Route::post('/create', 'createCategoria');
        Route::put('/update/{id}', 'updateCategoria');
        Route::delete('/delete/{id}', 'destroyCategoria');
    });
});

Route::controller(BlogController::class)->prefix('blogs')->group(function () {
    Route::post('/create', 'store');
    Route::get('/show/{id}', 'show');
    Route::get('/all', 'index');
    Route::put('/update/{id}', 'update');
    Route::delete('/delete/{id}', 'destroy');
});

Route::controller(EspecialidadController::class)->prefix('especialidades')->group(function () {
    Route::post('/create', 'store');
    Route::get('/show/{id}', 'show');
    Route::get('/all', 'index');
    Route::put('/update/{id}', 'update');
    Route::delete('/delete/{id}', 'destroy');
});

