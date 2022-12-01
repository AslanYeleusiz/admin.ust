<?php

namespace App\Services\V1\Material;

use Illuminate\Support\Facades\Storage;
use App\Models\Material;
use App\Models\Marapattau;

class MaterialCertificateGenerateService
{
    public static function getDate($date){
        $m = date('m', strtotime($date));
        if($m == 1) $month = 'қаңтар';else
        if($m == 2) $month = 'ақпан';else
        if($m == 3) $month = 'наурыз';else
        if($m == 4) $month = 'сәуір';else
        if($m == 5) $month = 'мамыр';else
        if($m == 6) $month = 'маусым';else
        if($m == 7) $month = 'шілде';else
        if($m == 8) $month = 'тамыз';else
        if($m == 9) $month = 'қыркүйек';else
        if($m == 10) $month = 'қазан';else
        if($m == 11) $month = 'қараша';else
        if($m == 12) $month = 'желтоқсан';

        $data = date('d', strtotime($date)).' '.$month.', '.date('Y', strtotime($date)).' жыл';
        return $data;
    }
    public static function getSertificate($id, $certtype){

        $doc = Material::findOrFail($id);

        $translit = Material::Translit($doc->title);

        $dir_cert_path = public_path(Material::CERTIFICATE_PATH);
        $font_dir = public_path('/fonts');

        $date = self::getDate($doc->date);
        $kol = 1;
        $c = 0;
        $id = $doc->id;
        if(strlen($id) < 6){
            for ($i = 0; $i < 5 - strlen($id); $i++) {
                $c .= '0';
            }
            $id = $c.$id;
        }
        $id = 'MS-'.$id;
        $number = '№'.$id;
        $img_name = 'S'.$doc->user_id.time().".jpg";
        $username = $doc->author;

        $font_calibri_reg = $font_dir.'/calibri/Calibri.ttf';
        $font_calibri_bold = $font_dir.'/calibri/calibrib.ttf';
        $font_cambria_bold = $font_dir.'/cambria/cambriab.ttf';
        $font_cambria_reg = $font_dir.'/cambria/cambria.ttc';
        $font_source_reg = $font_dir.'/sourcesans/sourcereg.otf';
        $font_source_bold = $font_dir.'/sourcesans/sourcebold.otf';
        $font_source_light = $font_dir.'/sourcesans/sourcelight.otf';
        $font_times_roman = $font_dir.'/times-new-roman.ttf';
        $font_arial_reg = $font_dir.'/calibri/arial.ttf';
        $font_arial_bold = $font_dir.'/calibri/arialbd.ttf';
        $font_verdana_reg = $font_dir.'/verdana/verdana.ttf';
        $font_palatino_bold = $font_dir.'/palatino/palab.ttf';
        $font_gilreg = $font_dir.'/Gilroy/Gilroy-Regular.ttf';
        $font_assylbek = $font_dir.'/assylbek/Asylbekm02shelley.Kz.ttf';

        $width = 2480;
        $center = 1240;
        $margin = 300;


        if($certtype == 1){
            $img = $dir_cert_path."/materials/cer1.jpg";
            $pic = ImageCreateFromjpeg($img);
            $c_name = ImageColorAllocate($pic, 206, 79, 1);
            $c_num = ImageColorAllocate($pic, 7, 7, 7);

            $h_num = 1384;
            $h_usname = 1698;
            $h_date = 2280;
        }else
        if($certtype == 2){
            $img = $dir_cert_path."/materials/cer2.jpg";
            $pic = ImageCreateFromjpeg($img);
            $c_name = ImageColorAllocate($pic, 221, 185, 1);
            $c_num = ImageColorAllocate($pic, 255, 255, 255);

            $h_num = 936;
            $h_usname = 1520;
            $h_date = 2164;
        }else
        if($certtype == 3){
            $img = $dir_cert_path."/materials/cer3.jpg";
            $pic = ImageCreateFromjpeg($img);
            $c_num = ImageColorAllocate($pic, 7, 7, 7);
            $c_name = ImageColorAllocate($pic, 221, 185, 1);

            $h_num = 1308;
            $h_usname = 1630;
            $h_date = 2268;
        }else{
            $img = $dir_cert_path."/materials/cer1.jpg";
            $pic = ImageCreateFromjpeg($img);
            $c_name = ImageColorAllocate($pic, 206, 79, 1);
            $c_num = ImageColorAllocate($pic, 7, 7, 7);

            $h_num = 1384;
            $h_usname = 1698;
            $h_date = 2280;
        }

        $c_black = ImageColorAllocate($pic, 7, 7, 7);
        $c_blue = ImageColorAllocate($pic, 40, 132, 170);

        $box = imagettfbbox(50.8, 0, $font_gilreg, $number);
        $left = $center-round(($box[2]-$box[0])/2);
        ImageTTFtext($pic, 50.8, 0, $left, $h_num, $c_num, $font_gilreg, $number);

        $box = imagettfbbox(116.3, 0, $font_assylbek, $username);
        $left = $center-round(($box[2]-$box[0])/2);
        ImageTTFtext($pic, 116.3, 0, $left, $h_usname, $c_name, $font_assylbek, $username);

        $box = imagettfbbox(46.16, 0, $font_gilreg, $date);
        $left = $center-round(($box[2]-$box[0])/2);
        ImageTTFtext($pic, 46.16, 0, $left, $h_date, $c_black, $font_gilreg, $date);

        if (!Storage::disk('public')->exists(Material::CERTIFICATE_PATH)) {
            Storage::disk('public')->makeDirectory(Material::CERTIFICATE_PATH);
        }
        Imagejpeg($pic,Storage::disk('public')->path(Material::CERTIFICATE_PATH)."/".$img_name);
//        ImageDestroy($pic);
        return $img_name;
    }
    public static function getAlgys($id, $certtype){

        $doc = Material::findOrFail($id);

        $translit = Material::Translit($doc->title);

        $dir_cert_path = public_path(Material::CERTIFICATE_PATH);
        $font_dir = public_path('/fonts');

        $date = self::getDate($doc->date);

        $kol = 1;
        $c = 0;
        $id = $doc->id;
        if(strlen($id) < 6){
            for ($i = 0; $i < 5 - strlen($id); $i++) {
                $c .= '0';
            }
            $id = $c.$id;
        }
        $id = 'MA-'.$id;
        $number = '№'.$id;
        $img_name = 'A'.$doc->user_id.time().".jpg";

        $username = $doc->author;

        $font_calibri_reg = $font_dir.'/calibri/Calibri.ttf';
        $font_calibri_bold = $font_dir.'/calibri/calibrib.ttf';
        $font_cambria_bold = $font_dir.'/cambria/cambriab.ttf';
        $font_cambria_reg = $font_dir.'/cambria/cambria.ttc';
        $font_source_reg = $font_dir.'/sourcesans/sourcereg.otf';
        $font_source_bold = $font_dir.'/sourcesans/sourcebold.otf';
        $font_source_light = $font_dir.'/sourcesans/sourcelight.otf';
        $font_times_roman = $font_dir.'/times-new-roman.ttf';
        $font_arial_reg = $font_dir.'/calibri/arial.ttf';
        $font_arial_bold = $font_dir.'/calibri/arialbd.ttf';
        $font_verdana_reg = $font_dir.'/verdana/verdana.ttf';
        $font_palatino_bold = $font_dir.'/palatino/palab.ttf';
        $font_gilreg = $font_dir.'/Gilroy/Gilroy-Regular.ttf';
        $font_assylbek = $font_dir.'/assylbek/Asylbekm02shelley.Kz.ttf';

        $width = 2480;
        $center = 1240;
        $margin = 300;

        if($certtype == 1){
            $img = $dir_cert_path."/materials/alg1.jpg";
            $pic = ImageCreateFromjpeg($img);
            $c_name = ImageColorAllocate($pic, 0, 0, 0);
            $c_num = ImageColorAllocate($pic, 7, 7, 7);
            $font_num = $font_times_roman;

            $h_num = 1512;
            $h_usname = 1804;
            $h_date = 2292;
        }else
        if($certtype == 2){
            $img = $dir_cert_path."/materials/alg2.jpg";
            $pic = ImageCreateFromjpeg($img);
            $c_name = ImageColorAllocate($pic, 0, 0, 0);
            $c_num = ImageColorAllocate($pic, 7, 7, 7);
            $font_num = $font_times_roman;

            $h_num = 1712;
            $h_usname = 1956;
            $h_date = 2556;
        }else
        if($certtype == 3){
            $img = $dir_cert_path."/materials/alg3.jpg";
            $pic = ImageCreateFromjpeg($img);
            $c_name = ImageColorAllocate($pic, 0, 0, 0);
            $c_num = ImageColorAllocate($pic, 7, 7, 7);
            $font_num = $font_gilreg;

            $h_num = 992;
            $h_usname = 1256;
            $h_date = 1844;
        }else{
            $img = $dir_cert_path."/materials/alg1.jpg";
            $pic = ImageCreateFromjpeg($img);
            $c_name = ImageColorAllocate($pic, 0, 0, 0);
            $c_num = ImageColorAllocate($pic, 7, 7, 7);
            $font_num = $font_times_roman;

            $h_num = 1512;
            $h_usname = 1804;
            $h_date = 2292;
        }

        $c_black = ImageColorAllocate($pic, 7, 7, 7);
        $c_blue = ImageColorAllocate($pic, 40, 132, 170);

        $box = imagettfbbox(50.8, 0, $font_num, $number);
        $left = $center-round(($box[2]-$box[0])/2);
        ImageTTFtext($pic, 50.8, 0, $left, $h_num, $c_num, $font_num, $number);

        $box = imagettfbbox(116.3, 0, $font_assylbek, $username);
        $left = $center-round(($box[2]-$box[0])/2);
        ImageTTFtext($pic, 116.3, 0, $left, $h_usname, $c_name, $font_assylbek, $username);

        $box = imagettfbbox(46.16, 0, $font_num, $date);
        $left = $center-round(($box[2]-$box[0])/2);
        ImageTTFtext($pic, 46.16, 0, $left, $h_date, $c_black, $font_num, $date);

        if (!Storage::disk('public')->exists(Material::CERTIFICATE_PATH)) {
            Storage::disk('public')->makeDirectory(Material::CERTIFICATE_PATH);
        }
        Imagejpeg($pic,Storage::disk('public')->path(Material::CERTIFICATE_PATH)."/".$img_name);
//        ImageDestroy($pic);
        return $img_name;
    }

