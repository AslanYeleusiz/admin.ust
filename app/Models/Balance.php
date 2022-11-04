<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    /** old table kassa */

    protected $fillable = ['user_id', 'account_number'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'id','id')
            ->select('id', 'last_name', 'first_name', 'middle_name', 'email');
    }
}
