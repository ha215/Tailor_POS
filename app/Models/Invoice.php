<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'invoice_number',
        'customer_name',
        'customer_phone',
        'customer_address',
        'customer_id',
        'salesman_id',
        'discount',
        'sub_total',
        'total',
        'notes',
        'total_quantity',
        'created_by',
        'financial_year_id',
        'branch_id',
        'status',
        'delivery_date'
    ];

    //created user relationship 
    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    //sales man relationship
    public function salesman()
    {
        return $this->hasOne(User::class, 'id', 'salesman_id');
    }
    
    //relationship with the products in the invoice
    public function details() {
        return $this->hasMany(InvoiceDetail::class,'invoice_id','id');
    }

    /* invoice details relation */
    public function invoiceProductDetails() {
        return $this->hasMany(InvoiceDetail::class,'invoice_id','id');
    }
    public function paid($id) {
        $sum = InvoicePayment::where('invoice_id',$id)->sum('paid_amount');
        return $sum;
    }
    public function balance($id) {
        $total = Invoice::find($id)->total;
        $sum = InvoicePayment::where('invoice_id',$id)->sum('paid_amount');
        $balance = $total - $sum;
        return $balance;
    }

}