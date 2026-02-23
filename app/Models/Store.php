<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'store_name',
        'store_desc',
        'logo',
        'primary_color',
        'accent_color',
        'is_active'
    ];

    // public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->store_code = IdGenerator::generate(['table' => 'stores', 'field' => 'store_code', 'length' => 8, 'prefix' => str()->random(7)]);
        });
    }
}
