<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMessage extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'email', 'phone', 'message', 'tour_id', 'tour_group_id', 'people_count', 'services', 'ip', 'user_agent', 'is_read'];

    protected $casts = [
        'services' => 'array',
    ];
}
