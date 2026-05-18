<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrganizationDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id', 'category_id', 'name', 'cnpj', 'city_id',
        'address', 'neighborhood', 'zip_code', 'email', 'phone',
        'latitude', 'longitude', 'manager_id', 'is_principal', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_principal' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(OrganizationCategory::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
