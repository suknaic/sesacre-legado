<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetSourceRelease extends Model
{
    use HasFactory;

    protected $fillable = ['fonte_id', 'year', 'total_amount'];

    public function fonte(): BelongsTo
    {
        return $this->belongsTo(FinFonte::class, 'fonte_id', 'id_fonte');
    }
}
