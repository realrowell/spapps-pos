<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public const TYPE_SALE = 'sale';
    public const TYPE_REFUND = 'refund';
    public const STATUS_PENDING = 'pending';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_VOIDED = 'voided';
    public const STATUS_REFUNDED = 'refunded';

    protected $fillable = [
        'trans_type',
        'store_id',
        'gross_amount',
        'discount_amount',
        'tax_amount',
        'net_amount',
        'status',
        'transacted_by',
        'user_id',
        'completed_at'
    ];

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $prefix = 'tra'.date(format: 'ym');
            $model->id = IdGenerator::generate(['table' => 'transactions', 'length' => 30, 'prefix' => $prefix . str()->random(20)]);
            $model->code = IdGenerator::generate(['table' => 'transactions', 'field' => 'trans_ref', 'length' => 10, 'prefix' => str()->random(8)]);
        });
    }

    public static function typeOptions(){
        return [
            self::TYPE_SALE => 'Sale',
            self::TYPE_REFUND => 'Refund'
        ];
    }
    public static function statusOptions(){
        return [
            self::STATUS_PENDING => [
                'status' => 'Pend',
                'present' => 'Pending',
                'past' => 'Pended',
            ],
            self::STATUS_COMPLETED => [
                'status' => 'Complete',
                'present' => 'Completed',
                'past' => 'Completed',
            ],
            self::STATUS_VOIDED => [
                'status' => 'Void',
                'present' => 'Voided',
                'past' => 'Voided',
            ],
            self::STATUS_REFUNDED => [
                'status' => 'Refund',
                'present' => 'Refunded',
                'past' => 'Refunded',
            ],
        ];
    }
}
