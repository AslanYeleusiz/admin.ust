<?php

namespace App\Http\Controllers\Admin\Material;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Material\MaterialSubjectSaveRequest;
use App\Models\MaterialSubject;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Inertia\Inertia;

class MaterialSubjectController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->name;
        $materialSubjects = MaterialSubject::when($name, fn ($query) => $query->where('name', 'like', "%$name%"))
        ->orderBy('name')
        ->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));
        return Inertia::render('Admin/MaterialSubjects/Index', [
            'materialSubjects' => $materialSubjects
        ]);
    }
    public function edit(MaterialSubject $subject)
    {
        return Inertia::render('Admin/MaterialSubjects/Edit', [
            'materialSubject' => $subject
        ]);
    }
    public function update(MaterialSubject $subject, MaterialSubjectSaveRequest $request)
    {
        $subject->name = $request->name;
        $subject->save();
        return redirect()->back()->withSuccess('Успешно сохранено');
    }

    public function create()
    {
        return Inertia::render('Admin/MaterialSubjects/Create');
    }

    public function store(MaterialSubjectSaveRequest $request)
    {
        MaterialSubject::create([
            'name' => $request->name,
            'lat_name' => Helper::translate($request->name)
        ]);
        return redirect()->route('admin.materialSubjects.index')->withSuccess('Успешно добавлено');
    }

    public function destroy(MaterialSubject $subject)
    {
        $subject->delete();
        return redirect()->back()->withSuccess('Успешно удалено');
    }
}
