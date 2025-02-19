<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especialidad;

class EspecialidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Especialidad::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $especialidad = Especialidad::create($request->all());
        return response()->json($especialidad, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Especialidad::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $especialidad = Especialidad::findOrFail($id);
        $especialidad->update($request->all());
        return response()->json($especialidad);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Especialidad::destroy($id);
        return response()->json(null, 204);
    }
}
