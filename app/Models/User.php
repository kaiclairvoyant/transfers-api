<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;

class User extends Model
{
    use HasFactory;

    public const TYPE_COMMON = 1;
    public const TYPE_SHOPKEEPER = 2;

    protected $keyType = 'string';

    public $incrementing = false;

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

    public function transfers(): HasMany
    {
        return $this->hasMany(Transfer::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!isset($model->id)) {
                $model->id = Uuid::uuid4()->toString();
            }
        });
    }
}
