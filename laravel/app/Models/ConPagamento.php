<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConPagamento extends Model
{
    use HasFactory;
    protected $table = 'con_pagamento';

    protected $primaryKey = 'id_pagamento';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function liquidacao()
    {
        return $this->belongsTo(ConLiquidacao::class, 'id_liquidacao', 'id_liquidacao');
    }

    public function liquidacaoSituacao()
    {
        return $this->belongsTo(ConLiquidacaoSituacao::class, 'id_liquidacao_situacao', 'id_liquidacao_situacao');
    }
}
