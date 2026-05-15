<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConLiquidacaoSituacao extends Model
{
    protected $table = 'con_liquidacao_situacao';

    protected $primaryKey = 'id_liquidacao_situacao';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function liquidacoes()
    {
        return $this->hasMany(ConLiquidacao::class, 'id_liquidacao_situacao', 'id_liquidacao_situacao');
    }

    public function pagamentos()
    {
        return $this->hasMany(ConPagamento::class, 'id_liquidacao_situacao', 'id_liquidacao_situacao');
    }
}
