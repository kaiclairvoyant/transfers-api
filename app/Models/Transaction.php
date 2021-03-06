<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Ramsey\Uuid\Uuid;

class Transaction extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'payer_id',
        'payee_id',
        'value',
    ];

    public function getCreatedAtAttribute(string $date): string
    {
        return (new Carbon($date))->format('d-m-Y H:i:s');
    }

    public function payer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payer_id', 'id');
    }

    public function payee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payee_id', 'id');
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
