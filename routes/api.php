<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Contactos\ContactosController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Psicologos\PsicologoController;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Categorias\CategoriaController;
use App\Http\Controllers\Especialidad\EspecialidadController;


Route::controller(AuthController::class)->prefix('auth')->group(function(){
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

Route::controller(UserController::class)->prefix('users')->group(function(){
    Route::post('/register', 'register');
});

Route::controller(ContactosController::class)->prefix('contactos')->group(function () {
    Route::post('/create', 'createContact');
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN|USER']], function () {
        Route::get('/show', 'showAllContact');
    });
});


Route::controller(PsicologoController::class)->prefix('psicologos')->group(function () {
    Route::post('/create', 'store');
    Route::get('/show/{id}', 'show');
    Route::put('/update/{id}', 'update');
    Route::delete('/delete/{id}', 'destroy');
});

Route::controller(BlogController::class)->prefix('blogs')->group(function () {
    Route::post('/create', 'store');
    Route::get('/show/{id}', 'show');
    Route::get('/all', 'index');
    Route::put('/update/{id}', 'update');
    Route::delete('/delete/{id}', 'destroy');
});

Route::controller(CategoriaController::class)->prefix('categorias')->group(function () {
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

