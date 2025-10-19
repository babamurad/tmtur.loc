<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'is_published',
    ];

    protected static function booted(): void
    {
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->title);                
            }
        });
    }

    /* helpers */
    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('uploads/' . $this->image)
            : asset('assets/images/media/sm-5.jpg');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
