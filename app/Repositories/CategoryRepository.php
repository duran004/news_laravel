<?php

namespace App\Repositories;

use App\Models\Category;
use App\Interfaces\CategoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;

class CategoryRepository implements CategoryInterface
{
    protected $category;
    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    public function all(): Collection
    {
        return $this->category::all();
    }

    public function find(int $id): ?Category
    {
        return $this->category::find($id);
    }

    public function findOrall(int $id = 0): JsonResponse
    {
        if ($id != 0) {
            $category = $this->find($id);
        } else {
            $category = $this->all();
        }
        if ($category) {
            return response()->json([
                'status' => true,
                'message' => 'Kategori bulundu.',
                'data' => $category
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Kategori bulunamadı.'
        ], 400);
    }
}
