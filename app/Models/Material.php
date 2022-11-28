<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    const FILE_PATH = 'files/materials/';
    const CERTIFICATE_PATH = 'images/certificates/';
    protected $guarded = [];
    protected $table = 'doc';
    protected $attributes = [
        'ssilka_video' => '',
        'view' => 0,
        'download' => 0,
        'likes' => 0,
        'dislikes' => 0,
        'chec' => 0,
        'converted' => 0,
        'moved' => 0,
        'deleteorder' => 0,
    ];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function isPurchased()
    {
        return $this->hasOne(MaterialSolds::class, 'doc_id');
    }

    public function certificateThankLetter(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(MaterialCertificateThankLetter::class, 'material_id', 'id');
    }

    public function certificateHonor(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(MaterialCertificateHonor::class, 'material_id', 'id');
    }

    public function certificate(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(MaterialCertificate::class, 'material_id', 'id');
    }

    public function scopeNotDeletes($query)
    {
        return $query->where('deleteorder', '!=', 2);
    }

    public static function Translit($s)
    {
        $s = (string)$s; // преобразуем в строковое значение
        $s = strip_tags($s); // убираем HTML-теги
        $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
        $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
        $s = trim($s); // убираем пробелы в начале и конце строки
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
        $s = strtr($s, array('а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'j', 'з' => 'z', 'и' => 'i', 'й' => 'i', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'y', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 's', 'щ' => 'shch', 'ы' => 'y', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'ъ' => '', 'ь' => '', 'ә' => 'a', 'ғ' => 'g', 'қ' => 'q', 'ң' => 'ng', 'ө' => 'o', 'ұ' => 'u', 'ү' => 'u', 'һ' => 'x', 'і' => 'i', '+' => '+'));
        $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // очищаем строку от недопустимых символов
        $s = str_replace(" ", "_", $s); // заменяем пробелы знаком минус
        $s = str_replace("-", "_", $s); // заменяем пробелы знаком минус
        return $s; // возвращаем результат
    }


}
