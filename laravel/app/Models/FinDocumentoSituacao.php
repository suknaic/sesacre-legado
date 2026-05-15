<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinDocumentoSituacao extends Model
{
    protected $table = 'fin_documento_situacao';

    protected $primaryKey = 'id_documento_situacao';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function documentosFiscais()
    {
        return $this->hasMany(FinDocumentoFiscal::class, 'id_documento_situacao', 'id_documento_situacao');
    }

    public function docTramitacoes()
    {
        return $this->hasMany(FinDocTramitacao::class, 'id_documento_situacao', 'id_documento_situacao');
    }
}
