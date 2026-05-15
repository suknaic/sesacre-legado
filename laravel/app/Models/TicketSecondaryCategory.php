<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TicketSecondaryCategory extends Model
{
    protected $fillable = ['ticket_primary_category_id', 'name', 'value', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'value' => 'decimal:2'];
    }

    public function primaryCategory(): BelongsTo
    {
        return $this->belongsTo(TicketPrimaryCategory::class, 'ticket_primary_category_id');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'ticket_secondary_category_id');
    }
}
