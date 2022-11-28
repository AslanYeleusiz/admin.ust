<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kassa extends Model
{
    use HasFactory;
    protected $guarded=[];
    public $table='kassa';

    public function scopeFindOrCreate($query, $id)
    {
        $obj = $query->find($id);
        return $obj ?: new static;
    }
}
