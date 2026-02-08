<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    public const UOM_PCS = 'pcs';
    public const UOM_KG = 'kg';
    public const UOM_G = 'g';
    public const UOM_BOX = 'box';
    public const UOM_PACK = 'pack';
    public const UOM_SET = 'set';
    public const UOM_L = 'l';
    public const UOM_ML = 'ml';
    public const UOM_M = 'm';
    public const UOM_MM = 'mm';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public const STATUS_DISCONTINUED = 'discontinued';
    public const STATUS_DRAFT = 'draft';
    public const STATUS_ARCHIVED = 'archived';


    protected $fillable = [
        'pr_name',
        'pr_desc',
        'cat_id',
        'brand_id',
        'pr_thumbnail',
        'uom',
        'status',
        'is_track_inventory'
    ];

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $prefix = 'pr'.date(format: 'ym');
            $model->id = IdGenerator::generate(['table' => 'products', 'length' => 30, 'prefix' => $prefix . str()->random(20)]);

            static::creating(function ($model) {
                if (empty($model->pr_code)) {
                    $uuid = Str::uuid();
                    $model->pr_code = hash('sha256', $uuid);
                }
            });
        });
    }

    public static function uomOptions(){
        return [
            self::UOM_PCS => 'Pieces',
            self::UOM_KG => 'Kilograms',
            self::UOM_G => 'Grams',
            self::UOM_BOX => 'Box',
            self::UOM_PACK => 'Pack',
            self::UOM_SET => 'Set',
            self::UOM_L => 'Liters',
            self::UOM_ML => 'Milliliters',
            self::UOM_M => 'Meters',
            self::UOM_MM => 'Millimeters',
        ];
    }

    public static function statusOptions(){
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_DISCONTINUED => 'Discontinued',
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_ARCHIVED => 'Archived',
        ];
    }
}
