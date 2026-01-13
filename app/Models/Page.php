<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use App\Traits\HasSeo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    use Translatable;
    use HasSeo;

    protected $fillable = [
        'slug',
        'title',
        'content',
        'is_published',
    ];

    public $fields = ['title', 'content'];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}
