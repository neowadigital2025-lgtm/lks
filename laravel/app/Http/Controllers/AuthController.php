<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi format inputan wajib (harus diisi dan memenuhi panjang karakter)
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:3',
            'password' => 'required|string|min:6',
        ]);

        // Cek jika format inputan tidak valid langsung gagalkan di awal
        if ($validator->fails()) {
            return response()->json([
                'status' => 'auth_fail',
                'message' => 'Username or password you entered is incorrect.'
            ], 401);
        }

        // 2. Cari user berdasarkan username di database
        $user = User::where('username', $request->username)->first();

        // 3. Validasi kecocokan username DAN password (menggunakan Hash::check)
        // Jika user tidak ditemukan ATAU password-nya salah, kembalikan respons 401
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'auth_fail',
                'message' => 'Username or password you entered is incorrect.'
            ], 401);
        }

        // 4. Buat token akses digital menggunakan Sanctum setelah dipastikan kredensial benar
        $token = $user->createToken('auth_token')->plainTextToken;

        // 5. Kembalikan jawaban sukses resmi
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful.',
            'data' => [
                'username' => $user->username,
                'created_at' => $user->created_at->toISOString(),
                'updated_at' => $user->updated_at->toISOString(),
                'id' => $user->id,
                'token' => $token,
                'role' => $user->role
            ]
        ], 200);
    }

    public function logout(Request $request)
    {
        // Menghapus token token yang sedang digunakan saat ini
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout successful.'
        ], 200);
    }

    public function register(Request $request) 
    {
        // 1. Validasi input dari user
        $request->validate([
            'username' => 'required|min:3|unique:users,username',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,user'
        ]);

        // 2. Simpan ke database dengan password yang di-hash Bcrypt
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        // 3. Kembalikan respon sukses
        return response()->json([
            'status' => 'success',
            'message' => 'User baru berhasil dibuat.',
            'data' => $user
        ], 201);
    }
}
