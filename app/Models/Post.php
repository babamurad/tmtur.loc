<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;   // add
use Illuminate\Support\Str;

class Post extends Model
{

    protected $fillable = [
        'title','slug','category_id','content','image','status','published_at'
    ];

    protected $casts = ['published_at' => 'datetime'];

    public static function booted()
    {
        static::creating(fn($post) => empty($post->slug) && $post->slug = Str::slug($post->title));
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /* helpers */
    public function getImageUrlAttribute(): string
    {
        return $this->image ? asset('uploads/'.$this->image) : asset('assets/images/media/sm-5.jpg');
    }
}
