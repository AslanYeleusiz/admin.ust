<?php

namespace App\Http\Controllers\Admin\Qmg;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Qmg\QmgBolimSaveRequest;
use App\Models\QmgBolim;
use App\Models\QmgSubjects;
use Illuminate\Http\Request;
use App\Services\Admin\QmgBolimService;
use App\Services\FileService;
use Inertia\Inertia;

class QmgBolimController extends Controller
{
    public $qmgService;
    public function __construct(QmgBolimService $qmgService)
    {
        $this->qmgService = $qmgService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = $request->title;
        $date = $request->date;
        $synyp_text = $request->synyp_text;
        $sub_id = $request->sub_id;
        $bolimder = QmgBolim::isEnabled()
            ->when($title, fn($query) => $query->where('title', 'like', "%$title%"))
            ->when($date, fn($query) => $query->where('date', 'like', "%$date%"))
            ->when($synyp_text, fn($query) => $query->where('synyp_text', 'like', "%$synyp_text%"))
            ->when($sub_id, fn($query) => $query->where('sub_id', $sub_id))
            ->with('subject')
            ->latest('id')
            ->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));
        $subjects = QmgSubjects::get();
        return Inertia::render('Admin/QmgBolim/Index', [
            'bolimder' => $bolimder,
            'subjects' => $subjects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = QmgSubjects::get();
        return Inertia::render('Admin/QmgBolim/Create', [
            'subjects' => $subjects,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QmgBolimSaveRequest $request)
    {
        $qmgBolid = new QmgBolim();
        $this->qmgService->save($qmgBolid, $request);
        return redirect()->route('admin.qmgBolim.index')->withSuccess('Успешно сохранено');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QmgBolim  $qmgBolim
     * @return \Illuminate\Http\Response
     */
    public function show(QmgBolim $qmgBolim)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QmgBolim  $qmgBolim
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $qmgBolim = QmgBolim::findOrFail($id);
        $subjects = QmgSubjects::get();
        return Inertia::render('Admin/QmgBolim/Edit', [
            'subjects' => $subjects,
            'qmgBolim' => $qmgBolim,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QmgBolim  $qmgBolim
     * @return \Illuminate\Http\Response
     */
    public function update(QmgBolimSaveRequest $request, $id)
    {
        $qmgBolim = QmgBolim::findOrFail($id);
        $this->qmgService->save($qmgBolim, $request);
        return redirect()->back()->withSuccess('Успешно сохранено');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QmgBolim  $qmgBolim
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $qmgBolim = QmgBolim::findOrFail($id);
        if(!empty($qmgBolim->path))
            FileService::deleteFile($qmgBolim->path, '');
        if(!empty($qmgBolim->doc))
            FileService::deleteFile($qmgBolim->doc, '');
        $qmgBolim->delete();
        return redirect()->back()->withSuccess('Успешно удален');
    }
}
