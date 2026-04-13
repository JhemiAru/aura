<?php
// app/Http/Controllers/EquipmentController.php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipment = Equipment::all();
        return response()->json($equipment);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|string',
            'brand' => 'nullable|string',
            'model' => 'nullable|string',
            'location' => 'nullable|string'
        ]);

        $equipment = Equipment::create($request->all());
        return response()->json(['success' => true, 'data' => $equipment, 'message' => 'Equipo agregado']);
    }

    public function show($id)
    {
        $equipment = Equipment::findOrFail($id);
        return response()->json($equipment);
    }

    public function update(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:100',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|string',
            'brand' => 'nullable|string',
            'model' => 'nullable|string',
            'location' => 'nullable|string'
        ]);

        $equipment->update($request->all());
        return response()->json(['success' => true, 'data' => $equipment, 'message' => 'Equipo actualizado']);
    }

    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();
        return response()->json(['success' => true, 'message' => 'Equipo eliminado']);
    }
}