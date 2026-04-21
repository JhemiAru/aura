<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Attendance;
use App\Models\Membership;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard principal
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// ==================== API RUTAS PARA EL DASHBOARD ====================
Route::middleware(['auth'])->group(function () {
    // Stats
    Route::get('/dashboard/stats', function () {
        return response()->json([
            'totalMembers' => Member::count(),
            'todayAttendance' => Attendance::whereDate('check_in', today())->count(),
            'totalIncome' => Payment::sum('amount'),
        ]);
    })->name('dashboard.stats');
    
    // Members API
    Route::get('/api/members', function () {
        return Member::with('membership')->get();
    })->name('api.members');
    
    Route::get('/api/members/list', function () {
        return Member::select('id', 'name', 'lastname')->get();
    })->name('api.members.list');
    
    Route::get('/api/members/expiring', function () {
        return Member::with('membership')
            ->where('end_date', '<=', now()->addDays(30))
            ->where('status', 'active')
            ->orderBy('end_date')
            ->get();
    })->name('api.members.expiring');
    
    Route::post('/members', function (Request $request) {
        $member = Member::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'membership_id' => $request->membership_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);
        return response()->json($member, 201);
    });
    
    Route::put('/members/{id}', function (Request $request, $id) {
        $member = Member::findOrFail($id);
        $member->update([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'membership_id' => $request->membership_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);
        return response()->json($member);
    });
    
    Route::delete('/members/{id}', function ($id) {
        Member::destroy($id);
        return response()->json(['success' => true]);
    });
    
    Route::post('/members/{id}/renew', function (Request $request, $id) {
        $member = Member::findOrFail($id);
        $member->end_date = now()->addDays($request->days);
        $member->save();
        return response()->json(['success' => true]);
    });
    
    // Memberships API
    Route::get('/api/memberships', function () {
        return Membership::all();
    })->name('api.memberships');
    
    // Payments API
    Route::get('/api/payments', function () {
        return Payment::with('member')->get()->map(function ($p) {
            $p->member_name = $p->member ? $p->member->name . ' ' . $p->member->lastname : 'N/A';
            return $p;
        });
    })->name('api.payments');
    
    Route::post('/api/payments/store', function (Request $request) {
        $payment = Payment::create([
            'member_id' => $request->member_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_date' => $request->payment_date,
            'status' => 'completed',
        ]);
        return response()->json($payment, 201);
    })->name('api.payments.store');
    
    Route::delete('/payments/{id}', function ($id) {
        Payment::destroy($id);
        return response()->json(['success' => true]);
    });
    
    // Attendance API
    Route::get('/api/attendances', function () {
        return Attendance::with('member')->latest()->get()->map(function ($a) {
            $a->member_name = $a->member ? $a->member->name . ' ' . $a->member->lastname : 'N/A';
            return $a;
        });
    })->name('api.attendances');
    
    Route::post('/api/attendance/checkin', function (Request $request) {
        $attendance = Attendance::create([
            'member_id' => $request->member_id,
            'check_in' => now(),
        ]);
        return response()->json($attendance, 201);
    })->name('api.attendance.checkin');
    
    Route::put('/attendance/{id}/checkout', function ($id) {
        $attendance = Attendance::findOrFail($id);
        $attendance->check_out = now();
        $attendance->save();
        return response()->json(['success' => true]);
    });
    
    // Reports API
    Route::get('/api/reports/stats', function () {
        $monthlyIncome = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $total = Payment::whereYear('payment_date', $month->year)
                ->whereMonth('payment_date', $month->month)
                ->sum('amount');
            $monthlyIncome[] = $total;
        }
        return response()->json([
            'activeMembers' => Member::where('status', 'active')->count(),
            'inactiveMembers' => Member::where('status', 'inactive')->count(),
            'monthlyIncome' => $monthlyIncome,
        ]);
    })->name('api.reports.stats');
    
    // Notifications API
    Route::get('/api/notifications', function () {
        $notifications = [];
        $expiring = Member::where('end_date', '<=', now()->addDays(7))
            ->where('status', 'active')
            ->count();
        if ($expiring > 0) {
            $notifications[] = ['message' => $expiring . " socios tienen membresía por vencer"];
        }
        return response()->json($notifications);
    })->name('api.notifications');
});

// Rutas de autenticación de Breeze
require __DIR__.'/auth.php';

// Ruta de prueba
Route::get('/test-dashboard', function () {
    $user = \App\Models\User::find(1);
    if ($user) {
        Auth::login($user);
        return redirect('/dashboard');
    }
    return "No se encontró el usuario";
});
// Ruta GET para logout (solo para pruebas)
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout.get');

Route::get('/force-logout', function () {
    Auth::logout();
    return redirect('/login');
});

Route::get('/salir', function () {
    Auth::logout();
    return redirect('/login');
    
});