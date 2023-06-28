<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    // protected $fillable = [
    //     'name',
    //     'phonenumber',
    //     'address',
    // ];
}
