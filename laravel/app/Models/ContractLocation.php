<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractLocation extends Model
{
    protected $fillable = [
        'employment_contract_id', 'organization_id', 'job_function_id',
        'workload', 'start_date', 'end_date',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function employmentContract(): BelongsTo
    {
        return $this->belongsTo(EmploymentContract::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function jobFunction(): BelongsTo
    {
        return $this->belongsTo(JobFunction::class);
    }
}
