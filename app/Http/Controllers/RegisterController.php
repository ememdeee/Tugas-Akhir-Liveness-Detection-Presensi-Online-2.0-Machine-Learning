<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required | min:5 | max:100',
            'username' => 'required| min:5 | unique:users',
            'email' => ['required', 'email:dns', 'unique:users'],   //email:dsn
            'password' => 'required| min:6'
        ]);
        // dd("registrasi berhasil omedeto!");
        // return $request->all();
        $validatedData['password'] = bcrypt($validatedData['password']);

        $user = User::create($validatedData);
        $user->assignRole('pegawai');

        $request->session()->flash('success', 'Registration Successfull! Please Login!');

        return redirect ('/login');
    }
}
