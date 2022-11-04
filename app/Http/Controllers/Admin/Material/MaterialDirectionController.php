<?php

namespace App\Http\Controllers\Admin\Material;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Material\MaterialDirectionSaveRequest;
use App\Models\MaterialDirection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MaterialDirectionController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->name;
        $materialDirections = MaterialDirection::when($name, fn ($query) => $query->where('name', 'like', "%$name%"))
        ->orderBy('name')
        ->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));
        return Inertia::render('Admin/MaterialDirections/Index', [
            'materialDirections' => $materialDirections
        ]);
    }
    public function edit(MaterialDirection $direction)
    {
        return Inertia::render('Admin/MaterialDirections/Edit', [
            'materialDirection' => $direction
        ]);
    }
    public function update(MaterialDirection $direction, MaterialDirectionSaveRequest $request)
    {
        $direction->name = $request->name;
        $direction->save();
        return redirect()->back()->withSuccess('Успешно сохранено');
    }

    public function create()
    {
        return Inertia::render('Admin/MaterialDirections/Create');
    }

    public function store(MaterialDirectionSaveRequest $request)
    {
        $materialDirection = new MaterialDirection();
        $materialDirection->name = $request->name;
        $materialDirection->lat_name = Helper::translate($request->name);
        $materialDirection->save();

        return redirect()->route('admin.materialDirections.index')->withSuccess('Успешно добавлено');
    }

    public function destroy(MaterialDirection $direction)
    {
        $direction->delete();
        return redirect()->back()->withSuccess('Успешно удалено');
    }
}
