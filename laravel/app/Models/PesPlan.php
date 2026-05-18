<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesPlan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_year', 'end_year', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
