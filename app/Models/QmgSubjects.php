<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QmgSubjects extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'qmgsubjects';
    public $timestamps = false;
}
