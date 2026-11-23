<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
    protected $table = 'person';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'notes',
    ];

    public function movements(): HasMany
    {
        return $this->hasMany(Movement::class);
    }
}
