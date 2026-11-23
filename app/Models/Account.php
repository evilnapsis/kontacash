<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    protected $table = 'account';

    protected $fillable = [
        'name',
        'bank_name',
        'account_number',
        'initial_balance',
    ];

    protected function casts(): array
    {
        return [
            'initial_balance' => 'decimal:2',
        ];
    }

    public function movements(): HasMany
    {
        return $this->hasMany(Movement::class);
    }

    public function scopeWithBalance(Builder $query): Builder
    {
        return $query
            ->withSum(['movements as total_income' => fn (Builder $q) => $q->where('kind', Movement::KIND_INCOME)], 'amount')
            ->withSum(['movements as total_expense' => fn (Builder $q) => $q->where('kind', Movement::KIND_EXPENSE)], 'amount');
    }

    public function getBalanceAttribute(): float
    {
        $income = $this->total_income ?? $this->movements()->where('kind', Movement::KIND_INCOME)->sum('amount');
        $expense = $this->total_expense ?? $this->movements()->where('kind', Movement::KIND_EXPENSE)->sum('amount');

        return (float) $this->initial_balance + (float) $income - (float) $expense;
    }
}
