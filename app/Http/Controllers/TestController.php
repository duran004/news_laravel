<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller
{
    public function test_methodu()
    {
        $category_modeli = Category::create([
            'name' => 'Test Kategori',
            'slug' => 'test-kategori5',
            'image' => 'test-kategori.jpg'
        ]);
        News::create([
            'title' => 'Test Haber Başlığı',
            'slug' => 'test-haber-basligi',
            'image' => 'test-haber.jpg',
            'content' => 'Test Haber İçeriği',
            'user_id' => 1,
            'category_id' => $category_modeli->id
        ]);
    }
}
