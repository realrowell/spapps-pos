<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;

class PrBrand extends Model
{
    protected $fillable = [
        'brand_name',
        'brand_desc',
        'is_active'
    ];

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $prefix = 'prb'.date(format: 'ym');
            $model->id = IdGenerator::generate(['table' => 'pr_brands', 'length' => 20, 'prefix' => $prefix . str()->random(10)]);
            $model->code = IdGenerator::generate(['table' => 'pr_brands', 'field' => 'brand_code', 'length' => 8, 'prefix' => str()->random(7)]);
        });
    }
}
