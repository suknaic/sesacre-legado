<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConEmpenho extends Model
{
    protected $table = 'fin_empenho';

    protected $primaryKey = 'id_empenho';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function pedido()
    {
        return $this->belongsTo(FinPedido::class, 'id_pedido', 'id_pedido');
    }

    public function tipoEmpenho()
    {
        return $this->belongsTo(FinTipoEmpenho::class, 'id_tipo_empenho', 'id_tipo_empenho');
    }

    public function empenhoStatus()
    {
        return $this->belongsTo(FinEmpenhoStatus::class, 'id_empenho_status', 'id_empenho_status');
    }
}
