<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialDirection extends Model
{
    use HasFactory;
    protected $table = 'cat_janr2';
    protected $guarded = [];
    public $timestamps = false;
}
