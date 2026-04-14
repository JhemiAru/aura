<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Attendance;
use App\Models\Membership;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Verificación manual de roles (sin middleware)
        if (!$user || !$user->role) {
            abort(403, 'Acceso no autorizado');
        }
        
        $role = $user->role->name;

        // Estadísticas comunes
        $totalMembers = Member::count();
        $totalPayments = Payment::sum('amount');
        $todayAttendance = Attendance::whereDate('check_in', today())->count();
        
        // Datos adicionales para la vista mejorada
        $members = Member::with('membership')->get();
        $payments = Payment::with('member')->get();
        $attendances = Attendance::with('member')->get();
        $memberships = Membership::all();

        // Según el rol, mostrar diferentes vistas
        if ($role == 'super_admin') {
            $totalUsers = User::count();
            $totalAdmins = User::where('role_id', 2)->count();
            $recentPayments = Payment::with('member')->latest()->take(5)->get();
            
            return view('dashboard.super_admin', compact(
                'totalMembers', 'totalPayments', 'todayAttendance',
                'totalUsers', 'totalAdmins', 'recentPayments',
                'members', 'payments', 'attendances', 'memberships'
            ));
        }
        
        elseif ($role == 'admin') {
            $recentMembers = Member::latest()->take(5)->get();
            $pendingRenewals = Member::where('end_date', '<=', now()->addDays(7))
                                      ->where('status', 'active')
                                      ->count();
            
            return view('dashboard.admin', compact(
                'totalMembers', 'totalPayments', 'todayAttendance',
                'recentMembers', 'pendingRenewals',
                'members', 'payments', 'attendances', 'memberships'
            ));
        }
        
        else { // user normal
            $member = Member::where('email', $user->email)->first();
            $myPayments = $member ? Payment::where('member_id', $member->id)->latest()->take(5)->get() : collect();
            $myAttendance = $member ? Attendance::where('member_id', $member->id)->latest()->take(10)->get() : collect();
            
            return view('dashboard.index', compact(
                'user', 'member', 'myPayments', 'myAttendance'
            ));
        }
    }
}