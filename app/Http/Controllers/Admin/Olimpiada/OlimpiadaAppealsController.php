<?php

namespace App\Http\Controllers\Admin\Olimpiada;

use App\Http\Controllers\Controller;
use App\Models\OlimpiadaAppeals;
use App\Models\TestSuraktar;
use App\Models\TestZhauaptar;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OlimpiadaAppealsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $username = $request->username;
//        $surak = $request->surak;
        $variable = $request->variable;
        $text = $request->text;
        $is_checked = $request->is_checked;
        $appeals = OlimpiadaAppeals::with(['surak', 'user'])
            ->when($variable, fn($query) => $query->where('variable', 'like', "%$variable%"))
            ->when($text, fn($query) => $query->where('text', 'like', "%$text%"))
            ->when($is_checked != null, fn($query) => $query->where('is_checked', $is_checked))
            ->latest('id')
            ->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));
        return Inertia::render('Admin/OlimpiadaAppeals/Index', [
            'appeals' => $appeals,
            'appeal_types' => $appeals,
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
     * @param  \App\Models\OlimpiadaAppeals  $olimpiadaAppeals
     * @return \Illuminate\Http\Response
     */
    public function show(OlimpiadaAppeals $olimpiadaAppeals)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OlimpiadaAppeals  $olimpiadaAppeals
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $appeal = OlimpiadaAppeals::with('user')->findOrFail($id);
        $testSurak = TestSuraktar::with(['zhauap','bagyty','tury'])->findOrFail($appeal->surak_id);
        $zhauaptar = TestZhauaptar::where('surak_id', $appeal->surak_id)->get();
        foreach($zhauaptar as $key=>$zhauap){
            if($zhauap->zhauap_id == 1) $testSurak->correct_answer_number = $key;
        }
        return Inertia::render('Admin/OlimpiadaAppeals/Edit', [
            'surak' => $testSurak,
            'appeal' => $appeal,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OlimpiadaAppeals  $olimpiadaAppeals
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $olimpiadaAppeals = OlimpiadaAppeals::findOrFail($id);

        $testSurak = TestSuraktar::findOrFail($olimpiadaAppeals->surak_id);
        $testSurak->update([
            'surak' => $request->surak['surak'],
            'tusinik' => $request->surak['tusinik'] ?? " ",
        ]);
        $zhauaptar = $request->surak['zhauap'];
        foreach($zhauaptar as $key=>$zhauap){
            $zhauap_id = $key == $request->surak['correct_answer_number'] ? 1 : 0;
            TestZhauaptar::findOrFail($zhauap['id'])->update([
                'variant' => $zhauap['variant'],
                'zhauap_id' => $zhauap_id,
            ]);
        }
        $olimpiadaAppeals->update([
            'is_checked' => $request->appeal['is_checked']
        ]);
        return redirect()->back()->withSuccess('Успешно сохранено');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OlimpiadaAppeals  $olimpiadaAppeals
     * @return \Illuminate\Http\Response
     */
    public function destroy(OlimpiadaAppeals $olimpiadaAppeals)
    {
        //
    }
}
