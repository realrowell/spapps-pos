<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PurchasePayment extends Model
{
    protected $fillable = [
        'purchase_id',
        'mop',
        'mop_id',
        'amount',
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
