<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinQddValor extends Model
{
    protected $table = 'fin_qdd_valor';

    protected $primaryKey = 'id_qdd_valor';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function qdd()
    {
        return $this->belongsTo(FinQdd::class, 'id_qdd', 'id_qdd');
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
}
