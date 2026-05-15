<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinOrdem extends Model
{
    protected $table = 'fin_ordem';

    protected $primaryKey = 'id_ordem';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function pedido()
    {
        return $this->belongsTo(FinPedido::class, 'id_pedido', 'id_pedido');
    }

    public function itens()
    {
        return $this->hasMany(FinOrdemItem::class, 'id_ordem', 'id_ordem');
    }
}
