<?php

namespace App\Services\Admin;

class TurnirService
{
    public function handle($turnir, $request)
    {
        $category = $request->category;

        $turnir->name = $request->name;
        $turnir->category = $category;
        $turnir->cat_name = $this->getCategory($category);
        $turnir->month = $request->month;
        if($request->active == true) $turnir->active = 1;
        else $turnir->active = 2;
        $turnir->price = $request->price;
        $turnir->old_price = $request->old_price;
        $turnir->rate = $request->rate;
        return $turnir;
    }

    public function save($turnir, $request)
    {

        $turnir = $this->handle($turnir, $request);
        return $turnir->save();
    }

    protected function getCategory($category){
        switch($category){
            case 1: return "Тәрбиешілерге";
            case 2: return "Ұстаздарға";
            case 3: return "Оқушыларға";
            case 4: return "Студенттерге";
            default: return "Анықталмаған";
        }
    }
}
