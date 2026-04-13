<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('member');
        
        if ($request->has('member_id')) {
            $query->where('member_id', $request->member_id);
        }
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        if ($request->has('month')) {
            $query->whereYear('payment_date', substr($request->month, 0, 4))
                  ->whereMonth('payment_date', substr($request->month, 5, 2));
        }
        
        $payments = $query->orderBy('payment_date', 'desc')->get();
        return response()->json($payments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:0',
            'concept' => 'required|string',
            'payment_method' => 'required|string',
            'payment_date' => 'required|date',
            'receipt_number' => 'nullable|string'
        ]);

        $payment = Payment::create([
            'member_id' => $request->member_id,
            'amount' => $request->amount,
            'concept' => $request->concept,
            'payment_method' => $request->payment_method,
            'payment_date' => $request->payment_date,
            'receipt_number' => $request->receipt_number ?? 'REC-' . Carbon::now()->format('Ymd') . '-' . rand(1000, 9999),
            'status' => 'pagado'
        ]);

        // Actualizar fecha de vencimiento del miembro
        $member = Member::find($request->member_id);
        $member->expiry_date = Carbon::parse($member->expiry_date)->addMonth();
        $member->save();

        return response()->json(['success' => true, 'data' => $payment, 'message' => 'Pago registrado']);
    }

    public function show($id)
    {
        $payment = Payment::with('member')->findOrFail($id);
        return response()->json($payment);
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'status' => 'required|string'
        ]);

        $payment->update($request->only(['amount', 'status']));
        return response()->json(['success' => true, 'data' => $payment, 'message' => 'Pago actualizado']);
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        return response()->json(['success' => true, 'message' => 'Pago eliminado']);
    }
}