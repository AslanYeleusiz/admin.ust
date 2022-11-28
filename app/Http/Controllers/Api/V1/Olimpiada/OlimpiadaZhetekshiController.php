<?php

namespace App\Http\Controllers\Api\V1\Olimpiada;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Olimpiada\OlimpiadaUserRequest;
use App\Http\Requests\Api\V1\Olimpiada\OlimpiadaZhetekshiUpdateRequest;
use App\Models\OlimpiadaBagyty;
use App\Models\OlimpiadaTury;
use App\Models\OlimpiadaKatysu;
use App\Models\OlimpiadaTizim;
use App\Models\OlimpiadaZhetekshi;
use App\Http\Resources\V1\CustomerResource;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OlimpiadaZhetekshiController extends Controller
{
    public function create(OlimpiadaUserRequest $request) {
        $user = auth()->guard('api')->user();
        $now = Carbon::now();
        $zhetekshi = OlimpiadaZhetekshi::create([
            'user_id' => $user->id,
            'o_bagyty_idd' => $request->bagyt_id,
            'o_turnir_idd' => $now->format('n'),
            'name' => $request->name,
            'date' => $now
        ]);
        $o_users = OlimpiadaKatysu::where('user_id', $user->id)
            ->where('o_bagyty_idd', $request->bagyt_id)
            ->where('success', 1)
            ->get();
        foreach($o_users as $o_user) {
            $o_user->update([
                'o_zhetekshi_id' => $zhetekshi->id
            ]);
        }
        return CustomerResource::collection(['zhetekshi' => $zhetekshi])->additional(['status'=>true]);
    }

    public function update($id, OlimpiadaZhetekshiUpdateRequest $request) {
        $zhetekshi = OlimpiadaZhetekshi::findOrFail($id)->update([
            'name' => $request->name
        ]);
        return response()->json([
            'zhetekshi' => $zhetekshi,
            'status' => true
        ]);
    }

}
