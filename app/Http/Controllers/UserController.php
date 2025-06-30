<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Tampilkan form ubah password.
     */
    public function editPassword()
    {
        return view('auth.change-password');
    }

    /**
     * Proses update password admin.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        // Ambil admin yang sedang login
        $admin = Auth::user();

        // Pastikan $admin adalah instance dari Eloquent model
        if (!$admin instanceof \App\Models\Admin) {
            $admin = \App\Models\Admin::find($admin->id);
        }

        // Cek password lama cocok
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah'])->withInput();
        }

        // Simpan password baru
        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()->route('dashboard')->with('success', 'Password berhasil diperbarui');
    }
}
