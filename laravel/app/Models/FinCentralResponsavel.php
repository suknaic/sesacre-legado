<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinCentralResponsavel extends Model
{
    protected $table = 'fin_central_responsavel';

    protected $primaryKey = 'id_central_responsavel';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function lotacao()
    {
        return $this->belongsTo(SesLotacao::class, 'id_lotacao', 'id_lotacao');
    }

    public function tipoAdministracao()
    {
        return $this->belongsTo(FinTipoAdministracao::class, 'id_tipo_administracao', 'id_tipo_administracao');
    }
}
