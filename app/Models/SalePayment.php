<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SalePayment extends Model
{
    use SoftDeletes;
    public const STATUS_PENDING = 'pending';
    public const STATUS_SUCCESS = 'success';
    public const STATUS_FAILED = 'failed';
    public const STATUS_REVERSED = 'reversed';

    protected $fillable = [
        'sale_id',
        'payment_provider_id',
        'amount',
        'status',
        'external_transaction_id',
        'reference_no',
        'paid_at',
        'meta'
    ];

    // public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->payment_ref)) {
                $model->payment_ref = 'INVP' . date('ym') . hash('sha256', Str::uuid());
            }
        });
    }

    public static function statusOptions()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_SUCCESS => 'Success',
            self::STATUS_FAILED => 'Failed',
            self::STATUS_REVERSED => 'Reversed',
        ];
    }
}
