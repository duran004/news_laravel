<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsImages extends Model
{
    use HasFactory;
    protected $table = 'news_images';
    protected $fillable = [
        'news_id',
        'image_id',
    ];

    public function news()
    {
        return $this->belongsTo(News::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
