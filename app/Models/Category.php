<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use SoftDeletes;
    use \App\Models\Traits\Translatable;

    public $fields = ['title', 'content'];

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

        static::deleting(function ($category) {
            $category->translations()->delete();
            $category->posts()->each(function ($post) {
                $post->delete();
            });
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
