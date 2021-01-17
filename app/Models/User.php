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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'credit',
        'document',
        'email',
        'name',
        'password',
        'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
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
