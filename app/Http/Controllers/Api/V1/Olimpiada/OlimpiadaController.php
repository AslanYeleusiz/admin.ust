<?php

namespace App\Http\Controllers\Api\V1\Olimpiada;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OlimpiadaBagyty;
use App\Models\OlimpiadaTury;
use App\Models\OlimpiadaKatysu;
use App\Models\OlimpiadaTizim;
use App\Models\OlimpiadaZhetekshi;
use App\Models\perevodHistory;
use App\Services\V1\Olimpiada\OlimpiadaTizimService;
use App\Services\V1\Olimpiada\OlimpCertGenerateService;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Helper;
use App\Helpers\Date;
use Carbon\Carbon;

class OlimpiadaController extends Controller
{
    public $tizimService;
    public $certificateService;
    public function __construct(OlimpiadaTizimService $tizimService, OlimpCertGenerateService $certificateService)
    {
        $this->tizimService = $tizimService;
        $this->certificateService = $certificateService;
    }

    public function index(Request $request) {
        $now = Carbon::now();
        $katysushy_id = $request->katysushy_id;
        $turnir_id = $now->format('n');
        $type = $request->type;
        $time = Carbon::parse($now)->diffInSeconds($now->endOfMonth());
        $month = Date::monthKz($now->format('n'));
        $olimps = OlimpiadaBagyty::IsEnabled()
            ->where('type', $type)
            ->where('o_katysushy_idd', $katysushy_id)
            ->get(['idd', 'o_bagyty', 'o_katysushy_idd']);
        foreach($olimps as $olimp){
            $olimp->lat_name = Helper::translate($olimp->o_bagyty);
        }
        return response()->json([
            'olimps' => $olimps,
            'time' => $time,
            'month' => $month,
        ]);
    }

    public function qatysushylar($slug, $id) {
        $user = auth()->guard('api')->user();
        $now = Carbon::now();
        $bagyt = OlimpiadaBagyty::where('idd', $id)->first();
        $katysushylar = OlimpiadaKatysu::where('user_id',$user->id)
            ->where('o_bagyty_idd', $id)
            ->where('o_turnir_idd', $now->format('m'))
            ->whereYear('o_date', $now->format('Y'))
            ->with(['o_tury', 'o_tizim', 'o_bagyt'])
            ->get();
        foreach($katysushylar as $katysushy){
            $katysushy['edit'] = 0;
            $katysushy['loading'] = 0;
            $katysushy['error'] = null;
            if($katysushy['o_tizim'] != null)
                $katysushy['o_tizim']->date = Carbon::parse($katysushy['o_tizim']->date)->format('d.m.Y/H:i');
        };
        $classes = OlimpiadaTury::select('synyp')->where('o_bagyty_idd', $id)->get();
        $class_collect = collect($classes)->sortBy('synyp')->pluck('synyp');

        $zhetekshiler = OlimpiadaZhetekshi::where('user_id', $user->id)
            ->where('o_bagyty_idd', $id)
            ->where('o_turnir_idd', $now->format('m'))
            ->whereYear('date', $now->format('Y'))
            ->get();

        foreach($zhetekshiler as $zhetekshi){
            $zhetekshi['edit'] = 0;
            $zhetekshi['loading'] = 0;
            $zhetekshi['error'] = null;
        };

        return response()->json([
            'o_users' => $katysushylar,
            'bagyt' => $bagyt,
            'classes' => $class_collect,
            'zhetekshiler' => $zhetekshiler
        ]);

    }

    public function tolem_zhasau(Request $request) {
        $user = auth()->guard('api')->user();
        $katysushy = OlimpiadaKatysu::where('user_id',$user->id)->findOrFail($request->id);
        if($user->balance >= $katysushy->price || $user->admin){
            if(!$user->admin){
                $user->decrement('balance', $katysushy->price);
                perevodHistory::create([
                    'user_id' => $user->id,
                    'plusOrMinus' => 0,
                    'value' => $katysushy->price,
                    'perevod_type' => 1,
                    'description_id' => 4,
                ]);
            }

            $tizim = new OlimpiadaTizim();
            $this->tizimService->save($tizim, $katysushy, $request);

            $tizim->update([
                'code' => $tizim->id . rand(10,99)
            ]);

            $katysushy->update([
                'success' => 1
            ]);

            $o_tizim = OlimpiadaTizim::findOrFail($tizim->id);

            return response()->json([
                'success' => true,
                'balance' => $user->balance,
                'o_tizim' => $o_tizim
            ]);
        }



        return response()->json([
            'success' => false,
            'balance' => $user->balance
        ]);
    }

