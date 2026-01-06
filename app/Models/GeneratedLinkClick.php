<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneratedLinkClick extends Model
{
    protected $fillable = [
        'generated_link_id',
        'ip_address',
        'user_agent',
        'location',
    ];

    public function generatedLink()
    {
        return $this->belongsTo(GeneratedLink::class);
    }
}
