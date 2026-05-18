<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerDiemReport extends Model
{
    use HasFactory;

    protected $fillable = ['per_diem_request_id', 'description'];

    public function perDiemRequest(): BelongsTo
    {
        return $this->belongsTo(PerDiemRequest::class);
    }
}
