<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinEmpenhoStatus extends Model
{
    protected $table = 'fin_empenho_status';

    protected $primaryKey = 'id_empenho_status';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];
}
