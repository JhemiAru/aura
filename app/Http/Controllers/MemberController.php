<?php
// app/Http/Controllers/MemberController.php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();
        return response()->json($members);
    }
    
    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string',
            'plan' => 'required|string',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string'
        ]);
        
        // Crear miembro con todos los campos
        $member = Member::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'plan' => $request->plan,
            'status' => 'activo',
            'expiry_date' => Carbon::now()->addMonth(),
            'attendance_count' => 0,
            'registration_date' => Carbon::now(),
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'password' => Hash::make('12345678'), // Contraseña por defecto
            'role' => 'member'
        ]);
        
        return response()->json([
            'success' => true, 
            'data' => $member,
            'message' => 'Miembro creado exitosamente'
        ], 201);
    }
    
    public function show($id)
    {
        $member = Member::with(['attendances', 'payments'])->findOrFail($id);
        return response()->json($member);
    }
    
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'phone' => 'nullable|string',
            'plan' => 'sometimes|string',
            'status' => 'sometimes|string'
        ]);
        
        $member->update($request->all());
        
        return response()->json([
            'success' => true, 
            'data' => $member,
            'message' => 'Miembro actualizado'
        ]);
    }
    
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();
        
        return response()->json([
            'success' => true, 
            'message' => 'Miembro eliminado'
        ]);
    }
}