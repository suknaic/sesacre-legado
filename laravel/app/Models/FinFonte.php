<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinFonte extends Model
{
    protected $table = 'fin_fonte';

    protected $primaryKey = 'id_fonte';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function qddValores()
    {
        return $this->hasMany(FinQddValor::class, 'id_fonte', 'id_fonte');
    }

    public function pedidos()
    {
        return $this->hasMany(FinPedido::class, 'id_fonte', 'id_fonte');
    }

    public function convenios()
    {
        return $this->hasMany(FinConvenio::class, 'id_fonte', 'id_fonte');
    }

    public function contratos()
    {
        return $this->hasMany(FinContrato::class, 'id_fonte', 'id_fonte');
    }
}
