<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QmgOrders extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "qmgorders";
    public $timestamps = false;

    public function bolim() {
        return $this->belongsTo(QmgBolim::class, 'bolim_id');
    }
}
