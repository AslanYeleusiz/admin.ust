<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qmg extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'qmg';

    public function scopeIsEnabled($query) {
        return $query->where('enable', 1);
    }
}
