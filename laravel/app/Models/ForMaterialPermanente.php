<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForMaterialPermanente extends Model
{
    protected $table = 'for_material_permanente';

    protected $primaryKey = 'id_material_permanente';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $guarded = [];
}
