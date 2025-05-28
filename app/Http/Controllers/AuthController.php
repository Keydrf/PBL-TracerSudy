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
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->only('username', 'password');
        
        // Validasi input
        $validator = Validator::make($credentials, [
            'username' => 'required',
            'password' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'msgField' => $validator->errors()
            ], 422);
        }
    
        // Cek apakah username ada
        $user = UserModel::where('username', $credentials['username'])->first();
    
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials',
                'msgField' => [
                    'username' => ['username could not be found']
                ]
            ], 401);
        }
    
        // Cek password
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials',
                'msgField' => [
                    'password' => ['Incorrect password']
                ]
            ], 401);
        }
    
        // Login berhasil
        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'redirect' => '/dashboard'
        ]);
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
