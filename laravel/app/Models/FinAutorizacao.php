<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinAutorizacao extends Model
{
    protected $table = 'fin_autorizacao';

    protected $primaryKey = 'id_autorizacao';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function pedido()
    {
        return $this->belongsTo(FinPedido::class, 'id_pedido', 'id_pedido');
    }
}
