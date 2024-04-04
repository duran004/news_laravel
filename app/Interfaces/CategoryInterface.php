<?php

namespace App\Interfaces;

use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;

interface CategoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Category;
    public function findOrall(int $id = 0): JsonResponse;
}
