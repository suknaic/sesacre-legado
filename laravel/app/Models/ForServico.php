<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForServico extends Model
{
    protected $table = 'for_servico';

    protected $primaryKey = 'id_servio';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function getIncrementing()
    {
        return true;
    }

    public function getKeyName()
    {
        return 'id_servio';
    }
}
