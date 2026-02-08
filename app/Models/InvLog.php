<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InvLog extends Model
{
    public const REF_TYPE_PURCHASE = 'purchase';
    public const REF_TYPE_SALE = 'sale';
    public const REF_TYPE_ADJUSTMENT = 'adjustment';
    public const REF_TYPE_TRANSFER = 'transfer';
    public const REF_TYPE_OPENING = 'opening_balance';
    public const REF_TYPE_SYSTEM = 'system';
    public const REF_TYPE_STOCK_TAKE = 'stock_take';

    protected $fillable = [
        'pr_id',
        'pr_name',
        'qty_change',
        'loc_id',
        'stock_br',
        'stock_af',
        'ref_type',
        'ref_id',
        'unit_cost',
        'total_cost',
        'remarks',
    ];

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $prefix = 'inl'.date(format: 'ym');
            $model->id = IdGenerator::generate(['table' => 'inv_logs', 'length' => 30, 'prefix' => $prefix . str()->random(20)]);
        });
        static::creating(function ($model) {
            if (empty($model->public_id)) {
                $model->public_id = hash('sha256', Str::uuid());
            }
        });
    }

    public static function refTypeOptions(){
        return [
            self::REF_TYPE_PURCHASE => 'Purchase',
            self::REF_TYPE_SALE => 'Sale',
            self::REF_TYPE_ADJUSTMENT => 'Adjustment',
            self::REF_TYPE_TRANSFER => 'Transfer',
            self::REF_TYPE_OPENING => 'Opening Balance',
            self::REF_TYPE_SYSTEM => 'System',
            self::REF_TYPE_STOCK_TAKE => 'Stock Take',
        ];
    }
}
