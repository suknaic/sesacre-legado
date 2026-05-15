<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinFornecedor extends Model
{
    protected $table = 'fin_fornecedor';

    protected $primaryKey = 'id_fornecedor';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function contrato()
    {
        return $this->belongsTo(FinContrato::class, 'id_contrato', 'id_contrato');
    }

    public function pedidos()
    {
        return $this->hasMany(FinPedido::class, 'id_fornecedor', 'id_fornecedor');
    }

    public function preOrdens()
    {
        return $this->hasMany(FinPreOrdem::class, 'id_fornecedor', 'id_fornecedor');
    }

    public function ordemItens()
    {
        return $this->hasMany(FinOrdemItem::class, 'id_fornecedor', 'id_fornecedor');
    }

    public function pessoa()
    {
        return $this->belongsTo(SesPessoa::class, 'id_pessoa', 'id_pessoa');
    }

    public function pessoaFisica()
    {
        return $this->hasOneThrough(SesPessoaFisica::class, SesPessoa::class, 'id_pessoa', 'id_pessoa', 'id_pessoa', 'id_pessoa');
    }

    public function pessoaJuridica()
    {
        return $this->hasOneThrough(SesPessoaJuridica::class, SesPessoa::class, 'id_pessoa', 'id_pessoa', 'id_pessoa', 'id_pessoa');
    }

    public function medicamentos()
    {
        return $this->belongsToMany(ForMedicamento::class, 'for_fornecedor_medicamento', 'id_fornecedor', 'id_medicamento');
    }

    public function servicos()
    {
        return $this->belongsToMany(ForServico::class, 'for_fornecedor_servico', 'id_fornecedor', 'id_servico', null, 'id_servio');
    }

    public function materiaisConsumo()
    {
        return $this->belongsToMany(ForMaterialConsumo::class, 'for_fornecedor_material_consumo', 'id_fornecedor', 'id_material_consumo');
    }

    public function materiaisPermanente()
    {
        return $this->belongsToMany(ForMaterialPermanente::class, 'for_fornecedor_material_permanente', 'id_fornecedor', 'id_material_permanente');
    }
}
