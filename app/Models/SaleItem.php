<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleItem extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'sale_id',
        'pr_id',
        'pr_name',
        'uom',
        'qty',
        'price_type',
        'unit_price',
        'line_total'
    ];

    // public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            // $prefix = 'trp'.date(format: 'ym');
            // $model->id = IdGenerator::generate(['table' => 'trans_items', 'length' => 30, 'prefix' => $prefix . str()->random(20)]);
        });
    }
}
