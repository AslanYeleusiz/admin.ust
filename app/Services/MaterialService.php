<?php

namespace App\Services;

use App\Models\Material;
use Illuminate\Support\Facades\Storage;

class MaterialService
{
    public function handle($material, $request)
    {
        $material->title = $request->title;
        $material->description = $request->description;
        $material->zhanr = $request->zhanr;
        $material->zhanr2 = $request->zhanr2;
        $material->zhanr3 = $request->zhanr3;
        $material->date = $request->date;
        $material->view = $request->view;
        $material->download = $request->download;
        $material->author = $request->author;
        $material->work = $request->work;
        $material->sell = $request->sell;
        $material->likes = $request->likes;
        $material->dislikes = $request->dislikes;
        $material->zhinak = $request->zhinak;
        if($request->file()){
            $uploadedFile = $request->file('filename');
            $ext = $uploadedFile->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file_doc = 'materials/'.$ext.'/files/'.$filename;
            Storage::disk('public')->putFileAs(
                'materials/'.$ext.'/files/',
                $uploadedFile,
                $filename
            );
            $material->file_doc = $file_doc;
            $material->raw = $ext;
            $material->filename = $filename;
        }
        return $material;
    }

    public function save($material, $request)
    {

        $material = $this->handle($material, $request);
        return $material->save();
    }
}
