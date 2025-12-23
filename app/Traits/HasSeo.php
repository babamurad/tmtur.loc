<?php

namespace App\Traits;

use App\Models\SeoMeta;

trait HasSeo
{
    public function seo()
    {
        return $this->morphOne(SeoMeta::class, 'seoleable');
    }
}
