<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lokalis extends Model
{
    protected $guarded = [];


    public function markers(): HasMany
    {
        return $this->hasMany(ImageMarker::class, 'lokalis_id', 'id');
    }
}
