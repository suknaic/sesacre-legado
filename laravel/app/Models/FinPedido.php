<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinPedido extends Model
{
    protected $table = 'fin_pedido';

    protected $primaryKey = 'id_pedido';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function tipoSolicitacao()
    {
        return $this->belongsTo(FinTipoSolicitacao::class, 'id_tipo_solicitacao', 'id_tipo_solicitacao');
    }

    public function fornecedor()
    {
        return $this->belongsTo(FinFornecedor::class, 'id_fornecedor', 'id_fornecedor');
    }

    public function portaria()
    {
        return $this->belongsTo(FinPortaria::class, 'id_portatia', 'id_portaria');
    }

    public function convenio()
    {
        return $this->belongsTo(FinConvenio::class, 'id_convenio', 'id_convenio');
    }

    public function fonte()
    {
        return $this->belongsTo(FinFonte::class, 'id_fonte', 'id_fonte');
    }

    public function programaTrabalho()
    {
        return $this->belongsTo(FinProgramaTrabalho::class, 'id_programa_trabalho', 'id_programa_trabalho');
    }

    public function despesaElemento()
    {
        return $this->belongsTo(FinDespesaElemento::class, 'id_despesa_elemento', 'id_despesa_elemento');
    }

    public function despesa()
    {
        return $this->belongsTo(FinDespesa::class, 'id_despesa', 'id_despesa');
    }

    public function pedidoSituacao()
    {
        return $this->belongsTo(FinPedidoSituacao::class, 'id_pedido_situacao', 'id_pedido_situacao');
    }

    public function anotacoes()
    {
        return $this->hasMany(FinPedidoAnotacao::class, 'id_pedido', 'id_pedido');
    }

    public function autorizacoes()
    {
        return $this->hasMany(FinAutorizacao::class, 'id_pedido', 'id_pedido');
    }

    public function empenhos()
    {
        return $this->hasMany(ConEmpenho::class, 'id_pedido', 'id_pedido');
    }

    public function ordens()
    {
        return $this->hasMany(FinOrdem::class, 'id_pedido', 'id_pedido');
    }

    public function documentosFiscais()
    {
        return $this->hasMany(FinDocumentoFiscal::class, 'id_pedido', 'id_pedido');
    }

    public function preOrdens()
    {
        return $this->hasMany(FinPreOrdem::class, 'id_pedido', 'id_pedido');
    }

    public function liquidacoes()
    {
        return $this->hasManyThrough(ConLiquidacao::class, ConEmpenho::class, 'id_pedido', 'id_empenho', 'id_pedido', 'id_empenho');
    }
}
