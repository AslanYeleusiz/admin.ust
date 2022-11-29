<?php

namespace App\Http\Controllers\Api\V1\Turnir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TurnirZhetekshi;
use App\Models\TurnirUser;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\V1\Turnir\TurnirZhetekshiRequest;
use Carbon\Carbon;


class TurnirZhetekshiController extends Controller
{


    public function store(TurnirZhetekshiRequest $request)
    {
        $user = Auth::guard('api')->user();
        $zhetekshi = TurnirZhetekshi::create([
            'zhetekshi_name' => $request->zhetekshi_name,
            'update_count' => 1,
            'user_id' => $user->id,
            'turnir_id' => $request->turnir_id,
            'date' => Carbon::now(),
        ]);
        $tusers = TurnirUser::where('user_id', $user->id)->where('turnir_id', $request->turnir_id)->whereNull('zh_name')->update([
            'zh_name' => $zhetekshi->zhetekshi_name
        ]);
        return response()->json(['zhetekshi' => $zhetekshi]);
    }


    public function update(TurnirZhetekshiRequest $request, $id)
    {
        $zhetekshi = TurnirZhetekshi::findOrFail($id)->update([
            'zhetekshi_name' => $request->zhetekshi_name,
            'update_count' => 0,
        ]);
        return response()->json(['zhetekshi' => $zhetekshi]);
    }

}
