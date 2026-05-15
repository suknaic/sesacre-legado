<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConLiquidacaoDoc extends Model
{
    protected $table = 'con_liquidacao_doc';

    protected $primaryKey = 'id_liquidacao_doc';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function liquidacao()
    {
        return $this->belongsTo(ConLiquidacao::class, 'id_liquidacao', 'id_liquidacao');
    }

    public function documentoFiscal()
    {
        return $this->belongsTo(FinDocumentoFiscal::class, 'id_documento_fiscal', 'id_documento_fiscal');
    }
}
