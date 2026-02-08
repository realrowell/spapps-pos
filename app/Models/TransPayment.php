<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TransPayment extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_SUCCESS = 'success';
    public const STATUS_FAILED = 'failed';
    public const STATUS_REVERSED = 'reversed';

    protected $fillable = [
        'trans_id',
        'payment_method',
        'mop_id',
        'amount',
        'status',
        'reference_no',
        'provider',
        'paid_at',
        'meta'
    ];

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $prefix = 'trpp'.date(format: 'ym');
            $model->id = IdGenerator::generate(['table' => 'trans_payments', 'length' => 35, 'prefix' => $prefix . str()->random(25)]);
        });
        static::creating(function ($model) {
            if (empty($model->public_id)) {
                $model->public_id = hash('sha256', Str::uuid());
            }
        });
    }

    public static function statusOptions(){
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_SUCCESS => 'Success',
            self::STATUS_FAILED => 'Failed',
            self::STATUS_REVERSED => 'Reversed',
        ];
    }
}
