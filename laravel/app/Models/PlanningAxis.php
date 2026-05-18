<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanningAxis extends Model
{
    use HasFactory;

    protected $fillable = ['pes_plan_id', 'name', 'order', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function pesPlan(): BelongsTo
    {
        return $this->belongsTo(PesPlan::class);
    }
}
