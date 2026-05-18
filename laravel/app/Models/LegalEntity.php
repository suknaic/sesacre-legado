<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalEntity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'cnpj', 'cnae', 'state_registration',
        'municipal_registration', 'founding_date', 'trade_name',
        'safira_number', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'founding_date' => 'date',
            'is_active' => 'boolean',
        ];
    }
}
