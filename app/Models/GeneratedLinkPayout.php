<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneratedLinkPayout extends Model
{
    protected $fillable = [
        'generated_link_id',
        'amount',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function generatedLink()
    {
        return $this->belongsTo(GeneratedLink::class);
    }
}
