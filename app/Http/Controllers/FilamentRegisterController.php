<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FilamentRegisterController extends Controller
{
    public function showForm()
    {
        return view('filament.signup'); // nanti kita buat view ini
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Login pakai guard filament
        auth()->guard('web')->login($user);

        return redirect('/admin'); // default Filament dashboard
    }
}
