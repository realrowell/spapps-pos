<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;

class PrInventory extends Model
{
    protected $fillable = [
        'pr_id',
        'stock_qty',
        'loc_id'
    ];

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $prefix = 'pri'.date(format: 'ym');
            $model->id = IdGenerator::generate(['table' => 'pr_inventories', 'length' => 20, 'prefix' => $prefix . str()->random(13)]);
        });
    }
}
