<?php

namespace App\Services;

/**
 * Class BonusService.
 */
class BonusService
{
    public function getTypeAndDate($bonus) {
        foreach ($bonus as $b) {
            $b->date = $b->date->format('d.m.Y / H:i');
        }
        return $bonus;
    }


    protected function getTypeText($id) {
        switch($id) {
            case 1: return 'Балансқа аударылды';
            case 2: return 'Банк картасы арқылы шығарылды';
            case 3: return 'Банк картасы арқылы толтырылды';
            case 4: return 'Олимпиадаға қатысты';
        };
    }

}
