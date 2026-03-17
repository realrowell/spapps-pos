<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;

class SaleInvoice extends Model
{
    protected $fillable = [
        'sale_id',
        'public_id',
        'invoice_no',
        'customer_name',
        'customer_contact_no',
        'customer_address',
        'customer_tin',
        'issues_at',
        'printed_at'
    ];

    // public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $prefix = 'INV-';
            $model->invoice_no = IdGenerator::generate(['table' => 'sale_invoices', 'column' => 'invoice_no', 'length' => 11, 'prefix' => $prefix]);
        });
    }
}
