<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinTipoAdministracao extends Model
{
    protected $table = 'fin_tipo_administracao';

    protected $primaryKey = 'id_tipo_administracao';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];
}
