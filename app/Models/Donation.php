<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'address', 'pincode', 'pan',
        'amount', 'base_amount', 'gst_amount', 'eighty_g_amt',
        'wants_gst', 'gst_number', 'company_name',
        'order_id', 'payment_id', 'signature',
        'status', 'mode', 'response',
    ];

    // The signature and raw gateway response are internal — never serialize them.
    protected $hidden = ['signature', 'response'];

    protected $casts = [
        'amount'       => 'decimal:2',
        'base_amount'  => 'decimal:2',
        'gst_amount'   => 'decimal:2',
        'eighty_g_amt' => 'decimal:2',
        'wants_gst'    => 'boolean',
    ];
}
