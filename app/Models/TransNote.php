<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;

class TransNote extends Model
{
    public const TYPE_SYSTEM = 'system';
    public const TYPE_MANUAL = 'manual';

    protected $fillable = [
        'trans_id',
        'note_type',
        'note',
        'created_by'
    ];

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $prefix = 'trn'.date(format: 'ym');
            $model->id = IdGenerator::generate(['table' => 'trans_notes', 'length' => 20, 'prefix' => $prefix . str()->random(10)]);
        });
    }

    public static function typeOptions(){
        return [
            self::TYPE_SYSTEM => 'System',
            self::TYPE_MANUAL => 'Manual',
        ];
    }
}
