<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;

class UsrModuleCheck extends Model
{
    public const MODULE_SALES = 'sales';
    public const MODULE_PURCHASE = 'purchase';
    public const MODULE_USER_MGMT = 'user_mgmt';
    public const MODULE_REPORTS = 'reports';
    protected $fillable = [
        'user_id',
        'sys_module'
    ];

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $prefix = 'umc'.date(format: 'ym');
            $model->id = IdGenerator::generate(['table' => 'usr_module_checks', 'length' => 20, 'prefix' => $prefix . str()->random(10)]);
        });
    }

    public static function moduleOptions(){
        return[
            self::MODULE_SALES => 'Sales',
            self::MODULE_PURCHASE => 'Purchase',
            self::MODULE_USER_MGMT => 'User Management',
            self::MODULE_REPORTS => 'Reports'
        ];
    }
}
