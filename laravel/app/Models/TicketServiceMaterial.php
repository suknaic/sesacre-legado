<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketServiceMaterial extends Model
{
    protected $fillable = ['ticket_service_id', 'material_id', 'quantity', 'value'];

    public function ticketService(): BelongsTo
    {
        return $this->belongsTo(TicketService::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
