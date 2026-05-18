<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_date', 'material_description', 'quantity_ordered',
        'quantity_received', 'organization_id', 'status', 'receipt_date', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'order_date' => 'date',
            'receipt_date' => 'date',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
