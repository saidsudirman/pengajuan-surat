<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'role' => 'admin',
        ], $request->boolean('remember'))) {

            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password admin tidak sesuai.',
            ])
            ->withInput($request->only('email'));
    }

    public function showMahasiswaLogin()
    {
        return view('auth.mahasiswa-login');
    }

    public function mahasiswaLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'role' => 'mahasiswa',
        ], $request->boolean('remember'))) {

            $request->session()->regenerate();

            return redirect()->route('mahasiswa.dashboard');
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password mahasiswa tidak sesuai.',
            ])
            ->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.mahasiswa');
    }
}