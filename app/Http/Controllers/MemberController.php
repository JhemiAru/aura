<?php
// app/Http/Controllers/MemberController.php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::query();
        
        if ($request->has('search')) {
            $query->where('name', 'LIKE', "%{$request->search}%")
                  ->orWhere('email', 'LIKE', "%{$request->search}%");
        }
        if ($request->has('plan') && $request->plan) {
            $query->where('plan', $request->plan);
        }
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        if ($request->has('expiring') && $request->expiring) {
            $query->where('expiry_date', '<=', Carbon::now()->addDays(7))
                  ->where('expiry_date', '>=', Carbon::now());
        }
        
        $members = $query->get();
        return response()->json($members);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:members',
            'phone' => 'nullable|string',
            'plan' => 'required|string',
            'status' => 'required|string',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string'
        ]);

        $member = Member::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'plan' => $request->plan,
            'status' => $request->status,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'expiry_date' => Carbon::now()->addMonth(),
            'attendance_count' => 0,
            'registration_date' => Carbon::now()
        ]);

        return response()->json(['success' => true, 'data' => $member, 'message' => 'Miembro creado']);
    }

    public function show($id)
    {
        $member = Member::findOrFail($id);
        return response()->json($member);
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:members,email,' . $id,
            'phone' => 'nullable|string',
            'plan' => 'required|string',
            'status' => 'required|string',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string'
        ]);

        $member->update($request->all());

        return response()->json(['success' => true, 'data' => $member, 'message' => 'Miembro actualizado']);
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();
        return response()->json(['success' => true, 'message' => 'Miembro eliminado']);
    }

    public function renew(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        $months = $request->input('months', 1);
        $member->expiry_date = Carbon::parse($member->expiry_date)->addMonths($months);
        $member->save();
        
        return response()->json(['success' => true, 'message' => 'Membresía renovada', 'expiry_date' => $member->expiry_date]);
    }
}