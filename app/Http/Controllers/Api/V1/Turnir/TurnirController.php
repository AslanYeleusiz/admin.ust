<?php

namespace App\Http\Controllers\Api\V1\Turnir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Turnirs;
use App\Models\TurnirUser;
use App\Models\TurnirZhetekshi;
use App\Helpers\Helper;
use App\Helpers\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\V1\TurnirResource;

class TurnirController extends Controller
{
    public function index(Request $request) {
        $category = $request->category;
        $turnirs = Turnirs::isActive()
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
        $tuser = TurnirUser::where('user_id',$user->id)
            ->whereYear('date', '=', $request->year)
            ->get();
        $zhetekshi = TurnirZhetekshi::where('user_id',$user->id)
            ->whereYear('date', '=', $request->year)
            ->get();

        foreach($tuser as $t){
            $t->month = date('n', strtotime($t->date));
        };
        foreach($zhetekshi as $t){
            $t->month = date('n', strtotime($t->date));
        };


        return response()->json([
            'tuser' => $tuser,
            'zhetekshi' => $zhetekshi
        ]);
    }

    protected function calculate($durys, $kate) {
        if($durys/($durys+$kate) >= 0.9) return 1;
        else if($durys/($durys+$kate) >= 0.7) return 2;
        else return 3;
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
