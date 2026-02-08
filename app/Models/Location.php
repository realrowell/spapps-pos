<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'loc_name',
        'loc_desc',
        'is_active'
    ];

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $prefix = 'loc';
            $model->id = IdGenerator::generate(['table' => 'locations', 'length' => 15, 'prefix' => $prefix . str()->random(10)]);
            $model->code = IdGenerator::generate(['table' => 'locations', 'field' => 'loc_code', 'length' => 8, 'prefix' => str()->random(5)]);
        });
    }
}
