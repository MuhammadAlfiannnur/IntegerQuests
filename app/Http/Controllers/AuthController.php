<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
}

