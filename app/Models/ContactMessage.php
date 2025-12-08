<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = ['name','email','phone','message','tour_id','tour_group_id','people_count','services','ip','user_agent','is_read'];

    protected $casts = [
        'services' => 'array',
    ];
}
