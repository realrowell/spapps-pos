<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDiscount extends Model
{
    protected $fillable = [
        'sale_id',
        'disc_id',
        'amount',
        'disc_name',
        'description'
    ];

    // public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            // $prefix = 'dist'.date(format: 'ym');
            // $model->id = IdGenerator::generate(['table' => 'trans_discounts', 'length' => 20, 'prefix' => $prefix . str()->random(10)]);
        });
    }
}
