<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Payment;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // ============ MOSTRAR VISTA ============
    public function index()
    {
        return view('fitnessync');
    }
    
    // ============ OBTENER ESTADÍSTICAS PARA EL DASHBOARD ============
    public function getStats()
    {
        $totalMembers = Member::count();
        $activeMembers = Member::where('status', 'activo')->count();
        
        $monthlyIncome = Payment::whereMonth('payment_date', Carbon::now()->month)
            ->whereYear('payment_date', Carbon::now()->year)
            ->sum('amount');
        
        $todayAttendance = Attendance::whereDate('check_in', Carbon::today())->count();
        
        $retentionRate = $totalMembers > 0 ? round(($activeMembers / $totalMembers) * 100) : 0;
        
        return response()->json([
            'totalMembers' => $totalMembers,
            'activeMembers' => $activeMembers,
            'monthlyIncome' => $monthlyIncome,
            'todayAttendance' => $todayAttendance,
            'retentionRate' => $retentionRate
        ]);
    }
}