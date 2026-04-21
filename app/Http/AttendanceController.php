<?php
// app/Http/Controllers/AttendanceController.php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // ============ LISTAR ASISTENCIAS ============
    public function index(Request $request)
    {
        $query = Attendance::with('member');
        
        if ($request->has('date')) {
            $query->whereDate('check_in', $request->date);
        }
        
        if ($request->has('member_id')) {
            $query->where('member_id', $request->member_id);
        }
        
        $attendances = $query->orderBy('check_in', 'desc')->get();
        return response()->json($attendances);
    }
    
    // ============ REGISTRAR ENTRADA (CHECK-IN) ============
    public function checkIn(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:users,id',
            'method' => 'nullable|string'
        ]);
        
        // Verificar si ya tiene entrada hoy sin salida
        $existing = Attendance::where('member_id', $request->member_id)
            ->whereDate('check_in', Carbon::today())
            ->whereNull('check_out')
            ->first();
            
        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'El miembro ya tiene una entrada activa hoy'
            ], 400);
        }
        
        $attendance = Attendance::create([
            'member_id' => $request->member_id,
            'check_in' => Carbon::now(),
            'check_out' => null,
            'check_in_method' => $request->get('method', 'manual')
        ]);
        
        // Incrementar contador de asistencias del miembro
        $member = Member::find($request->member_id);
        if ($member) {
            $member->increment('attendance_count');
        }
        
        return response()->json([
            'success' => true,
            'data' => $attendance,
            'message' => 'Check-in registrado exitosamente'
        ]);
    }
    
    // ============ REGISTRAR SALIDA (CHECK-OUT) ============
    public function checkOut(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        
        if ($attendance->check_out) {
            return response()->json([
                'success' => false,
                'message' => 'Ya tiene registro de salida'
            ], 400);
        }
        
        $attendance->update([
            'check_out' => Carbon::now(),
            'check_out_method' => $request->get('method', 'manual')
        ]);
        
        return response()->json([
            'success' => true,
            'data' => $attendance,
            'message' => 'Check-out registrado exitosamente'
        ]);
    }
    
    // ============ REGISTRO RÁPIDO (Entrada o Salida) ============
    public function quickRegister(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:users,id',
            'type' => 'required|in:checkin,checkout',
            'method' => 'nullable|string'
        ]);
        
        if ($request->type === 'checkin') {
            return $this->checkIn($request);
        } else {
            // Buscar la entrada activa de hoy
            $attendance = Attendance::where('member_id', $request->member_id)
                ->whereDate('check_in', Carbon::today())
                ->whereNull('check_out')
                ->first();
                
            if (!$attendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró una entrada activa para hoy'
                ], 404);
            }
            
            return $this->checkOut($request, $attendance->id);
        }
    }
    
    // ============ ASISTENCIAS DE HOY ============
    public function today()
    {
        $attendances = Attendance::with('member')
            ->whereDate('check_in', Carbon::today())
            ->orderBy('check_in', 'desc')
            ->get();
            
        return response()->json($attendances);
    }
    
    // ============ ASISTENCIAS POR MIEMBRO ============
    public function memberAttendance($memberId)
    {
        $attendances = Attendance::with('member')
            ->where('member_id', $memberId)
            ->orderBy('check_in', 'desc')
            ->get();
            
        return response()->json($attendances);
    }
    
    // ============ ESTADÍSTICAS DE ASISTENCIA ============
    public function stats(Request $request)
    {
        $date = $request->get('date', Carbon::today());
        $totalMembers = Member::where('status', 'activo')->count();
        $todayAttendance = Attendance::whereDate('check_in', $date)->count();
        $activeNow = Attendance::whereNull('check_out')
            ->whereDate('check_in', Carbon::today())
            ->count();
        
        $percentage = $totalMembers > 0 ? round(($todayAttendance / $totalMembers) * 100) : 0;
        
        return response()->json([
            'today_attendance' => $todayAttendance,
            'active_now' => $activeNow,
            'percentage' => $percentage,
            'total_members' => $totalMembers
        ]);
    }
}