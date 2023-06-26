<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'rcustomer';
    protected $primaryKey = 'idr_customer';
    // protected $guarded = ['idr_customer'];
    protected $fillable = [
        'name',
        'phonenumber',
        'address',
    ];
}
