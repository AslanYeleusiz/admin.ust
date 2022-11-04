<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OlimpiadaKatysushy extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'o_katysushy';
    protected $primaryKey = "idd";
}
