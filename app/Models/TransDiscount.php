<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;

class TransDiscount extends Model
{
    protected $fillable = [
        'trans_id',
        'disc_id',
        'amount',
        'description'
    ];

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $prefix = 'dist'.date(format: 'ym');
            $model->id = IdGenerator::generate(['table' => 'trans_discounts', 'length' => 20, 'prefix' => $prefix . str()->random(10)]);
        });
    }
}
