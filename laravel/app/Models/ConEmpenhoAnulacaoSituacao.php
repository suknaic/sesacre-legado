<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConEmpenhoAnulacaoSituacao extends Model
{
    protected $table = 'con_empenho_anulacao_situacao';

    protected $primaryKey = 'id_empenho_anulacao_situacao';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function anulacoes()
    {
        return $this->hasMany(ConEmpenhoAnulacao::class, 'id_empenho_anulacao_situacao', 'id_empenho_anulacao_situacao');
    }
}
