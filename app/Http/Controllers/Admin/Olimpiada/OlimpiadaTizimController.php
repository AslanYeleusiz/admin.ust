<?php

namespace App\Http\Controllers\Admin\Olimpiada;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Olimpiada\OlimpiadaTizimRequest;
use App\Models\OlimpiadaTizim;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OlimpiadaTizimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = $request->user_id;
        $katysushy_name = $request->katysushy_name;
        $code = $request->code;
        $obwcode = $request->obwcode;
        $olimpiadaTizim = OlimpiadaTizim::has('user')
            ->when($user_id, fn($query)=>$query->where('user_id',$user_id))
            ->when($katysushy_name, fn($query)=>$query->where('katysushy_name','like',"%$katysushy_name%"))
            ->when($code, fn($query)=>$query->where('code',$code))
            ->when($obwcode, fn($query)=>$query->where('obwcode',$obwcode))
            ->orderByDesc('id')
            ->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));
        return Inertia::render('Admin/OlimpiadaTizim/Index', [
            'olimpiadaTizims' => $olimpiadaTizim
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
     * @param  \App\Models\OlimpiadaTizim  $olimpiadaTizim
     * @return \Illuminate\Http\Response
     */
    public function show(OlimpiadaTizim $olimpiadaTizim)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OlimpiadaTizim  $olimpiadaTizim
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $olimpiadaTizim = OlimpiadaTizim::with(['user','katysushy.bagyty'])->findOrFail($id);
        return Inertia::render('Admin/OlimpiadaTizim/Edit', [
            'user' => $olimpiadaTizim
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OlimpiadaTizim  $olimpiadaTizim
     * @return \Illuminate\Http\Response
     */
    public function update(OlimpiadaTizimRequest $request, $id)
    {
        $olimpiadaTizim = OlimpiadaTizim
        ::findOrFail($id);
        $olimpiadaTizim->update([
            'katysushy_name' => $request->katysushy_name,
            'ozgertu_sany' => $request->ozgertu_sany,
            'katysushy_work' => $request->katysushy_work,
        ]);
        return redirect()->back()->withSuccess('Успешно сохранено');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OlimpiadaTizim  $olimpiadaTizim
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $olimpiadaTizim = OlimpiadaTizim
        ::findOrFail($id);
        $olimpiadaTizim->delete();
        return redirect()->back()->withSuccess('Успешно удалено');

    }
}
