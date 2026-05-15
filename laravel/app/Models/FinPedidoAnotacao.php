<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinPedidoAnotacao extends Model
{
    protected $table = 'fin_pedido_anotacao';

    protected $primaryKey = 'id_pedido_anotacao';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function pedido()
    {
        return $this->belongsTo(FinPedido::class, 'id_pedido', 'id_pedido');
    }
}
