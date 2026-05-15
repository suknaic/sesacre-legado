<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use HasFactory;
    protected $fillable = ['state_id', 'name', 'health_region_id', 'geo_region_id', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function healthRegion(): BelongsTo
    {
        return $this->belongsTo(HealthRegion::class);
    }

    public function geoRegion(): BelongsTo
    {
        return $this->belongsTo(GeoRegion::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
