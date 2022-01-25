<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){ //ini func login
        // echo $request->email , $request->password;
        $validate = $request->only('email', 'password');

        if (Auth::attempt($validate)) {
            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();
            $role = Roles::where('id',$user->role_id)->first();
            session(['role' => $role->name]);
            // dd($role->name);
            if ($role->name == 'User') {
                return redirect(route('user.media')); // edit kalau mau merubah halaman awal yang ingin dituju
            } elseif ($role->name == 'Renovator') {
                return redirect(route('pesanan.index-renovasi'));
            } else {
                return redirect(route('pesanan.index'));
            }
        }
        
        return redirect('/')->with('error', 'Email atau Password anda salah!');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect('/');
    }

    public function register(Request $request){
        $request->validate(
            [
                'password' => ['min:6','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/','confirmed'],
                'email' => ['unique:users,email']
            ],
            [
                'password.regex' => 'Must contain at least one uppercase/lowercase letters and one number'
            ]
        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token' => \Str::random(50),
            'role_id' => '2',
        ]);

        return redirect('/')->with('success', 'Berhasil membuat akun');    
    }
    public function register_arsitek(Request $request){
        $request->validate(
            [
                'password' => ['min:6','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/','confirmed'],
                'email' => ['unique:users,email']
            ],
            [
                'password.regex' => 'Must contain at least one uppercase/lowercase letters and one number'
            ]
        );

        // dd($request->password);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token' => \Str::random(50),
            'role_id' => '3',
        ]);

        return redirect()->back()->with('success', 'Berhasil membuat akun'); 
    }

    public function register_renovator(Request $request){
        $request->validate(
            [
                'password' => ['min:6','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
                'email' => ['unique:users,email']
            ],
            [
                'password.regex' => 'Must contain at least one uppercase/lowercase letters and one number'
            ]
        );

        // dd($request->password);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token' => \Str::random(50),
            'role_id' => '4',
        ]);

        return redirect()->back()->with('success', 'Berhasil membuat akun'); 
    }

    public function change_password_create(Request $request)
    {
        return view('change-password');
    }

    public function change_password(Request $request)
    {
        $request->validate(
            [
                'password' => ['min:6','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/','confirmed'],
                'email' => ['unique:users,email']
            ],
            [
                'password.regex' => 'Must contain at least one uppercase/lowercase letters and one number'
            ]
        );

        $user = User::find(Auth::user()->id);
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah');
    }

    public function change_passwords(Request $request, $id)
    {
        $request->validate(
            [
                'password' => ['min:6','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/','confirmed'],
            ],
            [
                'password.regex' => 'Must contain at least one uppercase/lowercase letters and one number'
            ]
        );

        $user = User::find($id);
        $user->update([
            'password' => Hash::make($request->password_baru)
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah');
    }
}
