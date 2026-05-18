<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasValidation extends Model
{
    use HasFactory;

    protected $fillable = ['annual_plan_id', 'person_id', 'validation_status', 'description'];

    public function annualPlan(): BelongsTo
    {
        return $this->belongsTo(AnnualPlan::class);
    }
}
