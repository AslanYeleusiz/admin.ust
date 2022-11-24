<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsVerification extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'phone', 'status'];

    const STATUS_VERIFIED = 'verified';
    const STATUS_PENDING = 'pending';
    const LIMIT_SMS = 3;
    const LIMIT_SMS_MINUTE = 30;

    public function scopeStatusPending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopePhoneBy($query, $phone)
    {
        return $query->where('phone', $phone);
    }
}
