<?php

namespace App\Services\Admin;

use App\Models\OlimpiadaBagyty;
use App\Models\OlimpiadaTury;
use Carbon\Carbon;

class OlimpBagytService
{
    public function multisave($request)
    {
        $now = Carbon::now();
        $type_ids = $request->type_ids;
        $o_katysushy_idd = $request->o_katysushy_idd;
        $class_ids = $request->class_ids;
        $katysushilar = $this->katysushyText($request->o_katysushy_idd);
        foreach ($type_ids as $type_id) {
            $olimpBagyt = OlimpiadaBagyty::create([
                'o_katysushy_idd' => $o_katysushy_idd,
                'o_bagyty' => $request->o_bagyty,
                'o_turnir_idd' => $now->month,
                'bagyt' => $request->bagyt,
                'enable' => $request->enable,
                'katysushilar' => $katysushilar,
                'type' => $type_id,
            ]);
            if($o_katysushy_idd == 3 && !empty($class_ids)) {
                foreach ($class_ids as $class_id) {
                    $text = $this->fullTextGenerator($request->bagyt, $class_id);
                    OlimpiadaTury::create([
                        'o_katysushy_idd' => $o_katysushy_idd,
                        'o_turnir_idd' => $now->month,
                        'o_bagyty_idd' => $olimpBagyt->idd,
                        'o_tury' => $text,
                        'synyp' => $class_id,
                        'enable' => $request->enable,
                    ]);
                }
            }else{
                OlimpiadaTury::create([
                    'o_katysushy_idd' => $o_katysushy_idd,
                    'o_turnir_idd' => $now->month,
                    'o_bagyty_idd' => $olimpBagyt->idd,
                    'o_tury' => $request->o_bagyty,
                    'synyp' => '',
                    'enable' => $request->enable,
                ]);
            }
        }
    }

    public function multiupdate($request)
    {
        $idd = $request->idd;
        $o_bagyty = $request->o_bagyty;
        $bagyt = $request->bagyt;
        $enable = $request->enable;

        $olimpBagyty = OlimpiadaBagyty::findOrFail($idd)->update([
            'o_bagyty' => $o_bagyty,
            'bagyt' => $bagyt,
            'enable' => $enable,
        ]);
        $olimpTuri = OlimpiadaTury::where('o_bagyty_idd', $idd)->get();
        foreach($olimpTuri as $turi){
            if($turi->o_katysushy_idd == 3 && !empty($turi->synyp)){
                $text = $this->fullTextGenerator($bagyt, $turi->synyp);
                $turi->update([
                    'o_tury' => $text
                ]);
            }else{
                $turi->update([
                    'o_tury' => $o_bagyty
                ]);
            }
        }
    }

    public function optionsSave($bagyt, $request)
    {
        $class_ids = $request->class_ids;
        foreach($class_ids as $class_id)
        {
            $text = $this->fullTextGenerator($bagyt->bagyt, $class_id);
            $tury = OlimpiadaTury::create([
                'o_katysushy_idd' => $bagyt->o_katysushy_idd,
                'o_turnir_idd' => $bagyt->o_turnir_idd,
                'o_bagyty_idd' => $bagyt->idd,
                'o_tury' => $text,
                'synyp' => $class_id,
                'enable' => $request->enable,
            ]);
        }
    }


    protected function katysushyText($id)
    {
        switch($id){
            case 1: return 'Ұстаз';
            case 2: return 'Студент';
            case 3: return 'Оқушы';
            case 4: return 'Тәрбиеші';
        }
    }

    protected function fullTextGenerator($bagyt, $class_id)
    {
        return $bagyt.' пәнінен '.$class_id.'-сынып оқушылар арасында олимпиада';
    }



}
