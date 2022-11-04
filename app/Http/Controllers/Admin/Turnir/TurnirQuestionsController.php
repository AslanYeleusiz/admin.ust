<?php

namespace App\Http\Controllers\Admin\Turnir;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Turnir\TurnirAllQuestionsRequest;
use App\Models\TurnirQuestions;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TurnirQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $question = $request->questionName;
        $question_active = $request->question_active;
        $questions = TurnirQuestions::when($question, fn($query) => $query->where('question', 'like', "%$question%"))
            ->when($question_active != null, function($query) use ($question_active){
                return $query->where('question_active', $question_active);
            })
            ->latest('id')
            ->where('turnir_id', $id)
            ->get();
        return Inertia::render('Admin/TurnirQuestions/Index', [
            'turnirQuestions' => $questions,
            'turnir_id' => $id,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return Inertia::render('Admin/TurnirQuestions/Create', [
            'turnir_id' => $id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TurnirQuestions  $turnirQuestions
     * @return \Illuminate\Http\Response
     */
    public function store(TurnirAllQuestionsRequest $request, $turnir_id)
    {
        TurnirQuestions::create([
            'answer1' => $request->answer1,
            'answer2' => $request->answer2,
            'answer3' => $request->answer3,
            'answer4' => $request->answer4,
            'correct_answer' => $request->correct_answer,
            'question' => $request->question,
            'turnir_id' => $turnir_id,
            'question_active' => $request->question_active
        ]);
        return redirect()->route('admin.turnirQuestions.index', $turnir_id)->withSuccess('Успешно сохранено');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TurnirQuestions  $turnirQuestions
     * @return \Illuminate\Http\Response
     */
    public function edit($turnir, $id)
    {
        $questions = TurnirQuestions::findOrFail($id);
        return Inertia::render('Admin/TurnirQuestions/Edit', [
            'turnirQuestion' => $questions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TurnirQuestions  $turnirQuestions
     * @return \Illuminate\Http\Response
     */
    public function update(TurnirAllQuestionsRequest $request, $turnir, $id)
    {
        $turnirQuestions = TurnirQuestions::findOrFail($id);
        $turnirQuestions->update([
            'answer1' => $request->answer1,
            'answer2' => $request->answer2,
            'answer3' => $request->answer3,
            'answer4' => $request->answer4,
            'correct_answer' => $request->correct_answer,
            'question' => $request->question,
            'question_active' => $request->question_active
        ]);
        return redirect()->back()->withSuccess('Успешно сохранено!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TurnirQuestions  $turnirQuestions
     * @return \Illuminate\Http\Response
     */
    public function destroy($turnir, $id)
    {
        $turnirQuestions = TurnirQuestions::findOrFail($id);
        $turnirQuestions->delete();
        return redirect()->back()->withSuccess('Успешно удалено');
    }
}
