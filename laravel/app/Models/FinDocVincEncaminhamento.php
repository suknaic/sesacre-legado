<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinDocVincEncaminhamento extends Model
{
    protected $table = 'fin_doc_vinc_encaminhamento';

    protected $primaryKey = 'id_doc_vinc_encaminhamento';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];
}
