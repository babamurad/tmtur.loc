<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneratedLink extends Model
{
    protected $fillable = [
        'target_url',
        'source',
        'full_url',
    ];
}
