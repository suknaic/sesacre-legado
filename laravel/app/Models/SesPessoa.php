<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesPessoa extends Model
{
    protected $table = 'ses_pessoa';

    protected $primaryKey = 'id_pessoa';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];
}
