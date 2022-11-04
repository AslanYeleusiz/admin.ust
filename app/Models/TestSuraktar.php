<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestSuraktar extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'surak';
    public $timestamps = false;

    public function zhauap(){
        return $this->hasMany(TestZhauaptar::class, 'surak_id');
    }

    public function bagyty(){
        return $this->belongsTo(OlimpiadaBagyty::class, 'les_id');
    }

    public function tury(){
        return $this->belongsTo(OlimpiadaTury::class, 'sinip_id');
    }



}
