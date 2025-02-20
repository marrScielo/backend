<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Psicologo;

class PsicologoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Psicologo::with('especialidad')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $psicologo = Psicologo::create($request->all());
        return response()->json($psicologo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Psicologo::with('especialidad')->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $psicologo = Psicologo::findOrFail($id);
        $psicologo->update($request->all());
        return response()->json($psicologo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Psicologo::destroy($id);
        return response()->json(null, 204);
    }
}
