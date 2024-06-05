<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use App\Helpers\DataTablesHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\CreateUserRequest;
use App\Models\Category;


class UserController extends Controller
{
    private $model, $datatable_helper, $datatable, $datatable_js;
    public function __construct()
    {
        $this->model = new User();
        $this->datatable_helper = new DataTablesHelper($this->model, route('api.user.get.all'), 'GET');
    }
    public function view_all_users(Request $request)
    {
        $datatable = $this->datatable_helper->create_table($request);
        $datatable_js = $this->datatable_helper->create_js();

        return view('admin.users.index', compact('datatable', 'datatable_js'));
    }

    //API
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
    public function delete_user(int $user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Kullanıcı bulunamadı.'
            ]);
        }
        $user->delete();
        return response()->json([
            'status' => true,
            'message' => 'Kullanıcı başarıyla silindi.'
        ]);
    }


    public function get_all_users(Request $request)
    {
        $query = User::query();
        // @Todo: user bağımlılığını kaldır
        $data = $this->datatable_helper->api($request);
        return response()->json($data);
    }


    public function get_user()
    {
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
