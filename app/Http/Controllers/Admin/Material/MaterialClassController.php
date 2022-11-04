<?php

namespace App\Http\Controllers\Admin\Material;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Material\MaterialClassSaveRequest;
use App\Models\MaterialClass;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MaterialClassController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->name;
        $materialClasses = MaterialClass::when($name, fn ($query) => $query->where('name', 'like', "%$name%"))
        ->orderBy('name')
        ->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));
        return Inertia::render('Admin/MaterialClasses/Index', [
            'materialClasses' => $materialClasses
        ]);
    }
    public function edit(MaterialClass $class)
    {
        return Inertia::render('Admin/MaterialClasses/Edit', [
            'materialClass' => $class
        ]);
    }

    public function update(MaterialClass $class, MaterialClassSaveRequest $request)
    {
        $class->name = $request->name;
        $class->save();
        return redirect()->back()->withSuccess('Успешно сохранено');
    }

    public function create()
    {
        return Inertia::render('Admin/MaterialClasses/Create');
    }

    public function store(MaterialClassSaveRequest $request)
    {
        MaterialClass::create([
            'name' => $request->name,
            'lat_name' => Helper::translate($request->name)
        ]);
        return redirect()->route('admin.materialClasses.index')->withSuccess('Успешно добавлено');
    }

    public function destroy(MaterialClass $class)
    {
        $class->delete();
        return redirect()->back()->withSuccess('Успешно удалено');
    }
}
