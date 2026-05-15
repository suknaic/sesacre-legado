<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinCentrais extends Model
{
    protected $table = 'fin_centrais';

    public $timestamps = false;

    protected $guarded = [];

    public function lotacao()
    {
        return $this->belongsTo(SesLotacao::class, 'id_lotacao', 'id_lotacao');
    }
}
