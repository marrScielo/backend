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
use App\Http\Controllers\AtencionController;
use App\Http\Controllers\RegistroFamiliar\RegistroFamiliarController;

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
    Route::post('/', 'createPaciente');
    Route::get('/{id}', 'showPacienteById');
    Route::get('/', 'showPacientesByPsicologo');
    Route::put('/{id}', 'updatePaciente');
    Route::delete('/{id}', 'destroyPaciente');
    });
});

Route::controller(PsicologosController::class)->prefix('psicologos')->group(function () {
    Route::get('/', 'showAllPsicologos');
    Route::get('/{id}', 'showById');
    
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN']], function () {
        Route::post('/', 'createPsicologo');
        Route::put('/{id}', 'updatePsicologo');
        Route::post('/{id}', 'desactivatePsicologo');
    });
});

Route::controller(BlogController::class)->prefix('blogs')->group(function () {
    Route::get('/{id}', 'showbyIdBlog');
    Route::get('/all', 'showAllBlogs');
    Route::get('/','BlogAllPreviews');
    Route::get('/authors','showAllAuthors');
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN|PSICOLOGO']], function () {
    Route::post('/', 'createBlog');
    Route::put('/{id}', 'updateBlog');
    Route::delete('/{id}', 'destroyBlog');
    });
});

Route::controller(ComentarioController::class)->prefix('comentarios')->group(function () {
    Route::post('/{id}', 'createComentario');
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN|PSICOLOGO']], function () {
    Route::get('/{id}', 'showComentariosByBlog'); 
    Route::delete('/{id}', 'destroyComentario');
    });
});

Route::controller(EspecialidadController::class)->prefix('especialidades')->group(function () {
    Route::get('/', 'showAll');
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN']], function () {
    Route::post('/', 'createEspecialidad');
    Route::put('/{id}', 'updateEspecialidad');
    Route::delete('/{id}', 'destroyEspecialidad');
    });
});

Route::controller(CategoriaController::class)->prefix('categorias')->group(function () {
    Route::get('/', 'showAll');
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN|PSICOLOGO']], function () {
    Route::post('/','createCategoria');
    });
});

Route::controller(CitaController::class)->prefix('citas')->group(function () {
    Route::get('/pendientes/{id}', 'showCitasPendientes'); 
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN|PSICOLOGO']], function () {
    Route::get('/', 'showAllCitasByPsicologo'); 
    Route::post('/', 'createCita');
    Route::get('/{id}', 'showCitaById');
    Route::put('/{id}', 'updateCita');
    Route::delete('/{id}', 'destroyCita');
    });
});

Route::controller(RespuestaComentarioController::class)->prefix('respuestas')->group(function () {
    Route::post('/', 'createRespuesta');
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN|PSICOLOGO']], function () {
    Route::get('/{id}', 'showRespuestasByComentario');
    Route::delete('/{id}', 'destroyRespuesta');
    });
});

Route::controller(AtencionController::class)->prefix('atenciones')->group(function () {
    Route::post('/', 'createAtencion');
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN|PSICOLOGO']], function () {
    Route::get('/{id}', 'showAtencion');
    Route::put('/{id}', 'updateAtencion');
    Route::delete('/{id}', 'destroyAtencion');
    });
});

Route::controller(RegistroFamiliarController::class)->prefix('registros')->group(function () {
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN|PSICOLOGO']], function () {
    Route::post('/{id}', 'createRegistro');
    Route::get('/{id}', 'showRegistro');
    Route::put('/{id}', 'updateRegistro');
    Route::delete('/{id}', 'destroyRegistro');
    });
});

