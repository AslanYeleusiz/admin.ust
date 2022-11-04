<?php

namespace App\Services\V1\Turnir;

use Illuminate\Support\Facades\Auth;
use App\Models\TurnirUser;
use App\Models\Turnirs;
use Carbon\Carbon;

class TurnirUserService
{

    public function handle($tuser, $request)
    {
        $turnir = Turnirs::findOrFail($request->turnir_id);
        $tuser->user_id = Auth::guard('api')->user()->id;
        $tuser->fio_user = $request->fio_user;
        $tuser->turnir_id = $request->turnir_id;
        $tuser->turnir_name = $request->turnir_name;
        $tuser->price = $turnir->price;
        $tuser->order_id = time().rand(1,9);
        $tuser->date = Carbon::now()->format('Ymd');
        $tuser->date_end = Carbon::now()->addDays(20)->format('Ymd');
        return $tuser;
    }

    public function save($tuser, $request)
    {

        $tuser = $this->handle($tuser, $request);
        return $tuser->save();
    }
}
