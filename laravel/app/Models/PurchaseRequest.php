<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseRequest extends Model
{
    protected $fillable = [
        'number',
        'request_type_id',
        'supplier_id',
        'ordinance_id',
        'agreement_id',
        'budget_source_id',
        'work_program_id',
        'expense_element_id',
        'expense_type_id',
        'spending_type_id',
        'department_id',
        'description',
        'amount',
        'request_date',
        'situation',
        'purchase_request_situation_id',
    ];

    protected function casts(): array
    {
        return [
            'request_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function situation(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequestSituation::class, 'purchase_request_situation_id');
    }

    public function commitments(): HasMany
    {
        return $this->hasMany(Commitment::class, 'purchase_request_id');
    }
}
