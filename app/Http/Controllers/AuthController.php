<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Token;

class AuthController extends Controller
{
    /**
     * Handle guru login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $guru = Guru::where('username', $request->username)->firstOrFail();

        // Debugging: Cek apakah guru ditemukan
        if (!$guru) {
            return back()->withErrors(['login' => 'Username tidak ditemukan']);
        }

        // Debugging: Cek password
        if (!Hash::check($request->password, $guru->password)) {
            return back()->withErrors(['login' => 'Password salah']);
        }

        // Pastikan objek guru valid sebelum mengakses id
        session([
            'guru_logged_in' => true,
            'guru_id' => $guru->id // Pastikan kolom 'id' ada di tabel gurus
        ]);

        return redirect()->route('guru.index');
    }

    public function checkSession()
    {
        $session = DB::table('sessions')
                    // ->where('user_id', auth()->id())  // HAPUS INI
                    ->first();
                    
        // Ganti dengan:
        $session = DB::table('sessions')
                    ->where('id', session()->getId())
                    ->first();
        
        dd($session);
    }

    /**
     * Handle guru logout request
     */
    public function logout(Request $request)
    {
        // Lebih baik gunakan forget() untuk spesifik session key
        $request->session()->forget([
            'guru_logged_in',
            'guru_id'
        ]);
        
        // Daripada flush() yang menghapus semua session
        // $request->session()->flush();

        return redirect()->route('beranda')
            ->with('status', 'Anda telah logout.');
    }

    // NEW: Added method to show login form if needed
    public function showLoginForm()
    {
        return view('auth.login'); // You'll need to create this view
    }

    public function cekToken(Request $request)
    {
       $token = $request->input('token');
        $nama = $request->input('nama');
        $level = $request->input('level'); // dari Construct 2

        // Cek apakah token valid
        $tokenData = \App\Models\Token::where('token', $token)->first();

        if ($tokenData) {
            // Cek apakah siswa sudah ada
            $siswa = \App\Models\Siswa::where('nama', $nama)->where('token', $token)->first();

            if (!$siswa) {
                $siswa = \App\Models\Siswa::create([
                    'nama' => $nama,
                    'token' => $token,
                    'level' => $level ?? 1,
                    'kelas_id' => $tokenData->kelas_id
               ]);
            }

            // Sekarang dijamin $siswa tidak null
            return response("{$siswa->level}|Token valid|", 200)
                ->header('Content-Type', 'text/plain');
        }

        return response("0|Token tidak ditemukan|", 200)
            ->header('Content-Type', 'text/plain');
        
    }
    public function updateLevel(Request $request)
    {
        $nama = $request->input('nama');
        $token = $request->input('token');
        $level = $request->input('level');

        $siswa = \App\Models\Siswa::where('nama', $nama)
                    ->where('token', $token)
                    ->first();

        if ($siswa) {
            $siswa->level = $level;
            $siswa->save();

            return response("1|Level diperbarui|");
        }

        return response("0|Siswa tidak ditemukan|");
    }

}