    public static function getKurmet($id, $certtype){
        $doc = Material::findOrFail($id);
        $translit = Material::Translit($doc->title);

        $dir_cert_path = public_path(Material::CERTIFICATE_PATH);
        $font_dir = public_path('/fonts');

        $date = self::getDate($doc->date);

        $kol = 1;
        $c = 0;
        $id = $doc->id;
        if(strlen($id) < 6){
            for ($i = 0; $i < 5 - strlen($id); $i++) {
                $c .= '0';
            }
            $id = $c.$id;
        }
        $id = 'MK-'.$id;
        $number = '№'.$id;
        $img_name = 'K'.$doc->user_id.time().".jpg";

        $username = $doc->author;

        $font_calibri_reg = $font_dir.'/calibri/Calibri.ttf';
        $font_calibri_bold = $font_dir.'/calibri/calibrib.ttf';
        $font_cambria_bold = $font_dir.'/cambria/cambriab.ttf';
        $font_cambria_reg = $font_dir.'/cambria/cambria.ttc';
        $font_source_reg = $font_dir.'/sourcesans/sourcereg.otf';
        $font_source_bold = $font_dir.'/sourcesans/sourcebold.otf';
        $font_source_light = $font_dir.'/sourcesans/sourcelight.otf';
        $font_times_roman_bd = $font_dir.'/timesbd.ttf';
        $font_arial_reg = $font_dir.'/calibri/arial.ttf';
        $font_arial_bold = $font_dir.'/calibri/arialbd.ttf';
        $font_verdana_reg = $font_dir.'/verdana/verdana.ttf';
        $font_palatino_bold = $font_dir.'/palatino/palab.ttf';
        $font_gilreg = $font_dir.'/Gilroy/Gilroy-Regular.ttf';
        $font_assylbek = $font_dir.'/assylbek/Asylbekm02shelley.Kz.ttf';

        $width = 2480;
        $center = 1240;
        $margin = 300;

        if($certtype == 1){
            $img = $dir_cert_path."/materials/gr1.jpg";
            $pic = ImageCreateFromjpeg($img);
            $c_name = ImageColorAllocate($pic, 0, 0, 0);
            $c_num = ImageColorAllocate($pic, 7, 7, 7);

            $h_num = 1432;
            $h_usname = 1776;
            $h_date = 2288;
        }else
        if($certtype == 2){
            $img = $dir_cert_path."/materials/gr2.jpg";
            $pic = ImageCreateFromjpeg($img);
            $c_name = ImageColorAllocate($pic, 0, 0, 0);
            $c_num = ImageColorAllocate($pic, 7, 7, 7);

            $h_num = 1464;
            $h_usname = 1740;
            $h_date = 2248;
        }else
        if($certtype == 3){
            $img = $dir_cert_path."/materials/gr3.jpg";
            $pic = ImageCreateFromjpeg($img);
            $c_num = ImageColorAllocate($pic, 7, 7, 7);
            $c_name = ImageColorAllocate($pic, 206, 79, 1);

            $h_num = 1420;
            $h_usname = 1704;
            $h_date = 2220;
        }else{
            $img = $dir_cert_path."/materials/gr1.jpg";
            $pic = ImageCreateFromjpeg($img);
            $c_name = ImageColorAllocate($pic, 0, 0, 0);
            $c_num = ImageColorAllocate($pic, 7, 7, 7);

            $h_num = 1432;
            $h_usname = 1776;
            $h_date = 2288;
        }

        $c_black = ImageColorAllocate($pic, 7, 7, 7);

        $box = imagettfbbox(50.8, 0, $font_gilreg, $number);
        $left = $center-round(($box[2]-$box[0])/2);
        ImageTTFtext($pic, 50.8, 0, $left, $h_num, $c_num, $font_gilreg, $number);

        $box = imagettfbbox(116.3, 0, $font_assylbek, $username);
        $left = $center-round(($box[2]-$box[0])/2);
        ImageTTFtext($pic, 116.3, 0, $left, $h_usname, $c_name, $font_assylbek, $username);

        $box = imagettfbbox(46.16, 0, $font_gilreg, $date);
        $left = $center-round(($box[2]-$box[0])/2);
        ImageTTFtext($pic, 46.16, 0, $left, $h_date, $c_black, $font_gilreg, $date);


        if (!Storage::disk('public')->exists(Material::CERTIFICATE_PATH)) {
            Storage::disk('public')->makeDirectory(Material::CERTIFICATE_PATH);
        }
        Imagejpeg($pic,Storage::disk('public')->path(Material::CERTIFICATE_PATH)."/".$img_name);
//        ImageDestroy($pic);
        return $img_name;
    }
}