    public function my_olimps() {
        $now = Carbon::now();
        $user = auth()->guard('api')->user();
        $muragat_count = OlimpiadaTizim::where('user_id',$user->id)->count();
        $tuser = OlimpiadaTizim::where('user_id',$user->id)
            ->where(function($query) use ($now){
                $query->where('date', null)
                    ->orWhere('date', '>=', $now->startOfMonth());
            })
            ->orderByDesc('date')
            ->with('katysushy.o_bagyt')
            ->get();
        $month = Date::monthKz($now->format('n'));

        foreach($tuser as $t){
            $t->katysushy->o_bagyt->month = $now->format('m');
            $t->katysushy->o_bagyt->month_name = Date::monthKz($t->katysushy->o_bagyt->o_turnir_idd);
            $t->katysushy->o_bagyt->cat_name = $this->cat_namer($t->katysushy->o_katysushy_idd);
            $t->katysushy->o_bagyt->year = $now->year;
            $t->katysushy->o_bagyt->month_end = $now->endOfMonth()->format('d');
            $t->katysushy->o_bagyt->day_is_left = $now->diffInDays();
            $t->katysushy->o_bagyt->lat_name = Helper::translate($t->katysushy->o_bagyt->o_bagyty);
        };

        return response()->json([
            'tuser' => $tuser,
            'muragat_count' => $muragat_count,
            'thisYear' => $now->format('Y'),
            'thisMonth' => $month,
        ]);
    }

    public function muragat(Request $request) {
        $user = auth()->guard('api')->user();
        $tuser = OlimpiadaKatysu::where('user_id',$user->id)
            ->whereYear('o_date', '=', $request->year)
            ->where('success', 1)
            ->with(['o_tury', 'o_tizim', 'o_bagyt'])
            ->get();
//        $zhetekshi = TurnirZhetekshi::where('user_id',$user->id)
//            ->whereYear('date', '=', $request->year)
//            ->get();

        foreach($tuser as $t){
            $t->month = $t->o_turnir_idd;
            $t->loading = 0;
            $t->edit = 0;
            if($t['o_tizim'] != null)
                $t['o_tizim']->date = Carbon::parse($t['o_tizim']->date)->format('d.m.Y/H:i');
        };
//        foreach($zhetekshi as $t){
//            $t->month = date('n', strtotime($t->date));
//        };


        return response()->json([
            'tuser' => $tuser,
//            'zhetekshi' => $zhetekshi
        ]);
    }

    public function getCertificate($id) {
        $o_katysu = OlimpiadaKatysu::with('o_tizim')->findOrFail($id);

        $diplom_type = $this->calculate($o_katysu->o_tizim['result']);
        if($diplom_type != 4)
            $certificateName = $this->certificateService->getDiplom($o_katysu->o_tizim['code'], $diplom_type);
        else $certificateName = $this->certificateService->getSertificate($o_katysu->o_tizim['code']);
        return response()->download(Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$certificateName);
    }

    public function thankLetter($id) {
        $katysushy = OlimpiadaZhetekshi::with('o_katysu')->findOrFail($id);
        $order = $katysushy->o_katysu->o_order_id;
        $o_tizim = OlimpiadaTizim::where('o_order_id', $order)->first();
        $certificateName = $this->certificateService->getAlgys($order, 1, $o_tizim->code);
        return response()->download(Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$certificateName);

    }

    protected function cat_namer($category) {
        switch($category) {
            case 1: return 'тәрбиешілер';
            case 2: return 'ұстаздар';
            case 3: return 'оқушылар';
            case 4: return 'студенттер';
        };
    }

    protected function calculate($durys) {
        if($durys >= 19) return 1;
        else if($durys >= 16) return 2;
        else if($durys >= 13) return 3;
        else return 4;
    }

}
