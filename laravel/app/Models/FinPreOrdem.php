<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinPreOrdem extends Model
{
    protected $table = 'fin_pre_ordem';

    protected $primaryKey = 'id_pre_ordem';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function pedido()
    {
        return $this->belongsTo(FinPedido::class, 'id_pedido', 'id_pedido');
    }

    public function fornecedor()
    {
        return $this->belongsTo(FinFornecedor::class, 'id_fornecedor', 'id_fornecedor');
    }

    public function ordemItens()
    {
        return $this->hasMany(FinOrdemItem::class, 'id_pre_ordem', 'id_pre_ordem');
    }
}
