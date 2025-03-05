<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostBlogs\PostBlogs;
use App\Models\Psicologo;
use App\Traits\HttpResponseHelper;

class BlogController extends Controller
{
    public function createBlog(PostBlogs $request)
    {
        try {
            $userId = Auth::id();
            $psicologo = Psicologo::where('user_id', $userId)->first();

            $data = $request->all();
            $data['idPsicologo'] = $psicologo->idPsicologo;

            Blog::create($data);

            return HttpResponseHelper::make()
                ->successfulResponse('Blog creado correctamente')
                ->send();

        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al procesar la solicitud. ' . $e->getMessage())
                ->send();
        }
    }

    public function showAllBlogs()
    {
        try {
            $blogs = Blog::all();

            return HttpResponseHelper::make()
                ->successfulResponse('Lista de blogs obtenida correctamente', $blogs)
                ->send();

        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al obtener los blogs: ' . $e->getMessage())
                ->send();
        }
    }
    public function showby($id){
        try {
            $blog = Blog::find($id);
    
            if (!$blog) {
                return HttpResponseHelper::make()
                    ->notFoundResponse('El blog no fue encontrado')->send();
            }
    
            return HttpResponseHelper::make()
                ->successfulResponse('Blog obtenido correctamente', $blog->toArray())->send();
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al obtener el blog: ' . $e->getMessage())->send();
        }
    }
    

    public function updateBlog(PostBlogs $request, int $id)
    {
        try {
            $blog = Blog::findOrFail($id);
            $blog->update($request->all());

            return HttpResponseHelper::make()
                ->successfulResponse('Blog actualizado correctamente')
                ->send();
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al actualizar el blog: ' . $e->getMessage())
                ->send();
        }
    }

    public function destroyBlog(int $id)
    {
        try {
            $blog = Blog::findOrFail($id);
            $blog->delete();

            return HttpResponseHelper::make()
                ->successfulResponse('Blog eliminado correctamente')
                ->send();
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Error al eliminar el blog: ' . $e->getMessage())
                ->send();
        }
    }
}
