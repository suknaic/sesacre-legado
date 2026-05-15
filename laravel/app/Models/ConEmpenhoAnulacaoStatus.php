<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConEmpenhoAnulacaoStatus extends Model
{
    protected $table = 'con_empenho_anulacao_status';

    protected $primaryKey = 'id_empenho_anulacao_status';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function anulacoes()
    {
        return $this->hasMany(ConEmpenhoAnulacao::class, 'id_empenho_anulacao_status', 'id_empenho_anulacao_status');
    }
}
