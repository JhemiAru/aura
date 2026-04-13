<?php
// app/Http/Controllers/TrainerController.php

namespace App\Http\Controllers;

use App\Models\Trainer;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index()
    {
        $trainers = Trainer::all();
        return response()->json($trainers);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'specialty' => 'required|string',
            'email' => 'required|email|unique:trainers',
            'phone' => 'nullable|string',
            'years_experience' => 'nullable|integer',
            'bio' => 'nullable|string'
        ]);

        $trainer = Trainer::create($request->all());
        return response()->json(['success' => true, 'data' => $trainer, 'message' => 'Entrenador creado']);
    }

    public function show($id)
    {
        $trainer = Trainer::findOrFail($id);
        return response()->json($trainer);
    }

    public function update(Request $request, $id)
    {
        $trainer = Trainer::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:100',
            'specialty' => 'required|string',
            'email' => 'required|email|unique:trainers,email,' . $id,
            'phone' => 'nullable|string',
            'years_experience' => 'nullable|integer',
            'bio' => 'nullable|string'
        ]);

        $trainer->update($request->all());
        return response()->json(['success' => true, 'data' => $trainer, 'message' => 'Entrenador actualizado']);
    }

    public function destroy($id)
    {
        $trainer = Trainer::findOrFail($id);
        $trainer->delete();
        return response()->json(['success' => true, 'message' => 'Entrenador eliminado']);
    }
}