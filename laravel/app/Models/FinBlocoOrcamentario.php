<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinBlocoOrcamentario extends Model
{
    protected $table = 'fin_bloco_orcamentario';

    protected $primaryKey = 'id_bloc_orcamentario';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];

    public function redesTematicas()
    {
        return $this->hasMany(FinRedeTematica::class, 'id_bloc_orcamentario', 'id_bloc_orcamentario');
    }
}
