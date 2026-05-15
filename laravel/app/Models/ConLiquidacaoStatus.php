<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConLiquidacaoStatus extends Model
{
    protected $table = 'con_liquidacao_status';

    protected $primaryKey = 'id_liquidacao_status';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function liquidacoes()
    {
        return $this->hasMany(ConLiquidacao::class, 'id_liquidacao_status', 'id_liquidacao_status');
    }
}
