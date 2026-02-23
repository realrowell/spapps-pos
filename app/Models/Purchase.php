<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'trans_type',
        'vendor_id',
        'status',
        'payment_status',
        'gross_amount',
        'tax_amount',
        'net_amount',
        'expected_delivery_date',
        'due_date',
        'parent_purchase_id'
    ];

    // public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $prefix = 'PO-' . date('ym');
            $model->purchase_ref = IdGenerator::generate(['table' => 'purchases', 'field' => 'purchase_ref', 'length' => 10, 'prefix' => $prefix]);
        });
    }
}
