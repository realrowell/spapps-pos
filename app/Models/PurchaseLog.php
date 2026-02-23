<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseLog extends Model
{
    protected $fillable = [
        'purchase_id',
        'user_id',
        'user_name',
        'status',
        'remarks'
    ];
}
