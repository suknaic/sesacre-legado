<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'name', 'purchase_date', 'brand', 'model', 'patrimony_number',
        'price', 'warranty_months', 'serial_number', 'state',
        'unit_measure_id', 'ram_memory', 'processor', 'hd_size',
        'power_supply', 'has_wireless',
    ];

    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'price' => 'decimal:2',
            'has_wireless' => 'boolean',
        ];
    }
}
