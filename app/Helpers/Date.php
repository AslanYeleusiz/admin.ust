<?php


namespace App\Helpers;


class Date
{

    public static function dmYKZ($date){
        $date = strtotime($date);
        $day = date('d',$date);
        $year = date('Y',$date);
        $month = date('m',$date);
        switch ($month){
            case 1:
                $month = 'Қаңтар';
                break;
            case 2:
                $month = 'Ақпан';
                break;
            case 3:
                $month = 'Наурыз';
                break;
            case 4:
                $month = 'Сәуір';
                break;
            case 5:
                $month = 'Мамыр';
                break;
            case 6:
                $month = 'Маусым';
                break;
            case 7:
                $month = 'Шілде';
                break;
            case 8:
                $month = 'Тамыз';
                break;
            case 9:
                $month = 'Қырқүйек';
                break;
            case 10:
                $month = 'Қазан';
                break;
            case 11:
                $month = 'Қараша';
                break;
            case 12:
                $month = 'Желтоқсан';
                break;
        }
        return "{$day} {$month} {$year}";
    }

    public static function monthKz($month): string
    {
        switch ($month){
            case 1:
                return 'Қаңтар';
            case 2:
                return 'Ақпан';
            case 3:
                return 'Наурыз';
            case 4:
                return 'Сәуір';
            case 5:
                return 'Мамыр';
            case 6:
                return 'Маусым';
            case 7:
                return 'Шілде';
            case 8:
                return 'Тамыз';
            case 9:
                return 'Қырқүйек';
            case 10:
                return 'Қазан';
            case 11:
                return 'Қараша';
            case 12:
                return 'Желтоқсан';
            default:
                return 'Қаңтар';
        }
    }
}
