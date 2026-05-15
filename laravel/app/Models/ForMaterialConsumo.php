<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForMaterialConsumo extends Model
{
    protected $table = 'for_material_consumo';

    protected $primaryKey = 'id_material_consumo';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];
}
