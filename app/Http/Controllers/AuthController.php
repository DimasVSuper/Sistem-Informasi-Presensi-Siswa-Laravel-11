<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(AuthRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard.index'));
        }

        return back()->withErrors([
            'email' => 'Email atau Password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('scan');
    }
}
