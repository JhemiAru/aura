<?php
// app/Http/Controllers/ClassController.php

namespace App\Http\Controllers;

use App\Models\GymClass;
use App\Models\Trainer;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = GymClass::with('trainer')->get();
        return response()->json($classes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'trainer_id' => 'nullable|exists:trainers,id',
            'day_of_week' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
            'capacity' => 'required|integer|min:1',
            'room' => 'nullable|string'
        ]);

        $class = GymClass::create([
            'name' => $request->name,
            'trainer_id' => $request->trainer_id,
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'capacity' => $request->capacity,
            'room' => $request->room,
            'enrolled' => 0,
            'is_active' => true
        ]);

        return response()->json(['success' => true, 'data' => $class, 'message' => 'Clase creada']);
    }

    public function show($id)
    {
        $class = GymClass::with('trainer')->findOrFail($id);
        return response()->json($class);
    }

    public function update(Request $request, $id)
    {
        $class = GymClass::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:100',
            'trainer_id' => 'nullable|exists:trainers,id',
            'day_of_week' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
            'capacity' => 'required|integer|min:1',
            'room' => 'nullable|string'
        ]);

        $class->update($request->all());
        return response()->json(['success' => true, 'data' => $class, 'message' => 'Clase actualizada']);
    }

    public function destroy($id)
    {
        $class = GymClass::findOrFail($id);
        $class->delete();
        return response()->json(['success' => true, 'message' => 'Clase eliminada']);
    }
}