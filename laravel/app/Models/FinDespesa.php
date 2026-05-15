<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinDespesa extends Model
{
    protected $table = 'fin_despesa';

    protected $primaryKey = 'id_despesa';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function elementos()
    {
        return $this->hasMany(FinDespesaElemento::class, 'id_despesa', 'id_despesa');
    }

    public function pedidos()
    {
        return $this->hasMany(FinPedido::class, 'id_despesa', 'id_despesa');
    }
}
