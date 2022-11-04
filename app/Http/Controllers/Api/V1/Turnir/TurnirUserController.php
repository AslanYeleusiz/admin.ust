<?php

namespace App\Http\Controllers\Api\V1\Turnir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TurnirUser;
use App\Services\V1\Turnir\TurnirUserService;
use App\Http\Requests\Api\V1\Turnir\TurnirUserRequest;

class TurnirUserController extends Controller
{
    public $tuserService;
    public function __construct(TurnirUserService $tuserService)
    {
        $this->tuserService = $tuserService;
    }

    public function store(TurnirUserRequest $request)
    {
        $tuser = new TurnirUser();
        $this->tuserService->save($tuser, $request);
        return response()->json([
            'turnir_user' => $tuser,
            'status' => 200
        ]);
    }

    public function update(TurnirUserRequest $request, $id)
    {
        $tuser = TurnirUser::findOrFail($id);
        $tuser->update([
            'fio_user' => $request->fio_user,
            'update_count' => 0,
        ]);
        return response()->json([
            'turnir_user' => $tuser,
            'status' => 200
        ]);
    }

    public function destroy($id)
    {
        $tuser = TurnirUser::findOrFail($id);
        $tuser->delete();
        return response()->json(['status'=>200]);
    }
}
