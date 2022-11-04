<?php

namespace App\Http\Controllers\Admin\Turnir;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Turnir\TurnirAllQuestionsRequest;
use App\Models\TurnirQuestions;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TurnirAllQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $question = $request->questionName;
        $question_active = $request->question_active;
        $questions = TurnirQuestions::when($question, fn($query) => $query->where('question', 'like', "%$question%"))
            ->when($question_active != null, function($query) use ($question_active){
                return $query->where('question_active', $question_active);
            })
            ->with('turnir')
            ->has('turnir')
            ->latest('id')
            ->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));
        return Inertia::render('Admin/TurnirAllQuestions/Index', [
            'turnirQuestions' => $questions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TurnirQuestions  $turnirQuestions
     * @return \Illuminate\Http\Response
     */
    public function show(TurnirQuestions $turnirQuestions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TurnirQuestions  $turnirQuestions
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $turnirQuestion = TurnirQuestions::with('turnir')->findOrFail($id);
        return Inertia::render('Admin/TurnirAllQuestions/Edit', [
            'turnirQuestion' => $turnirQuestion
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TurnirQuestions  $turnirQuestions
     * @return \Illuminate\Http\Response
     */
    public function update(TurnirAllQuestionsRequest $request, $id)
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
    public function destroy($id)
    {
        $turnirQuestions = TurnirQuestions::findOrFail($id);
        $turnirQuestions->delete();
        return redirect()->back()->withSuccess('Успешно сохранено');
    }
}
