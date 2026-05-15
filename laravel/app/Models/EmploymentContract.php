<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmploymentContract extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'registration_number', 'personal_info_id', 'employment_bond_id',
        'job_position_id', 'legal_entity_id', 'admission_date',
        'termination_date', 'workload', 'notes', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'admission_date' => 'date',
            'termination_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function personalInfo(): BelongsTo
    {
        return $this->belongsTo(PersonalInfo::class);
    }

    public function employmentBond(): BelongsTo
    {
        return $this->belongsTo(EmploymentBond::class);
    }

    public function jobPosition(): BelongsTo
    {
        return $this->belongsTo(JobPosition::class);
    }

    public function legalEntity(): BelongsTo
    {
        return $this->belongsTo(LegalEntity::class);
    }

    public function locations(): HasMany
    {
        return $this->hasMany(ContractLocation::class);
    }

    public function recruitmentHistory(): HasMany
    {
        return $this->hasMany(RecruitmentHistory::class);
    }

    public function situations(): HasManyThrough
    {
        return $this->hasManyThrough(ContractSituation::class, RecruitmentHistory::class);
    }
}
