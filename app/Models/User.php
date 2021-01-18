<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;

    public const TYPE_COMMON = 1;
    public const TYPE_SHOPKEEPER = 2;

    protected $keyType = 'string';

    protected $fillable = [
        'credit',
        'document',
        'email',
        'name',
        'password',
        'type',
    ];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'type' => 'integer',
    ];

    public function paidTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'payer_id', 'id');
    }

    public function receivedTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'payee_id', 'id');
    }
}
