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
        // $user = $this->create_user();
        // $category_modeli = Category::create([
        //     'name' => 'Test Kategori',
        //     'slug' => 'test-kategori' . rand(1, 99900),
        //     'image' => 'test-kategori.jpg'
        // ]);
        // News::create([
        //     'title' => 'Test Haber Başlığı',
        //     'slug' => 'test-haber-basligi' . rand(1, 99900),
        //     'image' => 'test-haber.jpg',
        //     'content' => 'Test Haber İçeriği',
        //     'user_id' => $user->id,
        //     'category_id' => $category_modeli->id
        // ]);

        $haber = News::with('category', 'user')
            ->withTrashed()
            ->get();
        dd($haber);
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
