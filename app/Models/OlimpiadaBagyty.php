<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OlimpiadaBagyty extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'o_bagyty';
    protected $primaryKey = "idd";
    public $timestamps = false;

    public function scopeIsEnabled($query) {
        return $query->where('enable', 1);
    }
    public function katysushy() {
        return $this->belongsTo(OlimpiadaKatysushy::class);
    }
    public function suraktar() {
        return $this->hasMany(TestSuraktar::class, 'les_id');
    }


}
