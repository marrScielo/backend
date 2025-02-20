<?php

namespace App\Http\Controllers\Categorias;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostCategorias\PostCategorias;
use App\Traits\HttpResponseHelper;

class CategoriaController extends Controller
{

    public function createCategoria(PostCategorias $request)
    {
        try{
            Categoria::create($request->all());

            return HttpResponseHelper::make()
                ->successfulResponse('Categoria creada correctamente')
                ->send();

        }catch(\Exception $e){
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrio un problema al procesar la solicitud.'.
                 $e->getMessage())
                ->send();
        }
    }

    public function showAllCategoria()
    {
        try {
            $categorias = Categoria::all();

            return HttpResponseHelper::make()
                ->successfulResponse('Lista de categorias obtenida correctamente', $categorias)
                ->send();

        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al obtener los contactos: ' . $e->getMessage())
                ->send();
        }
    }

    public function updateCategoria(PostCategorias $request, int $id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->update($request->all());

            return HttpResponseHelper::make()
                ->successfulResponse('Categoría actualizada correctamente')
                ->send();
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al actualizar la categoría: ' . $e->getMessage())
                ->send();
        }
    }

    public function destroyCategoria(int $id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->delete();

            return HttpResponseHelper::make()
                ->successfulResponse('Categoría eliminada correctamente')
                ->send();
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al eliminar la categoría: ' . $e->getMessage())
                ->send();
        }
    }
}
