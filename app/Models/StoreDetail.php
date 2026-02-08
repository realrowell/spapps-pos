<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;

class StoreDetail extends Model
{
    protected $fillable = [
        'store_name',
        'store_desc'
    ];

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $prefix = 'str'.date(format: 'ym');
            $model->id = IdGenerator::generate(['table' => 'store_details', 'length' => 20, 'prefix' => $prefix . str()->random(10)]);
            $model->code = IdGenerator::generate(['table' => 'store_details', 'field' => 'store_code', 'length' => 8, 'prefix' => str()->random(7)]);
        });
    }
}
