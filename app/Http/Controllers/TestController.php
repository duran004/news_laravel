<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class TestController extends Controller
{
    public function test_methodu()
    {
       $user = User::find(3);
       $news=$user->news()->first();
       $images=$news->images()->first();
       dd($images->image->name);
    }

    public function create_user(): User
    {
        return User::firstOrCreate([
            'name' => 'Duran Can Yılmaz',
        ], [
            'email' => 'yazilimciadam@youtube.com',
            'password' => Hash::make('123')
        ]);
    }
}
