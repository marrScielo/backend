<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Contactos\ContactosController;
use App\Http\Controllers\Psicologos\PsicologosController;
use App\Http\Controllers\User\UserController;


Route::controller(AuthController::class)->prefix('auth')->group(function(){
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

Route::controller(UserController::class)->prefix('users')->group(function(){
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN']], function () {
    Route::post('/register', 'register');
    });
});

Route::controller(ContactosController::class)->prefix('contactos')->group(function () {
    Route::post('/create', 'createContact');
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN|USER']], function () {
        Route::get('/show', 'showAllContact');
    });
});

Route::controller(PsicologosController::class)->prefix('psicologos')->group(function () {
    Route::get('/show', 'showAllPsicologos');
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN']], function () {
        Route::post('/create', 'createPsicologo');
    });
});
