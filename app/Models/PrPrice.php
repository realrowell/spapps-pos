<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;

class PrPrice extends Model
{
    public const TYPE_RETAIL = 'retail';
    public const TYPE_WHOLESALE = 'wholesale';
    public const TYPE_PROMO = 'promo';

    protected $fillable = [
        'pr_id',
        'price_type',
        'price',
        'is_active',
        'effective_from',
        'effective_to'
    ];

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $prefix = 'prp'.date(format: 'ym');
            $model->id = IdGenerator::generate(['table' => 'pr_prices', 'length' => 20, 'prefix' => $prefix . str()->random(10)]);
            $model->price_code = IdGenerator::generate(['table' => 'pr_prices', 'field' => 'price_code', 'length' => 8, 'prefix' => str()->random(7)]);
        });
    }

    public static function priceTypeOptions(){
        return [
            self::TYPE_RETAIL => 'Retail',
            self::TYPE_WHOLESALE => 'Wholesale',
            self::TYPE_PROMO => 'Promo',
        ];
    }
}
