<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinDocTramitacao extends Model
{
    protected $table = 'fin_doc_tramitacao';

    protected $primaryKey = 'id_doc_tramitacao';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function documentoSituacao()
    {
        return $this->belongsTo(FinDocumentoSituacao::class, 'id_documento_situacao', 'id_documento_situacao');
    }

    public function documentoFiscal()
    {
        return $this->belongsTo(FinDocumentoFiscal::class, 'id_documento_fiscal', 'id_documento_fiscal');
    }
}
