<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinDocumentoFiscal extends Model
{
    protected $table = 'fin_documento_fiscal';

    protected $primaryKey = 'id_documento_fiscal';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function pedido()
    {
        return $this->belongsTo(FinPedido::class, 'id_pedido', 'id_pedido');
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(FinTipoDocumento::class, 'id_tipo_documento', 'id_tipo_documento');
    }

    public function documentoSituacao()
    {
        return $this->belongsTo(FinDocumentoSituacao::class, 'id_documento_situacao', 'id_documento_situacao');
    }

    public function docTramitacao()
    {
        return $this->belongsTo(FinDocTramitacao::class, 'id_doc_tramitacao', 'id_doc_tramitacao');
    }
}
