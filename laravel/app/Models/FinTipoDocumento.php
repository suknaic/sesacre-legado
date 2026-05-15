<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinTipoDocumento extends Model
{
    protected $table = 'fin_tipo_documento';

    protected $primaryKey = 'id_tipo_documento';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function documentosFiscais()
    {
        return $this->hasMany(FinDocumentoFiscal::class, 'id_tipo_documento', 'id_tipo_documento');
    }
}
