<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    protected $fillable = [
        'name', 'url', 'icon', 'btn_class', 'is_active', 'sort_order'
    ];
}
