<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $table='images';
    protected $fillable = [
        'name',
        'path',
    ];

    public function news()
    {
        return $this->belongsToMany(News::class);
    }
}
