<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContractSituation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'type', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function scopeFerias($query): void
    {
        $query->where('type', 'F');
    }

    public function scopeLicencas($query): void
    {
        $query->where('type', 'L');
    }

    public function scopeConcessoes($query): void
    {
        $query->where('type', 'C');
    }

    public function scopeAfastamentos($query): void
    {
        $query->where('type', 'A');
    }

    public function scopeInativos($query): void
    {
        $query->where('type', 'I');
    }

    public function recruitmentHistory(): HasMany
    {
        return $this->hasMany(RecruitmentHistory::class);
    }
}
