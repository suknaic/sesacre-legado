<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaTipoGasto extends Model
{
    protected $table = 'pla_tipo_gasto';

    protected $primaryKey = 'id_tipo_gasto';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];
}
