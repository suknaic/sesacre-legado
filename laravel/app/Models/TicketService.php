<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TicketService extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_id', 'ticket_secondary_category_id', 'hours_worked',
        'service_description', 'service_value', 'quantity', 'total_value',
        'expense', 'expense_description',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(TicketServiceMaterial::class);
    }
}
