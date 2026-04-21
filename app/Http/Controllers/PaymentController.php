<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'concept' => 'required|string',
            'payment_method' => 'required|in:cash,card,transfer',
            'payment_date' => 'required|date'
        ]);
        
        $payment = Payment::create([
            'member_id' => $request->member_id,
            'amount' => $request->amount,
            'concept' => $request->concept,
            'payment_date' => $request->payment_date,
            'payment_method' => $request->payment_method,
            'status' => 'completed',
            'receipt_number' => 'REC-' . Carbon::now()->format('Ymd') . '-' . strtoupper(uniqid())
            // 'notes' => $request->notes,  // COMENTADO porque no existe la columna
        ]);
        
        return response()->json([
            'success' => true,
            'data' => $payment,
            'message' => 'Pago registrado exitosamente'
        ], 201);
    }
}