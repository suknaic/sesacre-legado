<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinModalidade extends Model
{
    protected $table = 'gco_modalidade';

    protected $primaryKey = 'id_modalidade';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];
}
