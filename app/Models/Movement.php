<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movement extends Model
{
    public const KIND_INCOME = 1;
    public const KIND_EXPENSE = 2;

    protected $table = 'movement';

    protected $fillable = [
        'kind',
        'amount',
        'movement_date',
        'description',
        'category_id',
        'payment_method_id',
        'account_id',
        'person_id',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'kind' => 'integer',
            'amount' => 'decimal:2',
            'movement_date' => 'date',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
