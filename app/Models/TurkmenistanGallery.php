<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurkmenistanGallery extends Model
{
    use HasFactory;
    use \App\Models\Traits\Translatable;

    public $fields = ['title', 'description', 'location', 'photographer', 'alt_text'];

    protected $fillable = [
        'title',
        'slug',
        'description',
        'file_path',
        'file_name',
        'mime_type',
        'size',
        'alt_text',
        'is_featured',
        'order',
        'location',
        'photographer',
    ];

    protected static function booted()
    {
        static::deleting(function ($gallery) {
            $gallery->translations()->delete();
        });
    }

    // Аксессор для получения полного URL
    public function getFullUrlAttribute()
    {
        // Предполагается, что файлы хранятся в public_uploads, и asset() настроен соответствующе
        return asset('uploads/' . $this->file_path);
    }
}
