<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinCentralLiberacao extends Model
{
    protected $table = 'fin_central_liberacao';

    protected $primaryKey = 'id_central_liberacao';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];
}
