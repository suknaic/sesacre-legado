<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProcurementSituation extends Model
{
    protected $fillable = ['name'];

    public function procurements(): HasMany
    {
        return $this->hasMany(Procurement::class, 'procurement_situation_id');
    }
}
