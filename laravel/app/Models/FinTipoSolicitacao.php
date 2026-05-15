<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinTipoSolicitacao extends Model
{
    protected $table = 'fin_tipo_solicitacao';

    protected $primaryKey = 'id_tipo_solicitacao';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function pedidos()
    {
        return $this->hasMany(FinPedido::class, 'id_tipo_solicitacao', 'id_tipo_solicitacao');
    }
}
