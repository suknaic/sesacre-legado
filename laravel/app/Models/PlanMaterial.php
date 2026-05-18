<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'description_code', 'description_name', 'group_code',
        'group_name', 'subgroup_code', 'subgroup_name', 'material_type',
        'expense_element_code', 'expense_type_id',
    ];
}
