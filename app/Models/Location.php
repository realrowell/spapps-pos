<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;
    protected $fillable = [
        'loc_name',
        'loc_desc',
        'is_active'
    ];

    // public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            if (empty($model->loc_code)) {
                $model->loc_code = IdGenerator::generate(['table' => 'locations', 'field' => 'loc_code', 'length' => 8, 'prefix' => str()->random(5)]);
            }
        });
    }
}
