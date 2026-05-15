<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecruitmentHistory extends Model
{
    protected $table = 'recruitment_history';

    protected $fillable = [
        'employment_contract_id', 'organization_id', 'job_function_id',
        'contract_situation_id', 'history_date', 'start_date', 'end_date',
        'observation',
    ];

    protected function casts(): array
    {
        return [
            'history_date' => 'datetime',
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

    public function contractSituation(): BelongsTo
    {
        return $this->belongsTo(ContractSituation::class);
    }
}
