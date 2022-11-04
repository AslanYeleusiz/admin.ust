<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialSubject extends Model
{
    use HasFactory;
    protected $table = 'cat_janr1';
    protected $guarded = [];
    public $timestamps = false;
}
