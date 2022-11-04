<?php

namespace App\Services;

/**
 * Class BonusService.
 */
class BonusService
{
    public function getTypeAndDate($bonus) {
        foreach ($bonus as $b) {
            $b->perevod_text = $this->getTypeText($b->description_id);
            $b->date = $b->created_at->format('d.m.Y / H:i');
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
