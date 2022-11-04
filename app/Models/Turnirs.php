<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turnirs extends Model
{
    use HasFactory;
    protected $table = 'turnirs';
    protected $guarded = [];
    public $timestamps = false;
    protected $attributes = [
        'price' => 400,
        'old_price' => 600,
        'icon' => null,
        'texttype' => 0,
    ];

    public function questions()
    {
        return $this->hasMany(TurnirQuestions::class, 'turnir_id');
    }

    public function scopeIsActive($query)
    {
        return $query->where('active', 1);
    }
    public function scopeIsNotActive($query)
    {
        return $query->where('active', 0);
    }



}
