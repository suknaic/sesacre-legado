<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinPedidoSituacao extends Model
{
    protected $table = 'fin_pedido_situacao';

    protected $primaryKey = 'id_pedido_situacao';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function pedidos()
    {
        return $this->hasMany(FinPedido::class, 'id_pedido_situacao', 'id_pedido_situacao');
    }
}
