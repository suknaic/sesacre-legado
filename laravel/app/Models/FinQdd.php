<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinQdd extends Model
{
    protected $table = 'fin_qdd';

    protected $primaryKey = 'id_qdd';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function valores()
    {
        return $this->hasMany(FinQddValor::class, 'id_qdd', 'id_qdd');
    }

    public function suprimentosReducoes()
    {
        return $this->hasMany(FinQddSupRed::class, 'id_qdd', 'id_qdd');
    }
}
