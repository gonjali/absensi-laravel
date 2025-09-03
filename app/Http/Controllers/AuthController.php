<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Redirect ke Filament login
        return redirect('/admin/login');
    }

    public function login(Request $request)
    {
        // Handle login logic jika diperlukan
        // Untuk sekarang, redirect ke Filament login
        return redirect('/admin/login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
