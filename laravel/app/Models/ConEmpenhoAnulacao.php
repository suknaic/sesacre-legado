<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConEmpenhoAnulacao extends Model
{
    use HasFactory;
    protected $table = 'con_empenho_anulacao';

    protected $primaryKey = 'id_empenho_anulacao';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function situacao()
    {
        return $this->belongsTo(ConEmpenhoAnulacaoSituacao::class, 'id_empenho_anulacao_situacao', 'id_empenho_anulacao_situacao');
    }

    public function status()
    {
        return $this->belongsTo(ConEmpenhoAnulacaoStatus::class, 'id_empenho_anulacao_status', 'id_empenho_anulacao_status');
    }

    public function pedido()
    {
        return $this->belongsTo(FinPedido::class, 'id_pedido', 'id_pedido');
    }
}
