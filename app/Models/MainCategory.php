<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'main_categories';
    protected $fillable = [
        'name',
        'image_id',
        'slug'
    ];
}
