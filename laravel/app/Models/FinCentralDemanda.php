<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinCentralDemanda extends Model
{
    protected $table = 'fin_central_demanda';

    protected $primaryKey = 'id_central_demanda';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function lotacao()
    {
        return $this->belongsTo(SesLotacao::class, 'id_lotacao', 'id_lotacao');
    }
}
