<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinDocVincRecebimento extends Model
{
    protected $table = 'fin_doc_vinc_recebimento';

    protected $primaryKey = 'id_doc_vinc_recebimento';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];
}
