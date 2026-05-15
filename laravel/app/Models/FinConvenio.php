<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinConvenio extends Model
{
    protected $table = 'fin_convenio';

    protected $primaryKey = 'id_convenio';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function fonte()
    {
        return $this->belongsTo(FinFonte::class, 'id_fonte', 'id_fonte');
    }

    public function pedidos()
    {
        return $this->hasMany(FinPedido::class, 'id_convenio', 'id_convenio');
    }
}
