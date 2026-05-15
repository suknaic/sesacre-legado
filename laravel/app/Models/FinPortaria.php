<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinPortaria extends Model
{
    protected $table = 'fin_portaria';

    protected $primaryKey = 'id_portaria';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function redeTematica()
    {
        return $this->belongsTo(FinRedeTematica::class, 'id_rede_tematica', 'id_rede_tematica');
    }

    public function pedidos()
    {
        return $this->hasMany(FinPedido::class, 'id_portatia', 'id_portaria');
    }
}
