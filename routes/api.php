<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Contactos\ContactosController;
use App\Http\Controllers\Psicologos\PsicologosController;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Citas\CitaController;
use App\Http\Controllers\Comentarios\ComentarioController;
use App\Http\Controllers\Especialidad\EspecialidadController;
use App\Http\Controllers\Categoria\CategoriaController;
use App\Http\Controllers\Pacientes\PacienteController;
use App\Http\Controllers\RespuestasBlog\RespuestaComentarioController;

Route::controller(AuthController::class)->prefix('auth')->group(function(){
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

Route::controller(ContactosController::class)->prefix('contactos')->group(function () {
    Route::post('/create', 'createContact')->middleware('throttle:100,1'); 
    
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN']], function () {
        Route::get('/show', 'showAllContact');
    });
});

Route::controller(PacienteController::class)->prefix('pacientes')->group(function () {
    Route::group(['middleware' => ['auth:sanctum', 'role:PSICOLOGO']], function () {
    Route::post('/create', 'createPaciente'); 
    Route::get('/show/{id}', 'showPacienteById'); 
    Route::get('/showAll', 'showPacientesByPsicologo'); 
    Route::put('/update/{id}', 'updatePaciente');
    Route::delete('/delete/{id}', 'destroyPaciente');
    });
});


Route::controller(PsicologosController::class)->prefix('psicologos')->group(function () {
    Route::get('/showAll', 'showAllPsicologos');
    Route::get('/show/{id}', 'showById');
    
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN']], function () {
        Route::post('/create', 'createPsicologo');
        Route::put('/update/{id}', 'updatePsicologo');
        Route::post('/delete/{id}', 'desactivatePsicologo');
        Route::delete('/delete/{id}', 'DeletePsicologo');
    });
});

Route::controller(BlogController::class)->prefix('blogs')->group(function () {
    Route::get('/show/{id}', 'showbyIdBlog');
    Route::get('/all', 'showAllBlogs');
    Route::get('/getAll','BlogAllPreviews');
    Route::get('/authors','showAllAuthors');
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN|PSICOLOGO']], function () {
    Route::post('/create', 'createBlog');
    Route::put('/update/{id}', 'updateBlog');
    Route::delete('/delete/{id}', 'destroyBlog');
    });
});

Route::controller(ComentarioController::class)->prefix('comentarios')->group(function () {
    Route::post('/create', 'createComentario');
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN|PSICOLOGO']], function () {
    Route::get('/show/{id}', 'showComentariosByBlog'); 
    Route::delete('/delete/{id}', 'destroyComentario');
    });
});

Route::controller(EspecialidadController::class)->prefix('especialidades')->group(function () {
    Route::get('/show', 'showAll');
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN']], function () {
    Route::post('/create', 'createEspecialidad');
    Route::put('/update/{id}', 'updateEspecialidad');
    Route::delete('/delete/{id}', 'destroyEspecialidad');
    });
});

Route::controller(CategoriaController::class)->prefix('categorias')->group(function () {
    Route::get('/show', 'showAll');
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN|PSICOLOGO']], function () {
    Route::post('/create','createCategoria');
    });
});

Route::controller(CitaController::class)->prefix('citas')->middleware('auth:sanctum')->group(function () {
    Route::get('/showAll', 'showAllCitas'); 
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN|PSICOLOGO']], function () {
    Route::post('/create', 'createCita');
    Route::get('show/{id}', 'showCita');
    Route::put('update/{id}', 'updateCita');
    Route::delete('delete/{id}', 'destroyCita');
    });
});

Route::controller(RespuestaComentarioController::class)->prefix('respuestas')->group(function () {
    Route::post('/create', 'createRespuesta');
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN|PSICOLOGO']], function () {
    Route::get('/show/{id}', 'showRespuestasByComentario');
    Route::delete('/delete/{id}', 'destroyRespuesta');
    });
});

