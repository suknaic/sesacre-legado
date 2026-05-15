<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesPessoaFisica extends Model
{
    protected $table = 'ses_pessoa_fisica';

    protected $primaryKey = 'id_pessoa_fisica';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function pessoa()
    {
        return $this->belongsTo(SesPessoa::class, 'id_pessoa', 'id_pessoa');
    }
}
