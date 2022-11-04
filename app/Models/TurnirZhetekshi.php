<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnirZhetekshi extends Model
{
    use HasFactory;
    protected $table = 'turnir_zhetekshi';
    protected $guarded = [];
    public $timestamps = false;
    protected $attributes = [
        'update_count' => 1
    ];
}
