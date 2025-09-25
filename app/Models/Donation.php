<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','email','phone','address','pincode',
        'amount','order_id','payment_id','signature',
        'status','response'
    ];
}
