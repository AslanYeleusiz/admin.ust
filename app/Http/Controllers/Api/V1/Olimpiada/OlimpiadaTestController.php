<?php

namespace App\Http\Controllers\Api\V1\Olimpiada;

use App\Http\Controllers\Controller;
use App\Models\TestSuraktar;
use App\Models\TestZhauaptar;
use App\Models\TestSaves;
use App\Models\OlimpiadaBagyty;
use App\Models\OlimpiadaTury;
use App\Models\OlimpiadaKatysu;
use App\Models\OlimpiadaTizim;
use App\Models\OlimpiadaAppeals;
use App\Http\Resources\V1\MessageResource;
use App\Http\Resources\V1\CustomerResource;
use App\Http\Resources\V1\FailMessageResource;
use App\Http\Requests\Api\V1\Olimpiada\OlimpiadaAppealsRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OlimpiadaTestController extends Controller
{
    public function test_load(Request $request){
        $katysushy = OlimpiadaKatysu::where('obwcode', $request->code)->with(['o_tury', 'o_tizim'])->first();
        if(!empty($katysushy)){
            if($katysushy->success != null){
                if($katysushy->bari_tapsirdy != 1) {
                    $now = Carbon::now();
                    $date = Carbon::parse($katysushy->o_tizim->date)->addHour();
                    if($katysushy->o_tizim->date == null) {
                        $suraktar = TestSuraktar::where('sinip_id', $katysushy->o_tury_idd)
                            ->with('zhauap')
                            ->get();
                        $randSuraktar = collect($suraktar)->random(20)->all();

                        foreach($suraktar as $surak) {
                            $surak['my_answer'] = 0;
                        };
                        return CustomerResource::collection([$randSuraktar, $katysushy])->additional(['status' => true]);

                    } else if($date >= $now) {
                        //continue
                        $suraktar = TestSaves::where('user_code', $katysushy->o_tizim->code)->orderByDesc('id')->with('surak.zhauap')->get();

                        $current_date = strtotime($date) - strtotime($now);

                        return CustomerResource::collection([$suraktar, $katysushy])->additional(['status' => 'continue', 'date' => $current_date]);

                    } else {
                        $katysushy->update([
                            'bari_tapsirdy' => 1
                        ]);
                        $this->finish($katysushy->idd);
                        return new FailMessageResource(__('validation.code.used'));
                    }
                }
                return new FailMessageResource(__('validation.code.used'));
            }
            return new FailMessageResource(__('validation.code.no_success'));
        }
        return new FailMessageResource(__('validation.code.not_found'));
    }

    public function test_start(Request $request){
        $now = Carbon::now();
        $katysushy = OlimpiadaTizim::where('o_order_id', $request->o_order_id)
            ->firstOrFail();
        $katysushy->update([
            'date' => $now
        ]);
        if(!empty($request->suraktar)){
            foreach($request->suraktar as $surak){
                TestSaves::create([
                    'user_code' => $katysushy->code,
                    'surak_id' => $surak['id'],
                    'surak' => $surak['surak'],
                    'zhauap_id' => 0,
                    'les_id' => $surak['les_id'],
                    'class_id' => $surak['sinip_id'],
                ]);
            }
        }
        return CustomerResource::collection(['katysushy' => $katysushy])->additional(['status'=>true]);
    }

    public function save_answer(Request $request){
        TestSaves::where('user_code',$request->user_code)->where('surak_id', $request->surak_id)->firstOrFail()->update([
            'zhauap_id' => $request->zhauap_id
        ]);

        return new MessageResource(__('validation.code.used'));
    }

    public function test_finish(Request $request){
        return $this->finish($request->id);
    }

    public function appeals_create(OlimpiadaAppealsRequest $request) {
        $user = auth()->guard('api')->user();
        OlimpiadaAppeals::create([
            'user_id' => $user->id,
            'les_id' => $request->surak['les_id'],
            'class_id' => $request->surak['sinip_id'],
            'user_code' => $request->code,
            'surak_id' => $request->surak['id'],
            'variable' => $request->variable,
            'text' => $request->text,
        ]);
        return new MessageResource('true');
    }

    protected function finish($id){
        $katysushy = OlimpiadaKatysu::findOrFail($id);

        $katysushy->update([
            'bari_tapsirdy' => 1,
        ]);
        $tizimdiki = OlimpiadaTizim::where('o_order_id', $katysushy->o_order_id)->firstOrFail();
        $tests = TestSaves::where('user_code', $tizimdiki->code)->with('zhauap')->get();
        $ball = 0;
//        return CustomerResource::collection($tests)->additional(['status' => 'result']);
        foreach($tests as $test){
            if(!empty($test->zhauap)){
                if($test['zhauap']->zhauap_id == 1){
                    $ball++;
                }
            }
        }
        $tizimdiki->update([
            'tapsyrgan' => 1,
            'result' => $ball,
        ]);

        $katysushy->load(['o_tizim', 'o_tury', 'o_bagyt']);
        $katysushy['o_tizim']->date = Carbon::parse($katysushy['o_tizim']->date)->format('d.m.Y/H:i');

        return CustomerResource::collection(['o_katysu' => $katysushy])->additional(['status' => 'result']);

    }

    public function katemen_zhumys(Request $request) {
        $test = TestSaves::where('user_code', $request->user_code)->with('surak.zhauap', 'zhauap')->get();
        return CustomerResource::collection(['test'=>$test])->additional(['status' => true]);
    }
}
