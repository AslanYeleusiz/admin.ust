<?php

namespace App\Http\Controllers\Api\V1\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Payment;
use App\Models\Kassa;
use App\Services\BonusService;
use Carbon\Carbon;

class PerevodHistoryController extends Controller
{
    private $bonusService;
    public function __construct(BonusService $bonusService)
    {
        $this->bonusService = $bonusService;
    }

    public function index(Request $request) {
        $user = Auth::guard('api')->user();

        $kassa = Kassa::findOrCreate(5);
        $kassa->user_id = $user->id;
        $kassa->save();

        $perevod_type = $request->perevod_type;

        if(!empty($request->get)) $getAll = $request->get;
        else $getAll = 5;


        $history = Payment::where('user_id', $user->id)
            ->whereNot('sum', 0)
            ->when($perevod_type, function($query) use ($perevod_type){
                if($perevod_type == 'balance') return $query->where('perevod_type', 1);
                if($perevod_type == 'bonus') return $query->where('perevod_type', 2);
            })
            ->when($getAll, function($query) use ($getAll){
                if($getAll == 5) {
                    return $query->take(5)->get();
                }else{
                    return $query->paginate(20);
                }
            });
        foreach ($history as $b) {
            $b->date = date('d.m.Y / H:i', $b->date);
        }
        return response()->json([
            'history' => $history
        ]);
    }

    public function store(Payment $bonus) {
        $user = Auth::guard('api')->user();
        if($user->bonus != 0){
            $bonus->create([
                'user_id' => $user->id,
                'plusOrMinus' => 0,
                'value' => $user->bonus,
                'perevod_type' => 2,
                'description_id' => 1,
            ]);
            $balance = $user->balance + $user->bonus;
            $user->update([
                'balance' => $balance,
                'bonus' => 0
            ]);
            return response()->json(['success' => 'Барлық бонустар қаражатқа сәтті аударылды.']);
        }
        return response()->json(['error' => 'Баланста қаражат жеткіліксіз']);
    }



}
