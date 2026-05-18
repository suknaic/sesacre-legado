<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_secondary_category_id', 'requester_person_id', 'service_person_id',
        'opened_at', 'description', 'requester_phone', 'resolution',
        'resolved_at', 'rating', 'rating_at', 'rating_comment', 'amount',
        'ticket_status_id', 'scheduled_at', 'ticket_priority_id',
        'cancelled_at', 'cancel_reason', 'deadline',
    ];

    protected function casts(): array
    {
        return [
            'opened_at' => 'datetime',
            'resolved_at' => 'datetime',
            'rating_at' => 'datetime',
            'scheduled_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'deadline' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function secondaryCategory(): BelongsTo
    {
        return $this->belongsTo(TicketSecondaryCategory::class, 'ticket_secondary_category_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(TicketStatus::class, 'ticket_status_id');
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(TicketPriority::class, 'ticket_priority_id');
    }

    public function services(): HasMany
    {
        return $this->hasMany(TicketService::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(TicketNote::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(TicketAttachment::class);
    }

    public function servicePersons(): HasMany
    {
        return $this->hasMany(TicketServicePerson::class);
    }
}
