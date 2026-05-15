<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinContrato extends Model
{
    protected $table = 'fin_contrato';

    protected $primaryKey = 'id_contrato';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function programaTrabalho()
    {
        return $this->belongsTo(FinProgramaTrabalho::class, 'id_programa_trabalho', 'id_programa_trabalho');
    }

    public function fonte()
    {
        return $this->belongsTo(FinFonte::class, 'id_fonte', 'id_fonte');
    }

    public function fornecedor()
    {
        return $this->belongsTo(FinFornecedor::class, 'id_fornecedor', 'id_fornecedor');
    }

    public function fornecedorPessoa()
    {
        return $this->belongsTo(SesPessoa::class, 'id_pessoa_fornecedor', 'id_pessoa');
    }

    public function gestorTitular()
    {
        return $this->belongsTo(SesPessoa::class, 'id_pessoa_gestor_titular', 'id_pessoa');
    }

    public function gestorSubstituto()
    {
        return $this->belongsTo(SesPessoa::class, 'id_pessoa_gestor_substituto', 'id_pessoa');
    }

    public function fiscalTitular()
    {
        return $this->belongsTo(SesPessoa::class, 'id_pessoa_fiscal_titular', 'id_pessoa');
    }

    public function fiscalSubstituto()
    {
        return $this->belongsTo(SesPessoa::class, 'id_pessoa_fiscal_substituto', 'id_pessoa');
    }

    public function subFiscalTitular()
    {
        return $this->belongsTo(SesPessoa::class, 'id_pessoa_sub_fiscal_titular', 'id_pessoa');
    }

    public function subFiscalSubstituto()
    {
        return $this->belongsTo(SesPessoa::class, 'id_pessoa_sub_fiscal_substituto', 'id_pessoa');
    }

    public function tipoGasto()
    {
        return $this->belongsTo(PlaTipoGasto::class, 'id_tipo_gasto', 'id_tipo_gasto');
    }

    public function modalidade()
    {
        return $this->belongsTo(FinModalidade::class, 'id_modalidade', 'id_modalidade');
    }
}
