<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanObjective extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'indicator', 'goal', 'registration_type', 'is_active', 'department_id'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function actions(): HasMany
    {
        return $this->hasMany(PlanAction::class);
    }
}
