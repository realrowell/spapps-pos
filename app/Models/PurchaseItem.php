<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    protected $fillable = [
        'purchase_id',
        'pr_id',
        'pr_name',
        'uom',
        'qty_ordered',
        'qty_received',
        'unit_cost',
        'line_total'
    ];
}
