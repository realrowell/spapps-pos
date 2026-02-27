<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PurchasePayment extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'purchase_id',
        'payment_provider_id',
        'amount',
        'external_transaction_id',
        'reference_no',
        'paid_at'
    ];

    // public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->payment_ref)) {
                $model->payment_ref = 'POP' . date('ym') . hash('sha256', Str::uuid());
            }
        });
    }
}
