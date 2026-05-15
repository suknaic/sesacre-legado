<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinCentralLiberacaoTrans extends Model
{
    protected $table = 'fin_central_liberacao_trans';

    protected $primaryKey = 'id_central_liberacao_trans';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function centralLiberacao()
    {
        return $this->belongsTo(FinCentralLiberacao::class, 'id_central_liberacao', 'id_central_liberacao');
    }

    public function qddValor()
    {
        return $this->belongsTo(FinQddValor::class, 'id_qdd_valor', 'id_qdd_valor');
    }
}
