<?php


namespace App\Helpers;


class Helper
{

    public static function translate($s)
    {
        $s = (string)$s; // преобразуем в строковое значение
        $s = strip_tags($s); // убираем HTML-теги
        $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
        $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
        $s = trim($s); // убираем пробелы в начале и конце строки
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
        $s = strtr($s, array(
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'e',
            'ж' => 'j',
            'з' => 'z',
            'и' => 'i',
            'й' => 'i',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'y',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'c',
            'ч' => 'ch',
            'ш' => 's',
            'щ' => 'shch',
            'ы' => 'y',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
            'ъ' => '',
            'ь' => '',
            'ә' => 'a',
            'ғ' => 'g',
            'қ' => 'q',
            'ң' => 'ng',
            'ө' => 'o',
            'ұ' => 'u',
            'ү' => 'u',
            'һ' => 'x',
            'і' => 'i',
            '+' => '+'
        ));
        $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // очищаем строку от недопустимых символов
        $s = str_replace(" ", "_", $s); // заменяем пробелы знаком минус
        $s = str_replace("-", "_", $s); // заменяем пробелы знаком минус
        return $s; // возвращаем результат
    }


    public static function generatePassword($length): string
    {
        $array = [
            'a',
            'b',
            'c',
            'd',
            'e',
            'f',
            'g',
            'h',
            'i',
            'j',
            'k',
            'l',
            'm',
            'n',
            'o',
            'p',
            'r',
            's',
            't',
            'u',
            'v',
            'x',
            'y',
            'z',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            '0'
        ];
        // Генерируем пароль
        $password = "";
        for ($i = 0; $i < $length; $i++) {
            // Вычисляем случайный индекс массива
            $index = rand(0, count($array) - 1);
            $password .= $array[$index];
        }
        return $password;
    }

    public static function bonusPercentageAddingBalance($money)
    {
        $percent = 0;
        switch ($money) {
            case (1 <= $money && $money <= 999):
                $percent = 0.01;
                return $percent;
            case (1000 <= $money && $money <= 1999):
                $percent = 0.1;
                return $percent;
            case (2000 <= $money && $money <= 4999):
                $percent = 0.15;
                return $percent;
            case (5000 <= $money && $money <= 9999):
                $percent = 0.2;
                return $percent;
            case (10000 <= $money && $money <= 19999):
                $percent = 0.25;
                return $percent;
            case (20000 <= $money && $money <= 29999):
                $percent = 0.3;
                return $percent;
            case (30000 <= $money && $money <= 49999):
                $percent = 0.4;
                return $percent;
            case (50000 <= $money):
                $percent = 0.5;
                return $percent;
        }
    }

    public static function getRole($roleId)
    {
        switch ($roleId) {
            case 3:
                $role = 'teacher';
                break;
            case 4:
                $role = 'student';
                break;
            case 5:
                $role = 'school_child';
                break;
            default:
                $role = 'teacher';
        }
        return $role;
    }

    public static function webinarPaySum($participants = 1)
    {
        $participants = intval($participants);
        $discountPercent = 0;

        if ($participants < 5)
            $price = 3000;
        else
            $price = 2000;
        if ($participants >= 2 && $participants < 7) {
            $discountPercent = 0.2;
        } else if ($participants >= 7 && $participants < 16) {
            $discountPercent = 0.25;
        } else if ($participants >= 16) {
            $discountPercent = 0.3;
        }
        $price    = $participants * $price;
        $discount = $price * $discountPercent;

        return intval($price - $discount) ;
    }

    public static function competitionPaySum($price, $participants = 1): int
    {
        $participants = intval($participants);
        $discountPercent = 0;

        if ($participants >= 2 && $participants < 7) {
            $discountPercent = 0.2;
        } else if ($participants >= 7 && $participants < 16) {
            $discountPercent = 0.25;
        } else if ($participants >= 16) {
            $discountPercent = 0.3;
        }
        $price    = $participants * $price;
        $discount = $price * $discountPercent;

        return intval($price - $discount) ;
    }

    public static function olympiadPaySum($price, $participants = 1): array
    {
        $participants = intval($participants);
        $discountPercent = 0;

        if ($participants >= 2 && $participants <= 10) {
            $discountPercent = 0.1;
        } else if ($participants >= 11 && $participants <= 19) {
            $discountPercent = 0.15;
        } else if ($participants >= 20) {
            $discountPercent = 0.2;
        }
        $price    = $participants * $price;
        $discount = $price * $discountPercent;

        $sum = intval($price - $discount);

        return compact('sum', 'discount') ;
    }

    public static function getBonusForTwentiethOrder($participants, $userCompetitionCnt): int
    {
        $bonus = 0;
        $floorParti = floor($participants/20);
        if ($floorParti > 0) {
           $bonus = 1000 * $floorParti;
        }
        $residual = $participants % 20;
        $floorUserCompetitionCnt = floor($userCompetitionCnt/20);
        $floorCompetitionBonus   = floor(($userCompetitionCnt + $residual) / 20);

        if ($floorCompetitionBonus > $floorUserCompetitionCnt) {
            $bonus = $bonus + 1000 * ($floorCompetitionBonus - $floorUserCompetitionCnt);
        }
        return $bonus;
    }
}
