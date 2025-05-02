<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\LevelModel;
use App\Models\UserModel;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) { // jika sudah login, maka redirect ke halaman home
            return redirect('/');
        }
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/dashboard') // Pastikan redirect ke URL yang benar
                ]);
            }
            return redirect('/dashboard');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => false,
                'message' => 'Username atau Password salah'
            ], 401);
        }

        return redirect('login')->with('error', 'Username atau Password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    public function showRegistrationForm()
    {
        $levels = LevelModel::all();
        return view('auth.register', compact('levels'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:20|unique:user',
            'nama' => 'required|string|max:100',
            'level_id' => 'required|exists:level,level_id,level_kode,!superadmin', // Blok superadmin
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'level_id' => $request->level_id,
            'password' => $request->password, // sudah di-cast otomatis ke hashed oleh model
        ]);

        Auth::login($user);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Pendaftaran berhasil!',
                'redirect' => url('/dashboard'), // Diubah ke dashboard
            ]);
        }

        return redirect('/dashboard'); // Diubah ke dashboard
    }

    public function checkUsername(Request $request)
    {
        $exists = UserModel::where('username', $request->username)->exists();
        return response()->json(['valid' => !$exists]);
    }
}
