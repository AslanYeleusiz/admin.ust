<?php

namespace App\Http\Controllers\Admin\Material;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialZhinak;
use App\Models\Month;
use Inertia\Inertia;

class MaterialZhinakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id   = $request->user_id;
        $doc_name  = $request->doc_name;
        $username  = $request->username;
        $zhmonth   = $request->zhmonth;
        $zhyear   = $request->zhyear;
        $step   = $request->step;

        $materials = MaterialZhinak::select(['id', 'doc_name', 'username', 'zhmonth', 'zhyear', 'step','user_id'])
            ->when($user_id, fn($query) => $query->where('user_id', $user_id))
            ->when($doc_name, fn($query) => $query->where('doc_name', 'like', "%$doc_name%"))
            ->when($username, fn($query) => $query->where('username', 'like', "%$username%"))
            ->when($zhmonth, fn($query) => $query->where('zhmonth', $zhmonth))
            ->when($zhyear, fn($query) => $query->where('zhyear', $zhyear))
            ->when($step, fn($query) => $query->where('step', $step))
            ->with('user')
            ->latest('id')
            ->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));
        $months = Month::get();
        return Inertia::render('Admin/MaterialZhinak/Index', [
            'materials' => $materials,
            'months' => $months,
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $material = MaterialZhinak::with(['user', 'material'])->findOrFail($id);
        return Inertia::render('Admin/MaterialZhinak/Edit', [
            'material' => $material
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $material = MaterialZhinak::findOrFail($id);
        $material->update([
            'step' => $request->step,
            'error' => $request->error,
        ]);
        return redirect()->back()->withSuccess('Успешно сохранено');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MaterialZhinak::findOrFail($id)->delete();
        return redirect()->back()->withSuccess('Успешно сохранено');
    }
}
