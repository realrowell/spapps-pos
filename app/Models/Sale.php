<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sale_ref',
        'trans_type',
        'store_id',
        'subtotal',
        'discount_amount',
        'tax_amount',
        'total_amount',
        'status',
        'transacted_by',
        'user_id',
        'completed_at'
    ];

    // public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $prefix = 'SO' . date('ym').'-';
            $model->sale_ref = IdGenerator::generate(['table' => 'sales', 'field' => 'sale_ref', 'length' => 11, 'prefix' => $prefix]);
        });
    }



    public const TYPE_SALE = 'sale';
    public const TYPE_REFUND = 'refund';
    public const STATUS_DRAFT = 'draft';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_VOIDED = 'voided';
    public const STATUS_PARTIAL = 'partial';

    public static function typeOptions()
    {
        return [
            self::TYPE_SALE => 'Sale',
            self::TYPE_REFUND => 'Refund'
        ];
    }
    public static function statusOptions()
    {
        return [
            self::STATUS_DRAFT => [
                'status' => 'Draft',
                'present' => 'Drafting',
                'past' => 'Drafted',
            ],
            self::STATUS_COMPLETED => [
                'status' => 'Complete',
                'present' => 'Completing',
                'past' => 'Completed',
            ],
            self::STATUS_VOIDED => [
                'status' => 'Void',
                'present' => 'Voiding',
                'past' => 'Voided',
            ],
            self::STATUS_PARTIAL => [
                'status' => 'Partial',
                'present' => 'Partialing ',
                'past' => 'Partialed ',
            ],
        ];
    }
}
