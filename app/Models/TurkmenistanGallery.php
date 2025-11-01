<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurkmenistanGallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
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

    // Аксессор для получения полного URL
    public function getFullUrlAttribute()
    {
        // Предполагается, что файлы хранятся в public_uploads, и asset() настроен соответствующе
        return asset('uploads/' . $this->file_path);
    }
}
