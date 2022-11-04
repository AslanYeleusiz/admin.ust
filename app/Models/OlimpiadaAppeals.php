<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OlimpiadaAppeals extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'o_appeals';

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function surak(){
        return $this->belongsTo(TestSuraktar::class);
    }
    public function o_tury(){
        return $this->belongsTo(OlimpiadaTury::class, 'class_id');
    }



}
