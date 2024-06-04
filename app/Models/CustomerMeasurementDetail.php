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
        'customer_measurement_id'
    ];

    public function attributes() {
        return $this->belongsTo(MeasurementAttribute::class,'attribute_id','id');
    }
    public function units() {
        return $this->belongsTo(MeasurementAttribute::class,'attribute_id','id');
    }
}