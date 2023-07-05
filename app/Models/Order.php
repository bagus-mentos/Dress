<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'torder';
    protected $primaryKey = 'idt_order';
    protected $guarded = ['idt_order'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'idr_product', 'idr_product');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'idr_customer', 'idr_customer');
    }
}
