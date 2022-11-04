<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnirQuestions extends Model
{
    use HasFactory;
    protected $table = 'turnir_questions';
    protected $guarded = [];
    public $timestamps = false;
    protected $attributes = [
        'question_number' => null,
    ];

    public function turnir()
    {
        return $this->belongsTo(Turnirs::class, 'turnir_id');
    }
}
