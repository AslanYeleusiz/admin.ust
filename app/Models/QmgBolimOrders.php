<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QmgBolimOrders extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "qmgbolimorders";
    public $timestamps = false;

    public function bolim() {
        return $this->belongsTo(QmgBolim::class, 'bolim_id');
    }
}
