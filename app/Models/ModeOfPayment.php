<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;

class ModeOfPayment extends Model
{
    public const TYPE_CASH = 'cash';
    public const TYPE_ONLINE = 'online';
    protected $fillable = [
        'mop_type',
        'mop_name',
        'is_active'
    ];

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $prefix = 'mop'.date(format: 'ym');
            $model->id = IdGenerator::generate(['table' => 'mode_of_payments', 'length' => 20, 'prefix' => $prefix . str()->random(10)]);
            $model->code = IdGenerator::generate(['table' => 'mode_of_payments', 'field' => 'mop_code', 'length' => 6, 'prefix' => str()->random(5)]);
        });
    }
    public static function mopTypeOptions(){
        return [
            self::TYPE_CASH => 'Cash',
            self::TYPE_ONLINE => 'Online',
        ];
    }
}
