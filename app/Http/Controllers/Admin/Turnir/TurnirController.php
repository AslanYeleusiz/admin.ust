<?php

namespace App\Http\Controllers\Admin\Turnir;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Turnir\TurnirSaveRequest;
use App\Models\Turnirs;
use App\Models\Month;
use App\Services\Admin\TurnirService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TurnirController extends Controller
{
    public $turnirService;
    public function __construct(TurnirService $turnirService){
        $this->turnirService = $turnirService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->name;
        $category = $request->category;
        $price = $request->price;
        $old_price = $request->old_price;
        $active = $request->active;

        $turnirs = Turnirs::when($name, fn($query) => $query->where('name', 'like', "%$name%"))
            ->when($category, fn($query) => $query->where('category', $category))
            ->when($price, fn($query) => $query->where('price', $price))
            ->when($old_price, fn($query) => $query->where('old_price', $old_price))
            ->when($active != null, fn($query) => $query->where('active', $active))
            ->withCount('questions')
            ->latest('id')
            ->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));
        return Inertia::render('Admin/Turnir/Index', [
            'turnirs' => $turnirs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $month = Month::get();
        return Inertia::render('Admin/Turnir/Create', [
            'month' => $month
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TurnirSaveRequest $request)
    {
        $turnir = new Turnirs();
        $this->turnirService->save($turnir, $request);
        return redirect()->route('admin.turnir.index')->withSuccess('Успешно сохранено');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Turnirs  $turnirs
     * @return \Illuminate\Http\Response
     */
    public function show(Turnirs $turnirs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Turnirs  $turnirs
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $turnir = Turnirs::findOrFail($id);
        $month = Month::get();
        return Inertia::render('Admin/Turnir/Edit', [
            'turnir' => $turnir,
            'month' => $month
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Turnirs  $turnirs
     * @return \Illuminate\Http\Response
     */
    public function update(TurnirSaveRequest $request, $id)
    {
        $turnir = Turnirs::findOrFail($id);
        $this->turnirService->save($turnir, $request);
        return redirect()->back()->withSuccess('Успешно сохранено');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Turnirs  $turnirs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $turnir = Turnirs::findOrFail($id);
        $turnir->delete();
        return redirect()->back()->withSuccess('Успешно удалено');
    }
}
