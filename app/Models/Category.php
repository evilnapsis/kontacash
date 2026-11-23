<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    public const KIND_INCOME = 1;
    public const KIND_EXPENSE = 2;

    protected $table = 'category';

    protected $fillable = [
        'name',
        'kind',
    ];

    protected function casts(): array
    {
        return [
            'kind' => 'integer',
        ];
    }

    public function movements(): HasMany
    {
        return $this->hasMany(Movement::class);
    }
}
