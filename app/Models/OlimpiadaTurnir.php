<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OlimpiadaTurnir extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'o_turnir';
    protected $primaryKey = "idd";

    public static function getOblys($id){
        $obl[14] = 'Алматы облысы';
        $obl[0] = 'Ақмола облысы';
        $obl[1] = 'Ақмола облысы';
        $obl[2] = 'Ақтөбе облысы';
        $obl[3] = 'Атырау облысы';
        $obl[4] = 'Батыс Қазақстан облысы';
        $obl[5] = 'Жамбыл облысы';
        $obl[6] = 'Қарағанды облысы';
        $obl[7] = 'Қызылорда облысы';
        $obl[8] = 'Қостанай облысы';
        $obl[9] = 'Маңғыстау облысы';
        $obl[10] = 'Түркістан облысы';
        $obl[11] = 'Павлодар облысы';
        $obl[12] = 'Солтүстік Қазақстан облысы';
        $obl[13] = 'Шығыс Қазақстан облысы';
        return $obl[$id];
    }
}
