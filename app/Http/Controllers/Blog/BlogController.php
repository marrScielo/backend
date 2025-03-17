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


            if (!$psicologo) {
                return HttpResponseHelper::make()
                    ->forbiddenResponse('No tienes permisos para crear un blog')
                    ->send();
            }

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
            // Obtener blogs con la relación de categoría
            $blogs = Blog::with('categoria:idCategoria,nombre')->get();

            // Transformar la respuesta para incluir el nombre de la categoría en lugar del ID
            $blogs = $blogs->map(function ($blog) {
                return [
                    'idBlog' => $blog->idBlog,
                    'tema' => $blog->tema,
                    'contenido' => $blog->contenido,
                    'imagen' => $blog->imagen,
                    'idPsicologo' => $blog->idPsicologo,
                    'categoria' => $blog->categoria ? $blog->categoria->nombre : null, // Obtener solo el nombre
                ];
            });

            return HttpResponseHelper::make()
                ->successfulResponse('Lista de blogs obtenida correctamente', $blogs)
                ->send();
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al obtener los blogs: ' . $e->getMessage())
                ->send();
        }
    }

    public function BlogAllPreviews()
    {

        try {
            $blogs = Blog::with([
                'categoria:idCategoria,nombre',
                'psicologo:idPsicologo,user_id',
                'psicologo.users:user_id,name,apellido,imagen',


            ])->get();

            $blogs = $blogs->map(fn($blog) => [
                'idBlog' => $blog->idBlog,
                'tema' => $blog->tema,
                'contenido' => $blog->contenido,
                'imagen' => $blog->imagen,
                'psicologo' => $blog->psicologo?->users?->name,
                'psicologApellido' => $blog->psicologo?->users?->apellido,
                'psicologoImagenId' => $blog->psicologo?->users->imagen,
                'categoria' => $blog->categoria?->nombre,
                'fecha' => $blog->fecha_publicado,
            ]);

            return HttpResponseHelper::make()
                ->successfulResponse('Lista de blogs obtenida correctamente', $blogs)
                ->send();
        } catch (\Exception $e) {
            return HttpResponseHelper::make()
                ->internalErrorResponse('Ocurrió un problema al obtener los blogs: ' . $e->getMessage())
                ->send();
        }
    }


    public function showby($id)
    {
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

    public function showAllAuthors()
    {
        try {
            $authors = Blog::with('psicologo.users')
                ->get()
                ->map(function ($blog) {
                    return [
                        'id' => $blog->psicologo->idPsicologo,
                        'name' => $blog->psicologo?->users?->name,
                        'lastname' => $blog->psicologo?->users?->apellido,
                        'photo' => $blog->psicologo?->users?->imagen,
                    ];
                })

                ->unique('name')
                ->values();


                return HttpResponseHelper::make()
                ->successfulResponse('Autores Publicados blogs', $authors)
                ->send();
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al obtener autores: ' . $th->getMessage()], 500);
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
