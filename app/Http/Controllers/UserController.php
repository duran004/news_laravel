<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create_user(CreateUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Kullanıcı başarıyla oluşturuldu.',
            'data' => $user
        ]);
    }

    public function get_user(){
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Kullanıcı bulunamadı.'
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Kullanıcı bilgileri başarıyla getirildi.',
            'data' => $user
        ]);
    }

    public function login(UserLoginRequest $request)
    {
        $user = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Kullanıcı bulunamadı.'
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Kullanıcı başarıyla giriş yaptı.',
            'data' => Auth::user()
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => true,
            'message' => 'Kullanıcı başarıyla çıkış yaptı.'
        ]);
    }

    public function get_user_from_id(int $user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Kullanıcı bulunamadı.'
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Kullanıcı bilgileri başarıyla getirildi.',
            'data' => $user
        ]);
    }
}
