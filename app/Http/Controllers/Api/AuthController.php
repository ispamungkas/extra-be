<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'role' => 'required|in:siswa,pembina',
            'email' => 'required|email|unique:users',
            'nisn' => 'required',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'nisn' => $request->nisn,
            'kelas' => $request->kelas,
            'no_telp' => $request->no_telp,
        ]);

        return response()->json($user, 201);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Login gagal'], 401);
        }

        return response()->json($user);
    }

    public function alluser(Request $request)
    {
        $alluser = User::with(['eskuls', 'absensi','nilai'])->get();
        return response()->json($alluser);
    }

    public function updateProfile(Request $request, $id)
    {
        try {
            $request->validate([
                'email' => 'nullable|email|unique:users,email,' . $id,
                'kelas' => 'nullable|string',
                'no_telp' => 'nullable|string',
            ]);

            $user = User::findOrFail($id);

            $hasChanges = false;

            if ($request->has('email')) {
                $user->email = $request->email;
                $hasChanges = true;
            }

            if ($request->has('kelas')) {
                $user->kelas = $request->kelas;
                $hasChanges = true;
            }

            if ($request->has('no_telp')) {
                $user->no_telp = $request->no_telp;
                $hasChanges = true;
            }

            if (!$hasChanges) {
                return response()->json([
                    'message' => 'Tidak ada data yang diubah'
                ], 400);
            }

            $user->save();

            return response()->json([
                'message' => 'Profil berhasil diperbarui',
                'data' => $user
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal memperbarui profil',
                'error' => $e->getMessage()
            ], 500);
        }
    }




}
