<?php

use App\Http\Controllers\Administradores\AdministradoresController;
use App\Http\Controllers\Atencion\AtencionController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Contactos\ContactosController;
use App\Http\Controllers\Psicologos\PsicologosController;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Citas\CitaController;
use App\Http\Controllers\Comentarios\ComentarioController;
use App\Http\Controllers\Especialidad\EspecialidadController;
use App\Http\Controllers\Categoria\CategoriaController;
use App\Http\Controllers\Enfermedad\EnfermedadController;
use App\Http\Controllers\Pacientes\PacienteController;
use App\Http\Controllers\Prepaciente\PrePacienteController;
use App\Http\Controllers\RespuestasBlog\RespuestaComentarioController;
use App\Http\Controllers\RegistroFamiliar\RegistroFamiliarController;

use function PHPUnit\Framework\callback;

Route::controller(AuthController::class)->prefix('auth')->group(function () {
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


        Route::get('all', 'pacientesAll');
        Route::get('citas/{id}', 'getCitasPaciente');
        Route::get('search/nombre', 'searchPacienteByNombre');


        Route::get('/', 'showPacientesByPsicologo');
        Route::put('/{id}', 'updatePaciente');
        Route::delete('/{id}', 'destroyPaciente');


        Route::get('/{id}', 'showPacienteById');
    });
});

Route::controller(PsicologosController::class)->prefix('psicologos')->group(function () {
    Route::get('/', 'showAllPsicologos');
    Route::get('/{id}', 'showById');

    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN|PSICOLOGO']], function () {
        Route::post('/', 'createPsicologo');
        Route::put('/{id}', 'updatePsicologo');
        Route::patch('/{id}', 'cambiarEstadoPsicologo');
        Route::get('/dashboard', 'psicologoDashboard');
    });
});


Route::controller(BlogController::class)->prefix('blogs')->group(function () {
    Route::get('/authors', 'showAllAuthors');
    Route::get('/{id}', 'showbyIdBlog');
    Route::get('/all', 'showAllBlogs');
    Route::get('/', 'BlogAllPreviews');
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN|PSICOLOGO']], function () {
        Route::post('/', 'createBlog');
        Route::put('/{id}', 'updateBlog');
        Route::delete('/{id}', 'destroyBlog');
    });
});

Route::controller(ComentarioController::class)->prefix('comentarios')->group(function () {
    Route::post('/{id}', 'createComentario');
    Route::get('/{id}', 'showComentariosByBlog');
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN|PSICOLOGO']], function () {
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
        Route::post('/', 'createCategoria');
    });
});

Route::controller(CitaController::class)->prefix('citas')->group(function () {
    // Ruta pública
    Route::get('/pendientes/{id}', 'showCitasPendientes');

    // Rutas protegidas
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN|PSICOLOGO']], function () {
        Route::get('/', 'showAllCitasByPsicologo');
        Route::post('/', 'createCita');
        Route::get('/{id}', 'showCitaById');
        Route::put('/{id}', 'updateCita');
        Route::delete('/{id}', 'destroyCita');
        Route::patch('/{id}/estado',  'updateEstadoCita');

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
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN|PSICOLOGO']], function () {
        Route::get('/ultima/cita/{id}', 'showAtencionByCita');
        Route::get('/paciente/{id}', 'showAllAtencionesPaciente');
        Route::get('/', 'showAllAtenciones');
        Route::post('/{idCita}', 'createAtencion');
        Route::put('/{idCita}', 'updateAtencion');
        Route::delete('/{id}', 'destroyAtencion');
        Route::get('/{id}', 'showAtencion');
        Route::get('/atencion/{idAtencion}/documento/download', 'downloadDocumentoAtencion');
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

Route::controller(EnfermedadController::class)->prefix('enfermedades')->group(function () {
    Route::get('/', 'showAll');
});

Route::controller(PrePacienteController::class)->prefix('pre-pacientes')->group(function () {
    Route::post('/', 'createPrePaciente');
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN|PSICOLOGO']], function () {
        Route::get('/{id}', 'showPrePaciente');
        Route::put('/{id}', 'updatePrePaciente');
        Route::delete('/{id}', 'destroyPrePaciente');
    });
});

Route::controller(UserController::class)->prefix('user')->group(function () {
    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN']], function () {
        Route::post('/', 'register');
    });
});

Route::controller(AdministradoresController::class)->prefix('administradores')->group(function (): void {
    Route::get('/', 'showAllAdministradores');
    Route::get('/{id}', 'showById');

    Route::group(['middleware' => ['auth:sanctum', 'role:ADMIN']], function () {
        Route::post('/', 'createAdministradores');
        Route::put('/{id}', 'updateAdministradores');
        Route::patch('/{id}', 'cambiarEstadoAdministrador');
    });
});
