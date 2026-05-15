<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinQddSupRed extends Model
{
    protected $table = 'fin_qdd_sup_red';

    protected $primaryKey = 'id_qdd_sup_red';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function qdd()
    {
        return $this->belongsTo(FinQdd::class, 'id_qdd', 'id_qdd');
    }
}
