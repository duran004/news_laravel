<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\MainCategory;

class MainCategoryController extends Controller
{
    public function get_main_categories(int $id = 0)
    {
        if ($id != 0) {
            $main_category = MainCategory::find($id);
        } else {
            $main_category = MainCategory::all();
        }
        if (!$main_category) {
            return response()->json([
                'status' => false,
                'message' => 'Ana kategori bulunamadı.'
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Ana kategoriler başarıyla getirildi.',
            'data' => $main_category
        ]);
    }

    public function create_main_category(Request $request)
    {
        try {
            $main_category = MainCategory::create([
                'name' => $request->name,
                'slug' => $request->slug,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Ana kategori oluşturulurken bir hata oluştu.',
                'error' => $e->getMessage()
            ], 400);
        }
        return response()->json([
            'status' => true,
            'message' => 'Ana kategori başarıyla oluşturuldu.',
            'data' => $main_category
        ]);
    }

    public function update_main_category(Request $request, int $id)
    {
        $main_category = MainCategory::find($id);
        if (!$main_category) {
            return response()->json([
                'status' => false,
                'message' => 'Ana kategori bulunamadı.'
            ], 400);
        }
        $main_category->name = $request->name ?? $main_category->name;
        $main_category->slug = $request->slug ?? $main_category->slug;
        if (isset($request->image_id)) {
            $image = Image::find($request->image_id);
            if (!$image) {
                return response()->json([
                    'status' => false,
                    'message' => 'Resim bulunamadı.'
                ], 400);
            }
            $main_category->image_id = $image->id;
        }

        $main_category->save();

        return response()->json([
            'status' => true,
            'message' => 'Ana kategori başarıyla güncellendi.',
            'data' => $main_category
        ]);
    }

    public function update_image(Request $request, int $id)
    {
        $main_category = MainCategory::find($id);
        if (!$main_category) {
            return response()->json([
                'status' => false,
                'message' => 'Ana kategori bulunamadı.'
            ], 400);
        }
        $image = Image::find($request->image_id);
        if (!$image) {
            return response()->json([
                'status' => false,
                'message' => 'Resim bulunamadı.'
            ], 400);
        }
        $main_category->image_id = $request->image_id;
        $main_category->save();

        return response()->json([
            'status' => true,
            'message' => 'Ana kategori resmi başarıyla güncellendi.',
            'data' => $main_category
        ]);
    }

    public function delete_main_category(int $id)
    {
        $main_category = MainCategory::find($id);
        if (!$main_category) {
            return response()->json([
                'status' => false,
                'message' => 'Ana kategori bulunamadı.'
            ], 400);
        }
        $main_category->delete();

        return response()->json([
            'status' => true,
            'message' => 'Ana kategori başarıyla silindi.'
        ]);
    }
}
