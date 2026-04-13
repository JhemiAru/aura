<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PruebaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            $user = \App\Models\User::find(1);
            Auth::login($user);
        }
        
        return view('prueba', [
            'user' => $user,
            'role' => $user->role->name ?? 'sin rol'
        ]);
    }
}