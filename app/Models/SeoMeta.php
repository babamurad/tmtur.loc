<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoMeta extends Model
{
    protected $fillable = [
        'title',
        'description',
        'og_image',
    ];

    public function seoleable()
    {
        return $this->morphTo();
    }
}
