<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonalInfo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'gender', 'rg', 'issuing_agency', 'issuing_state_id',
        'marital_status_id', 'education_formation_id', 'skills',
        'father_name', 'mother_name', 'birth_date', 'cns_number',
        'photo_url', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function issuingState(): BelongsTo
    {
        return $this->belongsTo(State::class, 'issuing_state_id');
    }

    public function maritalStatus(): BelongsTo
    {
        return $this->belongsTo(MaritalStatus::class);
    }

    public function educationFormation(): BelongsTo
    {
        return $this->belongsTo(EducationFormation::class);
    }
}
