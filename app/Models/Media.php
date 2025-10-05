<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'model_type',
        'model_id',
        'file_path',
        'file_name',
        'mime_type',
         'order_column',
    ];
    public function model()
    {
        return $this->morphTo();
    }

    public function getUrlAttribute(): string
    {
        return asset('uploads/' . $this->file_path);
    }
}
