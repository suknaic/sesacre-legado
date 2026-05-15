<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinRedeTematica extends Model
{
    protected $table = 'fin_rede_tematica';

    protected $primaryKey = 'id_rede_tematica';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function blocoOrcamentario()
    {
        return $this->belongsTo(FinBlocoOrcamentario::class, 'id_bloc_orcamentario', 'id_bloc_orcamentario');
    }

    public function portarias()
    {
        return $this->hasMany(FinPortaria::class, 'id_rede_tematica', 'id_rede_tematica');
    }
}
