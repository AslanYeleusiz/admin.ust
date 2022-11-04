<?php

namespace App\Http\Controllers\Api\V1\Olimpiada;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Olimpiada\OlimpiadaUserRequest;
use App\Models\OlimpiadaBagyty;
use App\Models\OlimpiadaTury;
use App\Models\OlimpiadaKatysu;
use App\Models\OlimpiadaTizim;
use App\Services\V1\Olimpiada\OlimpiadaKatysuService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OlimpiadaUserController extends Controller
{
    public $olimpService;
    public function __construct(OlimpiadaKatysuService $olimpService)
    {
        $this->olimpService = $olimpService;
    }
    //
    public function create(OlimpiadaUserRequest $request) {

        $katysushy = new OlimpiadaKatysu();
        $this->olimpService->save($katysushy, $request);
        $katysushy['edit'] = 0;
        $katysushy['loading'] = 0;
        $katysushy['error'] = null;
        $katysushy->load('o_tury');
        return response()->json([
            'success' => true,
            'katysushy' => $katysushy,
        ]);
    }

    public function update(OlimpiadaUserRequest $request) {
        $katysushy = OlimpiadaKatysu::findOrFail($request->id);
        if($katysushy->update_count >= 1) {
            $katysushy->update([
                'o_katysushy_fio' => $request->name
            ]);
            $katysushy->decrement('update_count');
            if(!empty($request->synyp)){
                $turi = OlimpiadaTury::where('o_bagyty_idd', $katysushy->o_bagyty_idd)
                    ->where('synyp', $request->synyp)->firstOrFail();
                $katysushy->update([
                    'o_tury_idd' => $turi->idd
                ]);
            }
            return response()->json([
                'success' => true
            ]);
        }
        return response()->json([
            'success' => false
        ]);

    }

    public function destroy($id) {
        $katysushy = OlimpiadaKatysu::findOrFail($id);
        if(!$katysushy->success){
            $tizim = OlimpiadaTizim::where('o_order_id', $katysushy->o_order_id)->first();
            if(empty($tizim)){
                $katysushy->delete();
                return response()->json([
                    'success' => true
                ]);
            }
        }
        return response()->json([
            'success' => false
        ]);
    }

}
