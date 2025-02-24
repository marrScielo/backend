<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Contactos\ContactosController;
use App\Http\Controllers\Psicologos\PsicologosController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Blog\BlogController;
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

Route::controller(ContactosController::class)->prefix('contactos')->group(function () {
    Route::post('/create', 'createContact');
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN']], function () {
        Route::get('/show', 'showAllContact');
    });
});

Route::controller(PsicologosController::class)->prefix('psicologos')->group(function () {
    Route::get('/showAll', 'showAllPsicologos');
    Route::get('/show/{id}', 'showById');
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN']], function () {
        Route::post('/create', 'createPsicologo');
    });
});

Route::controller(BlogController::class)->prefix('blogs')->group(function () {
    Route::post('/create', 'createBlog');
    Route::get('/show/{id}', 'show');
    Route::get('/all', 'showAllBlogs');
    Route::put('/update/{id}', 'updateBlog');
    Route::delete('/delete/{id}', 'destroyBlog');
});

Route::controller(EspecialidadController::class)->prefix('especialidades')->group(function () {
    Route::post('/create', 'createEspecialidad');
    Route::get('/show', 'showAll');
    Route::put('/update/{id}', 'updateEspecialidad');
    Route::delete('/delete/{id}', 'destroyEspecialidad');
});

