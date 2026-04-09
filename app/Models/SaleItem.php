<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SaleItem extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'sale_id',
        'pr_id',
        'pr_name',
        'uom',
        'qty',
        'price_type',
        'unit_price',
        'line_total'
    ];

    // public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            if (empty($model->public_id)) {
                $model->public_id = hash('sha256', Str::uuid());
            }
        });
    }

    public function products(){
        return $this->hasOne(Product::class, 'id', 'pr_id');
    }
}
