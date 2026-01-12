<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\WaliSantri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WaliAuthController extends Controller
{
    public function showLogin()
    {
        return view('wali.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nis' => 'required|string',
            'password' => 'required|string',
        ]);

        $wali = WaliSantri::where('nis', $request->nis)->first();

        if ($wali && Hash::check($request->password, $wali->password)) {
            Auth::guard('wali')->login($wali, $request->filled('remember'));
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'nis' => 'NIS atau password salah.',
        ])->onlyInput('nis');
    }

    public function logout(Request $request)
    {
        Auth::guard('wali')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
