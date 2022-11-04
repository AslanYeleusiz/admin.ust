<?php

namespace App\Http\Controllers\Admin\Qmg;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Qmg\QmgSubjectSaveRequest;
use App\Models\QmgSubjects;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QmgSubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->name;
        $subjects = QmgSubjects::when($name, fn($query) => $query->where('name', 'like', "%$name%"))
            ->latest('id')
            ->get();
        return Inertia::render('Admin/QmgSubjects/Index', [
            'subjects' => $subjects
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/QmgSubjects/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QmgSubjectSaveRequest $request)
    {
        QmgSubjects::create([
            'name' => $request->name
        ]);
        return redirect()->route('admin.qmgSubjects.index')->withSuccess('Успешно сохранено');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QmgSubjects  $qmgSubjects
     * @return \Illuminate\Http\Response
     */
    public function show(QmgSubjects $qmgSubjects)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QmgSubjects  $qmgSubjects
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $qmgSubject = QmgSubjects::findOrFail($id);
        return Inertia::render('Admin/QmgSubjects/Edit', [
            'qmgSubject' => $qmgSubject
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QmgSubjects  $qmgSubjects
     * @return \Illuminate\Http\Response
     */
    public function update(QmgSubjectSaveRequest $request, $id)
    {
        QmgSubjects::findOrFail($id)->update([
            'name' => $request->name
        ]);
        return redirect()->back()->withSuccess('Успешно сохранено');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QmgSubjects  $qmgSubjects
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        QmgSubjects::findOrFail($id)->delete();
        return redirect()->back()->withSuccess('Успешно сохранено');
    }
}
