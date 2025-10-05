<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourGroupService extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'tour_group_id',
        'service_id',
        'price_cents',
    ];

    public function tourGroup(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TourGroup::class);
    }

    public function service(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
