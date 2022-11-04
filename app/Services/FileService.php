<?php
namespace App\Services;

use App\Models\Material;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService

{
    public static function deleteFile($name, $path)
    {
        if ($name && Storage::disk('public')->exists($path . '/' . $name)) {
            Storage::disk('public')->delete($path. '/' . $name);
        }
        return null;
    }


    public static function saveFile($file, $path, $oldFileName = null)
    {
        if ($oldFileName) {
            self::deleteFile($oldFileName, $path);
        }
        $fileName = time() . "_" . Str::random(5) .'.' . $file->getClientOriginalExtension();
        Storage::disk('public')->putFileAs($path, $file, $fileName);
        return $fileName;
    }

    public static function generateMaterialPath()
    {
        $date = now();
        return Material::FILE_PATH . now()->format('Y')
        .'/'. $date->format('m') . '/';
    }
}