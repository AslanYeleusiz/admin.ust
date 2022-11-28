<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OlimpiadaTizim extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'o_tizim';
    public $timestamps = false;
    const CERTIFICATE_PATH = 'images/certificates';

    public function katysushy() {
        return $this->belongsTo(OlimpiadaKatysu::class, 'o_order_id', 'o_order_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
