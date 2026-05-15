<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinProgTrabSubFuncao extends Model
{
    protected $table = 'fin_prog_trab_subfuncao';

    protected $primaryKey = 'id_cod_sub_funcao';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];
}
