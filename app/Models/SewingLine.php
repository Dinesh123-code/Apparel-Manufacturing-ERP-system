<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SewingLine extends Model
{
    protected $fillable = ['line_name'];

    public function productionBundles(): HasMany
    {
        return $this->hasMany(ProductionBundle::class, 'line_id');
    }
}
