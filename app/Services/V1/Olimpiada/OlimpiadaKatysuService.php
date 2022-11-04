<?php

namespace App\Services\V1\Olimpiada;

use Illuminate\Support\Facades\Auth;
use App\Models\OlimpiadaKatysu;
use App\Models\OlimpiadaTury;
use Carbon\Carbon;
/**
 * Class OlimpiadaKatysuService.
 */
class OlimpiadaKatysuService
{
    public function handle($katysushy, $request)
    {
        $user = Auth::guard('api')->user();
        $now = Carbon::now();
        $class = $request->class;
        $katysushy->o_katysushy_idd = $request->katysushy_id;
        $katysushy->o_turnir_idd = $now->format('n');
        $katysushy->o_bagyty_idd = $request->bagyt_id;
        $o_tury = OlimpiadaTury::where('o_bagyty_idd',$request->bagyt_id)
            ->orderByDesc('idd')
            ->when($class, function($query) use ($class) {
                if(!empty($class)){
                    return $query->where('synyp', $class);
                }else{
                    return;
                }
            })->firstOrFail();

        $katysushy->o_tury_idd = $o_tury->idd;
        $katysushy->o_katysushy_fio = $request->name;
        $katysushy->user_id = $user->id;
        $katysushy->o_date = $now->format('Y-m-d');
        $katysushy->o_sany = 1;
        $katysushy->o_order_id = strtotime($now).''.rand(0,9);
        $katysushy->obwcode = ($katysushy->o_order_id + $user->id).rand(0,9);
        $katysushy->price = 500 + 200*($request->type_id - 1);
        $katysushy->success = null;
        $katysushy->update_count = 3;
        $katysushy->o_oblis = $request->type_id;
        $katysushy->o_skidka = ($katysushy->price/10);
        $katysushy->oblysy = 0;
        return $katysushy;
    }

    public function save($katysushy, $request)
    {
        $katysushy = $this->handle($katysushy, $request);
        return $katysushy->save();
    }
}
