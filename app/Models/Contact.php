<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'mobile', 'address', 'message',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    /**
     * Number in WhatsApp format (country code + number, digits only), or null
     * when the stored mobile number cannot be used.
     * Indian numbers saved without a country code get "91" added.
     */
    public function getWhatsappNumberAttribute(): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $this->mobile);

        if (strlen($digits) === 11 && str_starts_with($digits, '0')) {
            $digits = substr($digits, 1);                 // 09876543210 -> 9876543210
        }
        if (strlen($digits) === 10 && preg_match('/^[6-9]/', $digits)) {
            return '91' . $digits;                         // Indian mobile without country code
        }
        if (strlen($digits) >= 11 && strlen($digits) <= 15) {
            return $digits;                                // already has a country code
        }

        return null;                                       // too short / not a mobile number
    }
}
