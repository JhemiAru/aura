<?php
// app/Http/Controllers/MemberController.php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Payment;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MemberController extends Controller
{
    // ============ LISTAR MIEMBROS ============
    public function index()
    {
        $members = Member::all();
        return response()->json($members);
    }
    
    // ============ CREAR MIEMBRO (ACTUALIZA ESTADÍSTICAS) ============
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string',
            'plan' => 'required|string',
            'status' => 'required|string',
            'birth_date' => 'nullable|date'
        ]);
        
        $member = Member::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'plan' => $request->plan,
            'status' => $request->status,
            'birth_date' => $request->birth_date,
            'expiry_date' => Carbon::now()->addMonth(),
            'attendance_count' => 0,
            'registration_date' => Carbon::now(),
            'password' => Hash::make('default123')
        ]);
        
        // Retornar también las estadísticas actualizadas
        return response()->json([
            'success' => true,
            'data' => $member,
            'stats' => $this->getDashboardStats(),
            'message' => 'Miembro creado exitosamente'
        ], 201);
    }
    
    // ============ ACTUALIZAR MIEMBRO ============
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'phone' => 'nullable|string',
            'plan' => 'sometimes|string',
            'status' => 'sometimes|string',
            'expiry_date' => 'nullable|date'
        ]);
        
        $member->update($request->all());
        
        return response()->json([
            'success' => true,
            'data' => $member,
            'stats' => $this->getDashboardStats(),
            'message' => 'Miembro actualizado exitosamente'
        ]);
    }
    
    // ============ ELIMINAR MIEMBRO ============
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();
        
        return response()->json([
            'success' => true,
            'stats' => $this->getDashboardStats(),
            'message' => 'Miembro eliminado exitosamente'
        ]);
    }
    
    // ============ OBTENER ESTADÍSTICAS DEL DASHBOARD ============
    public function getDashboardStats()
    {
        // Total de miembros
        $totalMembers = Member::count();
        
        // Miembros activos
        $activeMembers = Member::where('status', 'activo')->count();
        
        // Ingresos mensuales (suma de pagos del mes actual)
        $monthlyIncome = Payment::whereMonth('payment_date', Carbon::now()->month)
            ->whereYear('payment_date', Carbon::now()->year)
            ->sum('amount');
        
        // Asistencias de hoy
        $todayAttendance = Attendance::whereDate('check_in', Carbon::today())->count();
        
        // Tasa de retención (miembros activos / total miembros)
        $retentionRate = $totalMembers > 0 ? round(($activeMembers / $totalMembers) * 100) : 0;
        
        return [
            'totalMembers' => $totalMembers,
            'activeMembers' => $activeMembers,
            'monthlyIncome' => $monthlyIncome,
            'todayAttendance' => $todayAttendance,
            'retentionRate' => $retentionRate
        ];
    }
    
    // ============ RENOVAR MEMBRESÍA ============
    public function renewMembership(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        $months = $request->get('months', 1);
        
        $member->expiry_date = Carbon::parse($member->expiry_date)->addMonths($months);
        $member->status = 'activo';
        $member->save();
        
        // Crear pago automático
        $price = $member->plan === 'VIP' ? 80 : ($member->plan === 'Premium' ? 50 : ($member->plan === 'Élite' ? 120 : 30));
        $totalPrice = $price * $months;
        
        Payment::create([
            'member_id' => $member->id,
            'amount' => $totalPrice,
            'concept' => 'Renovación de membresía ' . $member->plan,
            'payment_date' => Carbon::now(),
            'payment_method' => $request->get('payment_method', 'efectivo'),
            'status' => 'pagado',
            'receipt_number' => 'REN-' . strtoupper(uniqid())
        ]);
        
        return response()->json([
            'success' => true,
            'data' => $member,
            'stats' => $this->getDashboardStats(),
            'message' => "Membresía renovada por {$months} meses"
        ]);
    }
}