<?php

namespace App\Http\Controllers\Admin\Material;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\MaterialClass;
use App\Models\MaterialDirection;
use App\Models\MaterialSubject;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DeletedMaterialController extends Controller
{
    public function index(Request $request)
    {
        $title = $request->title;

        $subject = $request->zhanr;
        $direction = $request->zhanr2;
        $class = $request->zhanr3;

        $author = $request->author;

        $status = $request->input('deleteorder', 'all');
        $deletedMaterials = Material::when($title, fn($query) => $query->where('title', 'like', "%$title%"))
        ->when($subject, fn($query) => $query->where('zhanr', 'like', "%$subject%"))
        ->when($direction, fn($query) => $query->where('zhanr2', 'like', "%$direction%"))
        ->when($class, fn($query) => $query->where('zhanr3', 'like', "%$class%"))
        ->when($author, fn($query) => $query->where('author', 'like', "%$author%"))
        ->where('deleteorder', '>', 0)
        ->when($status !== 'all', fn ($query) => $query->where('deleteorder', $status))
        ->with(['user'])
        ->latest('id')
        ->paginate($request->input('per_page', 20))
        ->appends($request->except('page'));

        $materialClasses =  MaterialClass::get();
        $materialSubjects = MaterialSubject::get();
        $materialDirections = MaterialDirection::get();
        return Inertia::render('Admin/DeletedMaterials/Index', [
            'deletedMaterials' => $deletedMaterials,
            'materialClasses' => $materialClasses,
            'materialSubjects' => $materialSubjects,
            'materialDirections' => $materialDirections,
        ]);
    }
    public function edit($id)
    {
        $material = Material::with('user')->findOrFail($id);
        return Inertia::render('Admin/DeletedMaterials/Edit', [
            'material' => $material,
        ]);
    }
    public function update($id, Request $request)
    {
        $material = Material::findOrFail($id);
        $material->update([
            'deleteorder' => $request->deleteorder ?? null
        ]);
        return redirect()->route('admin.deletedMaterials.index')->withSuccess('Успешно сохранено');
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->deleteorder = 0;
        $material->deleteordertext = null;
        $material->save();
        return redirect()->back()->withSuccess('Успешно удалено');
    }
}
