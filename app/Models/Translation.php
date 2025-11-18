<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'translatable_type',
        'translatable_id',
        'locale',
        'field',
        'value',
    ];

    /* если хотите, можно сразо добавить casts */
    protected $casts = [
        'translatable_id' => 'integer',
    ];
}
