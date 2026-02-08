<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;

class PrCategory extends Model
{
    protected $fillable = [
        'cat_name',
        'is_active'
    ];

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $prefix = 'prc'.date(format: 'ym');
            $model->id = IdGenerator::generate(['table' => 'pr_categories', 'length' => 20, 'prefix' => $prefix . str()->random(10)]);
            $model->code = IdGenerator::generate(['table' => 'pr_categories', 'field' => 'cat_code', 'length' => 8, 'prefix' => str()->random(7)]);
        });
    }
}
