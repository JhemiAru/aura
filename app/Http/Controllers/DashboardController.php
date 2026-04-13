<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Payment;
use App\Models\GymClass;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('fitnessync');
    }

    public function getStats()
    {
        $totalMembers = Member::count();
        $activeMembers = Member::where('status', 'activo')->count();
        $monthlyIncome = Payment::whereMonth('payment_date', Carbon::now()->month)->sum('amount');
        $activeClasses = GymClass::where('is_active', true)->count();
        $todayAttendance = Attendance::whereDate('date', Carbon::today())->count();
        
        $retentionRate = $totalMembers > 0 ? round(($activeMembers / $totalMembers) * 100) : 0;

        return response()->json([
            'totalMembers' => $totalMembers,
            'activeMembers' => $activeMembers,
            'monthlyIncome' => $monthlyIncome,
            'activeClasses' => $activeClasses,
            'todayAttendance' => $todayAttendance,
            'retentionRate' => $retentionRate
        ]);
    }

    public function getReports(Request $request)
    {
        $type = $request->get('type', 'members');
        $start = $request->get('start');
        $end = $request->get('end');
        $period = $request->get('period', 'month');

        if ($type === 'members') {
            $query = Member::query();
            if ($start) $query->whereDate('created_at', '>=', $start);
            if ($end) $query->whereDate('created_at', '<=', $end);
            $data = $query->get();
            return response()->json($data);
        }
        
        if ($type === 'financial') {
            $query = Payment::query();
            if ($period === 'month') {
                $query->whereMonth('payment_date', Carbon::now()->month);
            } elseif ($period === 'quarter') {
                $query->whereBetween('payment_date', [Carbon::now()->startOfQuarter(), Carbon::now()->endOfQuarter()]);
            } elseif ($period === 'year') {
                $query->whereYear('payment_date', Carbon::now()->year);
            }
            
            $total = $query->sum('amount');
            $count = $query->count();
            $byMethod = $query->selectRaw('payment_method, sum(amount) as total')->groupBy('payment_method')->get();
            
            return response()->json([
                'total' => $total,
                'count' => $count,
                'by_method' => $byMethod
            ]);
        }
        
        return response()->json([]);
    }
}