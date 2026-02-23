<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_name',
        'contact_info',
        'is_active'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $prefix = 'VEN' . date('ym');
            $model->vendor_code = IdGenerator::generate(['table' => 'vendors', 'field' => 'vendor_code', 'length' => 10, 'prefix' => $prefix . str()->random(2)]);
        });
    }
}
