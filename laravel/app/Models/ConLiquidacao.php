<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConLiquidacao extends Model
{
    protected $table = 'con_liquidacao';

    protected $primaryKey = 'id_liquidacao';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function situacao()
    {
        return $this->belongsTo(ConLiquidacaoSituacao::class, 'id_liquidacao_situacao', 'id_liquidacao_situacao');
    }

    public function status()
    {
        return $this->belongsTo(ConLiquidacaoStatus::class, 'id_liquidacao_status', 'id_liquidacao_status');
    }

    public function pagamentos()
    {
        return $this->hasMany(ConPagamento::class, 'id_liquidacao', 'id_liquidacao');
    }

    public function documentos()
    {
        return $this->hasMany(ConLiquidacaoDoc::class, 'id_liquidacao', 'id_liquidacao');
    }

    public function empenho()
    {
        return $this->belongsTo(ConEmpenho::class, 'id_empenho', 'id_empenho');
    }
}
