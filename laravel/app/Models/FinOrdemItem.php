<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinOrdemItem extends Model
{
    protected $table = 'fin_ordem_itens';

    protected $primaryKey = 'id_ordem_itens';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function ordem()
    {
        return $this->belongsTo(FinOrdem::class, 'id_ordem', 'id_ordem');
    }

    public function preOrdem()
    {
        return $this->belongsTo(FinPreOrdem::class, 'id_pre_ordem', 'id_pre_ordem');
    }

    public function fornecedor()
    {
        return $this->belongsTo(FinFornecedor::class, 'id_fornecedor', 'id_fornecedor');
    }
}
