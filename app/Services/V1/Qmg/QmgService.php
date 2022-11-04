<?php

namespace App\Services\V1\Qmg;

use Illuminate\Support\Facades\Auth;
use App\Models\QmgOrders;
use Carbon\Carbon;

/**
 * Class QmgService.
 */
class QmgService
{
    public function handle($qmgOrder, $qmg, $bolimOrder)
    {
        $now = Carbon::now();
        $user = Auth::guard('api')->user();
        $qmgOrder->user_id = $user->id;
        $qmgOrder->sub_id = $qmg->sub_id;
        $qmgOrder->bolim_id = $qmg->bolim_id;
        $qmgOrder->toqsan = $qmg->toksan;
        $qmgOrder->synyp = $qmg->synyp;
        $qmgOrder->type = $qmg->type;
        $qmgOrder->lang = $qmg->lang;
        $qmgOrder->order_id = $bolimOrder->order_id;
        $qmgOrder->success = 1;
        $qmgOrder->date = $now;
        return $qmgOrder;
    }

    public function save($qmgOrder, $qmg, $bolimOrder)
    {
        $qmgOrder = $this->handle($qmgOrder, $qmg, $bolimOrder);
        return $qmgOrder->save();
    }
}
