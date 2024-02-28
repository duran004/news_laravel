<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Image;
use App\Models\Category;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function get_news(int $id = 0)
    {
        if ($id != 0) {
            $news = News::find($id);
        } else {
            $news = News::all();
        }
        if (!$news) {
            return response()->json([
                'status' => false,
                'message' => 'Haber bulunamadı.'
            ], 400);
        }
        return response()->json([
            'status' => true,
            'message' => 'Haberler başarıyla getirildi.',
            'data' => $news
        ]);
    }

    public function create_news(Request $request)
    {
        $user = auth()->user();
        try {
            $image = Image::find($request->image_id);
            if (!$image) {
                throw new \Exception('Resim bulunamadı.');
            }
            $category = Category::find($request->category_id);
            if (!$category) {
                throw new \Exception('Kategori bulunamadı.');
            }
            $news = News::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'description' => $request->description,
                'content' => $request->content,
                'image_id' => $image->id,
                'category_id' => $request->category_id,
                'user_id' => $user->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Haber oluşturulurken bir hata oluştu.',
                'error' => $e->getMessage(),
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Haber başarıyla oluşturuldu.',
            'data' => $news
        ]);
    }

    public function update_news(Request $request, int $id)
    {
        try {
            $news = News::find($id);
            if (!$news) {
                throw new \Exception('Haber bulunamadı.');
            }
            $news->title = $request->title ?? $news->title;
            $news->slug = $request->slug ?? $news->slug;
            $news->description = $request->description ?? $news->description;
            $news->content = $request->content ?? $news->content;
            if (isset($request->image_id)) {
                $image = Image::find($request->image_id);
                if (!$image) {
                    throw new \Exception('Resim bulunamadı.');
                }
                $news->image_id = $image->id;
            }
            if (isset($request->category_id)) {
                $category = Category::find($request->category_id);
                if (!$category) {
                    throw new \Exception('Kategori bulunamadı.');
                }
                $news->category_id = $request->category_id;
            }
            $news->save();

            return response()->json([
                'status' => true,
                'message' => 'Haber başarıyla güncellendi.',
                'data' => $news
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Haber güncellenirken bir hata oluştu.',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function update_image(Request $request, int $id)
    {
        try {
            $news = News::find($id);
            if (!$news) {
                throw new \Exception('Haber bulunamadı.');
            }
            $image = Image::find($request->image_id);
            if (!$image) {
                throw new \Exception('Resim bulunamadı.');
            }
            $news->image_id = $image->id;
            $news->save();

            return response()->json([
                'status' => true,
                'message' => 'Haber resmi başarıyla güncellendi.',
                'data' => $news
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Haber resmi güncellenirken bir hata oluştu.',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function delete_news(int $id)
    {
        $news = News::find($id);
        if (!$news) {
            return response()->json([
                'status' => false,
                'message' => 'Haber bulunamadı.'
            ], 400);
        }
        $news->delete();

        return response()->json([
            'status' => true,
            'message' => 'Haber başarıyla silindi.'
        ]);
    }
}
