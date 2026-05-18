<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanningGuideline extends Model
{
    use HasFactory;

    protected $fillable = ['planning_axis_id', 'name', 'order', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function planningAxis(): BelongsTo
    {
        return $this->belongsTo(PlanningAxis::class);
    }
}
