<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QmgBolim extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'qmgbolim';
    public $timestamps = false;
    const IMAGE_PATH = 'qmgbolim/';
    const DOC_PATH = 'qmgdocs/';

    protected $attributes = [
        'lang' => 1
    ];

    public function scopeIsEnabled($query) {
        return $query->where('enable', 1);
    }

    public function subject() {
        return $this->belongsTo(QmgSubjects::class, 'sub_id');
    }

}
