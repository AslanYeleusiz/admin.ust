<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OlimpiadaZhetekshi extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'o_zhetekshi';
    public $timestamps = false;
}
