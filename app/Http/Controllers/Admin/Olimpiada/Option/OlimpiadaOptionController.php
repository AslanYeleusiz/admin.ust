<?php

namespace App\Http\Controllers\Admin\Olimpiada\Option;

use App\Http\Controllers\Controller;
use App\Models\OlimpiadaTury;
use App\Models\OlimpiadaBagyty;
use App\Models\ClassList;
use App\Services\Admin\OlimpBagytService;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Olimpiada\OlimpiadaOptionRequest;
use App\Http\Requests\Admin\Olimpiada\OlimpiadaOptionSaveRequest;
use Inertia\Inertia;

class OlimpiadaOptionController extends Controller
{
    public $olimpBagytService;
    public function __construct(OlimpBagytService $olimpBagytService)
    {
        $this->olimpBagytService = $olimpBagytService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $option = $request->option;
        $options = OlimpiadaTury::where('o_bagyty_idd', $id)
            ->when($option, fn($query)=>$query->where('o_tury', 'like', "%$option%"))
            ->withCount('suraktar')
            ->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));
        $bagyt = OlimpiadaBagyty::findOrFail($id);
        return Inertia::render('Admin/OlimpBagyty/Options/Index', [
            'bagyt' => $bagyt,
            'options' => $options,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $classList = ClassList::get();
        return Inertia::render('Admin/OlimpBagyty/Options/Create', [
            'classItems' => $classList
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OlimpiadaOptionRequest $request, $id)
    {
        $bagyt = OlimpiadaBagyty
        ::findOrFail($id);
        $this->olimpBagytService->optionsSave($bagyt, $request);
        return redirect()->route('admin.olimpiadaOption.index', $id)->withSuccess('Успешно сохранено');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OlimpiadaTury  $olimpiadaTury
     * @return \Illuminate\Http\Response
     */
    public function show(OlimpiadaTury $olimpiadaTury)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OlimpiadaTury  $olimpiadaTury
     * @return \Illuminate\Http\Response
     */
    public function edit($bagyt_id, $id)
    {
        $olimpiadaTury = OlimpiadaTury
        ::findOrFail($id);
        return Inertia::render('Admin/OlimpBagyty/Options/Edit', [
            'option' => $olimpiadaTury
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OlimpiadaTury  $olimpiadaTury
     * @return \Illuminate\Http\Response
     */
    public function update(OlimpiadaOptionSaveRequest $request,$bagyt_id, $id)
    {
        $olimpiadaTury = OlimpiadaTury
        ::findOrFail($id);
        $olimpiadaTury->update([
            'o_tury' => $request->o_tury
        ]);
        return redirect()->back()->withSuccess('Успешно сохранено');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OlimpiadaTury  $olimpiadaTury
     * @return \Illuminate\Http\Response
     */
    public function destroy($bagyt_id, $id)
    {
        $olimpiadaTury = OlimpiadaTury
        ::findOrFail($id);
        $olimpiadaTury->delete();
        return redirect()->back()->withSuccess('Успешно удалено');

    }
}
