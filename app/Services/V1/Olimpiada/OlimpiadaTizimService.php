<?php

namespace App\Services\V1\Olimpiada;

use Illuminate\Support\Facades\Auth;
use App\Models\OlimpiadaKatysu;
use App\Models\OlimpiadaTury;
use Carbon\Carbon;
/**
 * Class OlimpiadaTizimService.
 */
class OlimpiadaTizimService
{
    public function handle($tizim, $katysushy, $request)
    {
        $user = Auth::guard('api')->user();
        $now = Carbon::now();

        $tizim->user_id = $user->id;
        $tizim->katysushy_nomeri = $request->nomer;
        $tizim->katysushy_name = $katysushy->o_katysushy_fio;
        $tizim->obwcode = $katysushy->obwcode;
        $tizim->ozgertu_sany = 3;
        $tizim->o_order_id = $katysushy->o_order_id;
//        $tizim->date = $now;

        return $tizim;
    }

    public function save($tizim, $katysushy, $request)
    {
        $tizim = $this->handle($tizim, $katysushy, $request);
        return $tizim->save();
    }
}
