<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForMedicamento extends Model
{
    protected $table = 'for_medicamento';

    protected $primaryKey = 'id_medicamento';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];
}
