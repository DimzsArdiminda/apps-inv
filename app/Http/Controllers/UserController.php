<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
    
{
    public function index()
    {   
        $users = User::all();
        return view('users.users', ['users' => $users]);
    }

    public function update(Request $request, $id) {
        $user = User::find($id);

        $shouldRelogin = Auth::user()->email == $user->email && $user->email != $request->email;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->permission_level = $request->permission_level;
        $user->save();

        if($shouldRelogin){
            Auth::logout();
            return view('auth.login');
        }
        return redirect()->back()->with('success', 'Pengguna berhasil diupdate');
    }

    public function create(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:'.User::class],
            'password' => ['required'],
            'permission_level' => ['required', 'int']
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'permission_level' => $request->permission_level,
        ]);

        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function delete($id) {
        $user = User::find($id);
        if(!$user) {
            return redirect()->back()->with('failed', 'Pengguna tidak ditemukan');
        }
        $user->delete();
        return redirect()->back()->with('success', 'Pengguna berhasil dihapus');
    }
}
