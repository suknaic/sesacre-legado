<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinTipoEmpenho extends Model
{
    protected $table = 'fin_tipo_empenho';

    protected $primaryKey = 'id_tipo_empenho';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];
}
