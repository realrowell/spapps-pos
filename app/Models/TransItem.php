<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;

class TransItem extends Model
{
    protected $fillable = [
        'trans_id',
        'pr_id',
        'pr_name',
        'uom',
        'qty',
        'pr_price',
        'line_total'
    ];

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $prefix = 'trp'.date(format: 'ym');
            $model->id = IdGenerator::generate(['table' => 'trans_items', 'length' => 30, 'prefix' => $prefix . str()->random(20)]);
        });
    }
}
