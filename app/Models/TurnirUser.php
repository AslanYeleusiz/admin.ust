<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnirUser extends Model
{
    use HasFactory;
    protected $table = 'turnir_user';
    protected $guarded = [];
    public $timestamps = false;
    protected $attributes = [
        'work_user' => null,
        'success' => 0,
        'chance' => 3,
        'update_count' => 1,
        'muragatta' => 0,
        'old_price' => null,
        'durys' => null,
        'kate' => null,
        'date_end' => null,
        'zhetekshi' => null,
        'zh_name' => null,
        'zh_work' => null,
        'quantity' => null,
        'go' => 0,
    ];

    public function turnir() {
        return $this->belongsTo(Turnirs::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
