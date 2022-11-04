<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialClass extends Model
{
    use HasFactory;
    protected $table = 'cat_janr3';
    protected $guarded = [];
    public $timestamps = false;
}
