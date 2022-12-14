<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialSolds extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'doc_sold';

    public function material() {
        return $this->belongsTo(Material::class, 'doc_id');
    }

}
