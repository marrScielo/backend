<?php

namespace App\Http\Controllers\Categorias;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Http\Requests\PostCategorias\CategoriaRequest;
use App\Traits\HttpResponseHelper;

class CategoriaController extends Controller
{
    public function createCategoria(CategoriaRequest $request)
    {
        try {
            Categoria::create($request->all());

            return HttpResponseHelper::make()
                ->successfulResponse('Categoría creada correctamente')
                ->send();

        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al procesar la solicitud. ' . $e->getMessage())
                ->send();
        }
    }

    public function showAllCategorias()
    {
        try {
            $categorias = Categoria::all();

            return HttpResponseHelper::make()
                ->successfulResponse('Lista de categorías obtenida correctamente', $categorias)
                ->send();

        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al obtener las categorías: ' . $e->getMessage())
                ->send();
        }
    }

    public function update(CategoriaRequest $request, Categoria $categoria)
    {
        try {
            $categoria->update($request->all());

            return HttpResponseHelper::make()
                ->successfulResponse('Categoría actualizada correctamente')
                ->send();
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al actualizar la categoría: ' . $e->getMessage())
                ->send();
        }
    }

    public function destroy(Categoria $categoria)
    {
        try {
            $categoria->delete();

            return HttpResponseHelper::make()
                ->successfulResponse('Categoría eliminada correctamente')
                ->send();
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al eliminar la categoría: ' . $e->getMessage())
                ->send();
        }
    }
}