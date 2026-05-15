<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinProgramaTrabalho extends Model
{
    protected $table = 'fin_programa_trabalho';

    protected $primaryKey = 'id_programa_trabalho';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function qddValores()
    {
        return $this->hasMany(FinQddValor::class, 'id_programa_trabalho', 'id_programa_trabalho');
    }

    public function pedidos()
    {
        return $this->hasMany(FinPedido::class, 'id_programa_trabalho', 'id_programa_trabalho');
    }

    public function contratos()
    {
        return $this->hasMany(FinContrato::class, 'id_programa_trabalho', 'id_programa_trabalho');
    }
}
