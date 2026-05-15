<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinProgTrabFuncao extends Model
{
    protected $table = 'fin_prog_trab_funcao';

    protected $primaryKey = 'id_cod_funcao';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];
}
