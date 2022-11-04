<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialZhinak extends Model
{
    use HasFactory;
    protected $guarded=[];
    public $table = 'zhinak';
    public $timestamps = false;

    public function user() {
       return $this->belongsTo(User::class);
    }

    public function material() {
       return $this->belongsTo(Material::class, 'doc_id');
    }
}
