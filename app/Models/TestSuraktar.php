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

    public function zhauaptar(){
        return $this->hasMany(TestZhauaptar::class, 'surak_id');
    }
}
