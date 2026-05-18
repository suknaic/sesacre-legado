<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DecreeValue extends Model
{
    use HasFactory;

    protected $fillable = ['decree_type_id', 'travel_class_id', 'value', 'is_active'];

    protected function casts(): array
    {
        return ['value' => 'decimal:2', 'is_active' => 'boolean'];
    }

    public function decreeType(): BelongsTo
    {
        return $this->belongsTo(DecreeType::class);
    }

    public function travelClass(): BelongsTo
    {
        return $this->belongsTo(TravelClass::class);
    }
}
