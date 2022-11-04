<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestSaves extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'save_test';
    public $timestamps = false;

    public function surak(){
        return $this->belongsTo(TestSuraktar::class, 'surak_id');
    }

    public function zhauap(){
        return $this->belongsTo(TestZhauaptar::class, 'zhauap_id');
    }

}
