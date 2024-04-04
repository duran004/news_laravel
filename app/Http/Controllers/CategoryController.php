<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Category;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\DeleteCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    protected $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function get_categories(int $id = 0)
    {
        return $this->categoryRepository->findOrall($id);
    }

    public function create_category(CreateCategoryRequest $request)
    {
        try {
            $category = Category::create([
                'name' => $request->name,
                'main_category_id' => $request->main_category_id,
                'image_id' => $request->image_id,
                'slug' => $request->slug,
                'title' => $request->title,
                'description' => $request->description
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Kategori oluşturulurken bir hata oluştu.',
                'error' => $e->getMessage()
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Kategori başarıyla oluşturuldu.',
            'data' => $category
        ]);
    }

    public function update_category(UpdateCategoryRequest $request, int $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Kategori bulunamadı.'
            ], 400);
        }
        $category->name = $request->name ?? $category->name;
        $category->description = $request->description ?? $category->description;
        $category->title = $request->title ?? $category->title;
        $category->main_category_id = $request->main_category_id ?? $category->main_category_id;
        if (isset($request->image_id)) {
            $image = Image::find($request->image_id);
            if (!$image) {
                return response()->json([
                    'status' => false,
                    'message' => 'Resim bulunamadı.'
                ], 400);
            }
            $category->image_id = $image->id;
        }
        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'Kategori başarıyla güncellendi.',
            'data' => $category
        ]);
    }

    public function update_image(Request $request, int $category_id)
    {
        $category = Category::find($category_id);
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Kategori bulunamadı.'
            ], 400);
        }
        $image = Image::find($request->image_id);
        if (!$image) {
            return response()->json([
                'status' => false,
                'message' => 'Resim bulunamadı.'
            ], 400);
        }

        $category->image_id = $request->image_id ?? $category->image_id;
        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'Kategori resmi başarıyla güncellendi.',
            'data' => $category
        ]);
    }

    public function update_main_category(Request $request, int $category_id)
    {
        $category = Category::find($category_id);
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Kategori bulunamadı.'
            ], 400);
        }
        $main_category = MainCategory::find($request->main_category_id);
        if (!$main_category) {
            return response()->json([
                'status' => false,
                'message' => 'Ana kategori bulunamadı.'
            ], 400);
        }
        $category->main_category_id = $request->main_category_id ?? $category->main_category_id;
        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'Ana kategori başarıyla güncellendi.',
            'data' => $category
        ]);
    }

    public function delete_category(DeleteCategoryRequest $request, int $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Kategori bulunamadı.'
            ], 400);
        }
        $category->delete();

        return response()->json([
            'status' => true,
            'message' => 'Kategori başarıyla silindi.'
        ]);
    }
}
