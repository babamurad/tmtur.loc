<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use \App\Models\Traits\Translatable;

    public $fields = ['title', 'content'];

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'content',
        'image',
        'status',
        'published_at',
        'views',
        'user_id'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => 'boolean'
    ];

    protected $appends = ['image_url'];

    public static function booted()
    {
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });

        static::deleting(function ($post) {
            $post->translations()->delete();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return asset('assets/images/media/sm-5.jpg');
        }

        // Проверяем, является ли это полным URL
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        // Проверяем, начинается ли путь с 'posts/'
        if (strpos($this->image, 'posts/') === 0) {
            return asset('uploads/' . $this->image);
        }

        return asset('uploads/posts/' . $this->image);
    }
}
