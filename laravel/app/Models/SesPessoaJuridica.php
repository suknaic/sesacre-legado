<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesPessoaJuridica extends Model
{
    protected $table = 'ses_pessoa_juridica';

    protected $primaryKey = 'id_pessoa_juridica';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function pessoa()
    {
        return $this->belongsTo(SesPessoa::class, 'id_pessoa', 'id_pessoa');
    }
}
