<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StrategicPlan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_year', 'end_year', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function annualPlans(): HasMany
    {
        return $this->hasMany(AnnualPlan::class);
    }
}
