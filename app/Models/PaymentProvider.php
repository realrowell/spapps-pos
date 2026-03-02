<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentProvider extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'provider_code',
        'provider_name',
        'mop_id',
        'account_name',
        'account_number',
        'is_active'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            if (empty($model->provider_code)) {
                $model->provider_code = IdGenerator::generate(['table' => 'payment_providers', 'field' => 'provider_code', 'length' => 9, 'prefix' => 'PROV-'.str()->random(3)]);
            }
        });
    }

    public function mops(){
        return $this->hasOne(ModeOfPayment::class, 'id', 'mop_id');
    }
}
