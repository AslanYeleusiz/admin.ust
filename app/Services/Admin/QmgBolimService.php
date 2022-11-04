<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Storage;
use App\Services\FileService;
use App\Models\QmgBolim;

class QmgBolimService
{
    public function handle($qmgBolim, $request)
    {
        $qmgBolim->title = $request->title;
        $qmgBolim->date = $request->date;
        $qmgBolim->synyp_text = $request->synyp_text;
        $qmgBolim->sub_id = $request->sub_id;
        if(!empty($request->video))
            $qmgBolim->video = $request->video;

        if(!empty($request->newPath)){
            $file_path = FileService::saveFile($request->newPath, QmgBolim::IMAGE_PATH);
            $qmgBolim->path = QmgBolim::IMAGE_PATH.''.$file_path;
        }else $qmgBolim->path = $request->path;
        if(!empty($request->newDoc)){
            $file_path = FileService::saveFile($request->newDoc, QmgBolim::DOC_PATH);
            $qmgBolim->doc = QmgBolim::DOC_PATH.''.$file_path;
        }else $qmgBolim->doc = $request->doc;
        return $qmgBolim;
    }

    public function save($qmgBolim, $request)
    {

        $qmgBolim = $this->handle($qmgBolim, $request);
        return $qmgBolim->save();
    }
}
