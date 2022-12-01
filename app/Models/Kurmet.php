<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurmet extends Model
{
    use HasFactory;
    protected $guarded=[];
    public $table='kurmet';
    public $timestamps=false;
    protected $attributes = [
        'oblis' => '',
        'audan' => '',
        'mektep' => '',
        'spet' => '',
        'uniq_id' => 0,
    ];
}
