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
}
