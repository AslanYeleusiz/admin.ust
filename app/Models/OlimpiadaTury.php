<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OlimpiadaTury extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'o_tury';
    protected $primaryKey = "idd";
    public $timestamps = false;

    public function scopeIsEnabled($query) {
        return $query->where('enable', 1);
    }
    public function bagyty() {
        return $this->belongsTo(OlimpiadaBagyty::class, 'o_bagyty_idd');
    }
    public function suraktar() {
        return $this->hasMany(TestSuraktar::class, 'sinip_id');
    }
}
