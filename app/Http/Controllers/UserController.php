<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('accounts.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'phone_number' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2,
        ]);

        return redirect()->route('login')->with('success', 'Register berhasil! Silakan login.');
    }

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('accounts.login');
    }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|string',
    //     ]);

    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();
    //         return redirect()->route('home');
    //     }

    //     return back()->withErrors([
    //         'email' => 'Email atau password salah.',
    //     ])->withInput();
    // }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Cek role_id dan redirect sesuai peran
        if (Auth::user()->role_id == 1) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('home');
        }
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->withInput();
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
