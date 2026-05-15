<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinProgTrabPrograma extends Model
{
    protected $table = 'fin_prog_trab_programa';

    protected $primaryKey = 'id_cod_programa';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];
}
