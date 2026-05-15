<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinContItens extends Model
{
    protected $table = 'fin_cont_itens';

    protected $primaryKey = 'id_cont_itens';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];
}
