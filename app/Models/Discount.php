<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    public const TYPE_FIXED = 'fixed';
    public const TYPE_PERCENTAGE = 'percentage';
    protected $fillable = [
        'disc_code',
        'disc_type',
        'description',
        'amount',
        'expiration_date',
        'is_active'
    ];

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $prefix = 'disc'.date(format: 'ym');
            $model->id = IdGenerator::generate(['table' => 'discounts', 'length' => 20, 'prefix' => $prefix . str()->random(10)]);
        });
    }

    public static function discountTypeOptions(){
        return [
            self::TYPE_FIXED => 'Fixed',
            self::TYPE_PERCENTAGE => 'Percentage',
        ];
    }
}
