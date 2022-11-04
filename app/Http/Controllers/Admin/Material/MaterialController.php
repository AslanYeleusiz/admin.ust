<?php

namespace App\Http\Controllers\Admin\Material;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\MaterialClass;
use App\Models\MaterialSubject;
use App\Models\MaterialDirection;
use App\Services\FileService;
use App\Services\MaterialService;
use App\Http\Requests\Admin\Material\MaterialSaveRequest;
use Carbon\Carbon;
use Inertia\Inertia;

class MaterialController extends Controller
{
    public $materialService;
    public function __construct(MaterialService $materialService)
    {
        $this->materialService = $materialService;
    }

    public function index(Request $request)
    {
        $title = $request->title;
        $description = $request->description;
        $subject = $request->subject;
        $direction = $request->direction;
        $class = $request->class;
        $materials = Material::when($title, fn ($query) => $query->where('title', 'like', "%$title%"))
        ->when($description, fn ($query) => $query->where('description', 'like', "%$description%"))
        ->when($subject, fn ($query) => $query->where('zhanr', 'like', "%$subject%"))
        ->when($direction, fn ($query) => $query->where('zhanr2', $direction))
        ->when($class, fn ($query) => $query->where('zhanr3', $class))
        ->orderByDesc('id')
        ->with('user')
        ->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));
        $materialClasses = MaterialClass::get();
        $materialSubjects = MaterialSubject::get();
        $materialDirections = MaterialDirection::get();
        return Inertia::render('Admin/Materials/Index', [
            'materials' => $materials,
            'materialClasses' => $materialClasses,
            'materialSubjects' => $materialSubjects,
            'materialDirections' => $materialDirections,
        ]);
    }
    public function edit(Material $material)
    {
        $materialClasses = MaterialClass::get();
        $materialSubjects = MaterialSubject::get();
        $materialDirections = MaterialDirection::get();
        $material->load('user');
        return Inertia::render('Admin/Materials/Edit', [
            'material' => $material,
            'materialClasses' => $materialClasses,
            'materialSubjects' => $materialSubjects,
            'materialDirections' => $materialDirections,
        ]);
    }
    public function update(Material $material, MaterialSaveRequest $request)
    {
        $this->materialService->save($material, $request);
        return redirect()->back()->withSuccess('Успешно сохранено');
    }

    public function destroy(Material $material)
    {
        //file delete
        $material->delete();
        return redirect()->back()->withSuccess('Успешно удалено');
    }

    public function download($id)
    {
        $material=Material::findOrFail($id);
        return redirect()->back()->withSuccess('Успешно удалено');
    }


}
