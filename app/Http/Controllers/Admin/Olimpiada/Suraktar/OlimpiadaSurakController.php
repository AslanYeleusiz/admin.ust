<?php

namespace App\Http\Controllers\Admin\Olimpiada\Suraktar;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Olimpiada\OlimpiadaOptionQuestionSaveRequest;
use App\Models\TestSuraktar;
use App\Models\TestZhauaptar;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OlimpiadaSurakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $bagyt_id, $o_tury_id)
    {
        $surak = $request->surak;
        $suraktar = TestSuraktar::where('les_id', $bagyt_id)
            ->where('sinip_id', $o_tury_id)
            ->latest('id')
            ->when($surak, fn($query)=>$query->where('surak','like', "%$surak%"))
            ->get();
        return Inertia::render('Admin/OlimpBagyty/Suraktar/Index', [
            'suraktar' => $suraktar
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/OlimpBagyty/Suraktar/Create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OlimpiadaOptionQuestionSaveRequest $request, $bagyt_id, $option_id)
    {
        $surak = TestSuraktar::create([
            'surak' => $request->surak,
            'les_id' => $bagyt_id,
            'sinip_id' => $option_id,
            'archive' => $request->archive,
            'tusinik' => $request->tusinik ?? " ",
        ]);
        $zhauaptar = $request->zhauap;
        foreach ($zhauaptar as $key=>$zhauap) {
            $zhauap_id = $key == $request->correct_answer_number ? 1 : 0;
            TestZhauaptar::create([
                'variant' => $zhauap['variant'],
                'surak_id' => $surak->id,
                'zhauap_id' => $zhauap_id,
            ]);
        }
        return redirect()->route('admin.olimpiadaSuraktar.index', [$bagyt_id, $option_id])->withSuccess('Успешно сохранено');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TestSuraktar  $testSuraktar
     * @return \Illuminate\Http\Response
     */
    public function show(TestSuraktar $testSuraktar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TestSuraktar  $testSuraktar
     * @return \Illuminate\Http\Response
     */
    public function edit($bagyt_id, $option_id, $id)
    {
        $testSurak = TestSuraktar
        ::with('zhauap')->findOrFail($id);
        $zhauaptar = TestZhauaptar::where('surak_id', $id)->get();
        foreach($zhauaptar as $key=>$zhauap){
            if($zhauap->zhauap_id == 1) $testSurak->correct_answer_number = $key;
        }
        return Inertia::render('Admin/OlimpBagyty/Suraktar/Edit', [
            'surak' => $testSurak
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TestSuraktar  $testSuraktar
     * @return \Illuminate\Http\Response
     */
    public function update(OlimpiadaOptionQuestionSaveRequest $request, $bagyt_id, $option_id, $id)
    {
        $testSurak = TestSuraktar::findOrFail($id);
        $testSurak->update([
            'surak' => $request->surak,
            'tusinik' => $request->tusinik ?? " ",
        ]);
        $zhauaptar = $request->zhauap;
        foreach($zhauaptar as $key=>$zhauap){
            $zhauap_id = $key == $request->correct_answer_number ? 1 : 0;
            TestZhauaptar::findOrFail($zhauap['id'])->update([
                'variant' => $zhauap['variant'],
                'zhauap_id' => $zhauap_id,
            ]);
        }
        return redirect()->back()->withSuccess('Успешно сохранено');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TestSuraktar  $testSuraktar
     * @return \Illuminate\Http\Response
     */
    public function destroy($bagyt_id, $option_id, $id)
    {
        $testSuraktar = TestSuraktar
        ::findOrFail($id);
        TestZhauaptar::where('surak_id', $id)->delete();
        $testSuraktar->delete();

        return redirect()->back()->withSuccess('Успешно удалено');

    }
}
