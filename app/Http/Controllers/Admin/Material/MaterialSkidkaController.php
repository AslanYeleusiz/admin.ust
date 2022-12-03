<?php

namespace App\Http\Controllers\Admin\Material;

use App\Http\Controllers\Controller;
use App\Models\MaterialSkidka;
use App\Models\Material;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use App\Helpers\Date;
use App\Http\Requests\Admin\Material\MaterialSkidkaRequest;
use Illuminate\Validation\ValidationException;

class MaterialSkidkaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $now = Carbon::now();
        $MaterialSkidka = MaterialSkidka::with('material')->orderByDesc('id')
            ->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));
        foreach($MaterialSkidka as $skidka){
            if($skidka->from_date >= $now && $now < $skidka->to_date)
                $skidka->is_active = 1;
            else $skidka->is_active = 0;
            $skidka->from_date = Date::dmYKZ($skidka->from_date);
            $skidka->to_date = Date::dmYKZ($skidka->to_date);
        }
        return Inertia::render('Admin/MaterialSkidka/Index', [
            'materialSkidka' => $MaterialSkidka
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/MaterialSkidka/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MaterialSkidkaRequest $request)
    {
        $doc_id = $request->doc_id;
        $doc_name = $request->doc_name;
        if(!$doc_id && !$doc_name)
            throw ValidationException::withMessages([
                'doc_id' => 'Материал ID немесе тақырып жолы толтырылуы керек.'
            ]);
        $material = Material::where(function($req) use ($doc_id, $doc_name){
            if($doc_id) return $req->where('id', $doc_id);
            else return $req->where('title', 'like', "%$doc_name%");
        })->first();

        MaterialSkidka::create([
            'doc_id' => $material->id,
            'skidka' => $request->skidka,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
        ]);
        return redirect()->route('admin.materialSkidka.index')->withSuccess('Успешно сохранено');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MaterialSkidka  $materialSkidka
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialSkidka $materialSkidka)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MaterialSkidka  $materialSkidka
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $materialSkidka = MaterialSkidka::findOrFail($id);
        return Inertia::render('Admin/MaterialSkidka/Edit', [
            'materialSkidka' => $materialSkidka
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaterialSkidka  $materialSkidka
     * @return \Illuminate\Http\Response
     */
    public function update(MaterialSkidkaRequest $request, $id )
    {

        MaterialSkidka::findOrFail($id)->update([
            'skidka' => $request->skidka,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
        ]);
        return redirect()->back()->withSuccess('Успешно сохранено');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaterialSkidka  $materialSkidka
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MaterialSkidka
        ::findOrFail($id)->delete();
        return redirect()->back()->withSuccess('Успешно удалено');

    }
}
