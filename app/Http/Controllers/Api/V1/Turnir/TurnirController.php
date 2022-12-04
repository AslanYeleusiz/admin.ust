<?php

namespace App\Http\Controllers\Api\V1\Turnir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Turnirs;
use App\Models\TurnirUser;
use App\Models\TurnirZhetekshi;
use App\Models\Payment;
use App\Helpers\Helper;
use App\Helpers\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\V1\TurnirResource;
use App\Services\V1\Turnir\TurnirCertificateGenerateService;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class TurnirController extends Controller
{
    public $certificateService;
    public function __construct(TurnirCertificateGenerateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }

    public function index(Request $request) {
        $category = $request->category;
        $turnirs = Turnirs::select(['id','name'])->isActive()
            ->where('category', $category)
            ->get();
        $now = Carbon::now();
        $time = Carbon::parse($now)->diffInSeconds($now->endOfMonth());
        foreach($turnirs as $turnir){
            $turnir->lat_name = Helper::translate($turnir->name);
            $turnir->month = Date::monthKz($turnir->month+1);
        }
        return response()->json([
            'turnirs' => $turnirs,
            'time' => $time
        ]);
    }

    public function show($slug, $id) {
        $turnir_id = $id;
        $user = Auth::guard('api')->user();
        $turnir = Turnirs::findOrFail($turnir_id);
        $turnir->month = Date::monthKz($turnir->month+1);
        $turnir->cat_name = $this->cat_namer($turnir->category);
        $users = TurnirUser::where('user_id', $user->id)
            ->where('turnir_id', $turnir_id)
            ->get();
        $zhetekshi = TurnirZhetekshi::where('user_id', $user->id)
            ->where('turnir_id', $turnir_id)
            ->get();
        foreach($users as $user){
            $user['editUser'] = 0;
            $user['fio_ozgertu'] = $user['fio_user'];
            $user['loading'] = 0;
            $user['test_complete_date'] = date("d.m.Y/H:i",(mb_substr($user['order_id'], 0,-1)));
            if($user['go']) $user['diplom'] = $this->calculate($user['durys'],$user['kate']);
        }
        foreach($zhetekshi as $zhet){
            $zhet['editUser'] = 0;
            $zhet['fio_ozgertu'] = $zhet['zhetekshi_name'];
            $zhet['loading'] = 0;
        }
        return response()->json([
            'turnir' => $turnir,
            'turnir_users' => $users,
            'zhetekshi' => $zhetekshi
        ]);
    }

    public function my_turnirs() {
        $now = Carbon::now();
        $user = Auth::guard('api')->user();
        $muragat_count = TurnirUser::where('user_id',$user->id)->count();
        $tuser = TurnirUser::where('user_id',$user->id)
            ->where('date', '>=', $now->startOfMonth())
            ->orderByDesc('date')
            ->with('turnir')
            ->get();

        foreach($tuser as $t){
            $t->turnir->month = $now->format('m');
            $t->turnir->month_name = Date::monthKz($t->turnir->month);
            $t->turnir->cat_name = $this->cat_namer($t->turnir->category);
            $t->turnir->year = $now->year;
            $t->turnir->month_end = $now->endOfMonth()->format('d');
            $t->turnir->day_is_left = $now->diffInDays();
            $t->turnir->lat_name = Helper::translate($t->turnir->name);
        };

        return response()->json([
            'tuser' => $tuser,
            'muragat_count' => $muragat_count,
            'thisYear' => $now->format('Y'),
        ]);
    }

    public function muragat(Request $request) {
        $user = Auth::guard('api')->user();
        $tuser = TurnirUser::with('turnir')->where('user_id',$user->id)
            ->whereYear('date', '=', $request->year)
            ->get();
        $zhetekshi = TurnirZhetekshi::where('user_id',$user->id)
            ->whereYear('date', '=', $request->year)
            ->get();

        foreach($tuser as $t){
            $t->month = date('n', strtotime($t->date));
            if($t['go']) $t['diplom'] = $this->calculate($t['durys'],$t['kate']);
            $t->lat_name = Helper::translate($t->turnir_name);
            $t->edit = 0;
            $t->loading = 0;
        };
        foreach($zhetekshi as $t){
            $t->month = date('n', strtotime($t->date));
        };


        return response()->json([
            'tuser' => $tuser,
            'zhetekshi' => $zhetekshi
        ]);
    }

    public function getCertificate($id) {

        $turuser = TurnirUser::findOrFail($id);
        if(!$turuser->success)
            throw ValidationException::withMessages([
                'not_purchased' => __('errors.not_purchased')
            ]);
        $diplom_type = $this->calculate($turuser['durys'],$turuser['kate']);
        if($diplom_type < 4) $certificateName = $this->certificateService->getDiplom($id, $diplom_type);
        else $certificateName = $this->certificateService->getSertificate($id);
        return response()->download(Storage::disk('public')->path(TurnirUser::CERTIFICATE_PATH)."/".$certificateName);
    }

    public function oplataCertificate($id) {
        $user = Auth::guard('api')->user();
        $turuser = TurnirUser::findOrFail($id);
        if(!$turuser->success){
            if($user->balance >= $turuser->price){
                $user->balance -= $turuser->price;
                $user->save();
                $turuser->success = 1;
                $turuser->save();
                Payment::create([
                    'user_id' => $user->id,
                    'date' => time(),
                    'sum' => $turuser->price,
                    'perevod_type' => 1,
                    'type' => 'Турнирге төлем жасалынды',
                    'kaldy' => $user->balance,
                    'minus' => 1,
                ]);
                return response()->json([
                    'success' => true,
                    'balance' => $user->balance,
                ]);
            }
            throw ValidationException::withMessages([
                'no_balance' => __('errors.no_balance')
            ]);
        }
        return response()->json([
            'success' => true,
            'balance' => $user->balance,
        ]);
    }

    public function thankLetter($id) {
        $zhetekshi = TurnirZhetekshi::findOrFail($id);
        $tusers = TurnirUser::where('user_id', $zhetekshi->user_id)->where('turnir_id', $zhetekshi->turnir_id)->where('zh_name', 'like', "%$zhetekshi->zhetekshi_name%")->first();
        $certificateName = $this->certificateService->getAlgys($tusers->id);
        return response()->download(Storage::disk('public')->path(TurnirUser::CERTIFICATE_PATH)."/".$certificateName);
    }

    protected function calculate($durys, $kate) {
        if($durys >= 9) return 1;
        else if($durys >= 7) return 2;
        else if($durys >= 5) return 3;
        else return 4;
    }

    protected function cat_namer($category) {
        switch($category) {
            case 1: return 'тәрбиешілер';
            case 2: return 'ұстаздар';
            case 3: return 'оқушылар';
            case 4: return 'студенттер';
        };
    }


}
