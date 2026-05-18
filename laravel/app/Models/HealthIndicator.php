<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthIndicator extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'year', 'note_code', 'indicator_type', 'goal', 'unit'];
}
