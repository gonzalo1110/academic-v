<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'ci'       => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['ci' => $request->ci, 'password' => $request->password], $request->boolean('remember'))) {
            $request->session()->regenerate();
            $rol = auth()->user()->rol;
            return redirect()->route("{$rol}.dashboard");
        }

        return back()->withErrors(['ci' => 'El CI o la contraseña son incorrectos.'])->onlyInput('ci');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function dashboard()
    {
        $rol = auth()->user()->rol;
        return view("dashboard.{$rol}");
    }
}
