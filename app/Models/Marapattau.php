<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marapattau extends Model
{
    use HasFactory;
    protected $guarded=[];
    public $table='marapattau';
    public $timestamps=false;

    public function scopeFindOrCreate($query, $id)
    {
        $obj = $query->find($id);
        return $obj ?: new static;
    }

    protected $attributes = [
        'oblis' => '',
        'audan' => '',
        'mektep' => '',
        'spet' => '',
        'uniq_id' => 0,
    ];

}
