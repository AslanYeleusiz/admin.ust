<?php

namespace App\Http\Controllers\Api\V1\Turnir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TurnirQuestions;
use App\Models\TurnirUser;

class TurnirTestController extends Controller
{
    public function index($slug, $id) {
        $questions = TurnirQuestions::where('turnir_id', $id)
            ->orderBy('question_number')
            ->get();
        return response()->json([
            'questions' => $questions
        ]);
    }

    public function store(Request $request) {
        $tuser = TurnirUser::findOrFail($request->id_user);
        if($tuser->chance >= 1)  $tuser->decrement('chance');
        if($tuser->durys < $request->durys){
            $tuser->update([
                'durys' => $request->durys,
                'kate' => $request->kate,
                'go' => 1,
                'order_id' => time().rand(1,9),
            ]);
        };
        return response()->json([
            'status' => 200
        ]);

    }

}
