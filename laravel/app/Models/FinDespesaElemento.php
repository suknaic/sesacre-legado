<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinDespesaElemento extends Model
{
    protected $table = 'fin_despesa_elemento';

    protected $primaryKey = 'id_despesa_elemento';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function despesa()
    {
        return $this->belongsTo(FinDespesa::class, 'id_despesa', 'id_despesa');
    }

    public function qddValores()
    {
        return $this->hasMany(FinQddValor::class, 'id_despesa_elemento', 'id_despesa_elemento');
    }

    public function pedidos()
    {
        return $this->hasMany(FinPedido::class, 'id_despesa_elemento', 'id_despesa_elemento');
    }
}
