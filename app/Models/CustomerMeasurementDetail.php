<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerMeasurementDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'attribute_id',
        'value',
        'customer_id',
        'unit'
    ];

    // units
    const inches                        = 1;
    const cm                            = 2;
    const mtr                           = 3;
    const yrd                           = 4;
    const ft                            = 5;

    public function attributes() {
        return $this->belongsTo(MeasurementAttribute::class,'attribute_id','id');
    }
    public function getUnit()
    {
        switch ($this->unit) {
            case static::inches:
                $status = __('main.inches');
                break;
            case static::cm:
                $status = __('main.cm');
                break;
            case static::mtr:
                $status = __('main.mtr');
                break;
            case static::yrd:
                $status = __('main.yrd');
                break;
            case static::ft:
                $status = __('main.ft');
                break;
            default:
                $status = '';
        }

        return $status;
    }
}