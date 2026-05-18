<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TicketPrimaryCategory extends Model
{
    use HasFactory;
    protected $fillable = ['ticket_category_type_id', 'name', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function categoryType(): BelongsTo
    {
        return $this->belongsTo(TicketCategoryType::class, 'ticket_category_type_id');
    }

    public function secondaryCategories(): HasMany
    {
        return $this->hasMany(TicketSecondaryCategory::class, 'ticket_primary_category_id');
    }
}
