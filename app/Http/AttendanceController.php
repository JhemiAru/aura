<?php
// app/Http/Controllers/AttendanceController.php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('member');
        
        if ($request->has('date')) {
            $query->whereDate('date', $request->date);
        }
        
        $attendances = $query->orderBy('check_in_time', 'desc')->get();
        return response()->json($attendances);
    }

    public function register(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'type' => 'required|in:checkin,checkout',
            'method' => 'required|in:manual,qr,app'
        ]);

        $member = Member::findOrFail($request->member_id);
        $today = Carbon::today();
        $now = Carbon::now();

        if ($request->type === 'checkin') {
            // Verificar si ya hizo check-in hoy
            $existing = Attendance::where('member_id', $request->member_id)
                ->whereDate('date', $today)
                ->whereNull('check_out_time')
                ->first();
                
            if ($existing) {
                return response()->json(['success' => false, 'message' => 'Ya tiene un check-in activo'], 400);
            }

            $attendance = Attendance::create([
                'member_id' => $request->member_id,
                'date' => $today,
                'check_in_time' => $now,
                'check_in_method' => $request->method
            ]);
            
            // Incrementar contador de asistencias del miembro
            $member->increment('attendance_count');
            
            return response()->json(['success' => true, 'data' => $attendance, 'message' => 'Check-in registrado']);
        } 
        else {
            // Checkout
            $attendance = Attendance::where('member_id', $request->member_id)
                ->whereDate('date', $today)
                ->whereNull('check_out_time')
                ->first();
                
            if (!$attendance) {
                return response()->json(['success' => false, 'message' => 'No hay check-in activo para hoy'], 400);
            }

            $attendance->update([
                'check_out_time' => $now,
                'check_out_method' => $request->method
            ]);
            
            return response()->json(['success' => true, 'data' => $attendance, 'message' => 'Check-out registrado']);
        }
    }

    public function checkout($id)
    {
        $attendance = Attendance::findOrFail($id);
        
        if ($attendance->check_out_time) {
            return response()->json(['success' => false, 'message' => 'Ya tiene check-out registrado'], 400);
        }

        $attendance->update([
            'check_out_time' => Carbon::now(),
            'check_out_method' => 'manual'
        ]);

        return response()->json(['success' => true, 'message' => 'Check-out registrado']);
    }

    public function stats(Request $request)
    {
        $date = $request->get('date', Carbon::today());
        $totalMembers = Member::where('status', 'activo')->count();
        $todayAttendance = Attendance::whereDate('date', $date)->count();
        $percentage = $totalMembers > 0 ? round(($todayAttendance / $totalMembers) * 100) : 0;

        return response()->json([
            'count' => $todayAttendance,
            'percentage' => $percentage,
            'total_members' => $totalMembers
        ]);
    }
}