<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialSkidka extends Model
{
    use HasFactory;
    protected $guarded=[];
    public $table='doc_skidka';
    public $timestamps=false;

    public function material() {
        return $this->belongsTo(Material::class, 'doc_id');
    }

}
