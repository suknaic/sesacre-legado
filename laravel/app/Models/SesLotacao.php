<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesLotacao extends Model
{
    protected $table = 'ses_lotacao';

    protected $primaryKey = 'id_lotacao';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function pai()
    {
        return $this->belongsTo(self::class, 'id_pai', 'id_lotacao');
    }
}
