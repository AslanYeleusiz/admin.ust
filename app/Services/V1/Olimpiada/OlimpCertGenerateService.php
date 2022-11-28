<?php

namespace App\Services\V1\Olimpiada;

use Illuminate\Support\Facades\Storage;
use App\Models\OlimpiadaBagyty;
use App\Models\OlimpiadaTury;
use App\Models\OlimpiadaKatysu;
use App\Models\OlimpiadaTizim;
use App\Models\OlimpiadaTurnir;
use DateTime;

class OlimpCertGenerateService
{
    public function getDiplom($code, $diplom){
        $otizim = OlimpiadaTizim::where('code', $code)->first();
        $obw = $otizim->obwcode;
        $okatysu = OlimpiadaKatysu::where('obwcode', $obw)->where('o_order_id', $otizim->o_order_id)->first();
        $katysushy = $okatysu->o_katysushy_idd;
        $obagyt = OlimpiadaBagyty::find($okatysu->o_bagyty_idd);
        $tury = OlimpiadaTury::find($okatysu->o_tury_idd);

        $dir_cert_path = public_path(OlimpiadaTizim::CERTIFICATE_PATH);
        $font_dir = public_path('/fonts');

        $olimpname = $tury->o_tury;
        $username = $otizim->katysushy_name;
        $work = $otizim->katysushy_work;
        $kun = $okatysu->o_date;
        $datetime = new DateTime($kun);
        $year = $datetime->format('Y');
        $month = $datetime->format('m');
        $year = '«Зияткерлік олимпиада - '.$year.'»';
        switch ($month) {
            case 1:
                $month = "Қаңтар";
                break;
            case 2:
                $month = "Ақпан";
                break;
            case 3:
                $month = "Наурыз";
                break;
            case 4:
                $month = "Сәуір";
                break;
            case 5:
                $month = "Мамыр";
                break;
            case 6:
                $month = "Маусым";
                break;
            case 7:
                $month = "Шілде";
                break;
            case 8:
                $month = "Тамыз";
                break;
            case 9:
                $month = "Қыркүйек";
                break;
            case 10:
                $month = "Қазан";
                break;
            case 11:
                $month = "Қараша";
                break;
            case 12:
                $month = " Желтоқсан";
                break;
        }
        $kol = 1;
        $date = $okatysu->o_date;
        $id = $otizim->id;
        $ln = strlen($id);
        $z = '';
        for($i = $ln; $i<7;$i++){
            $z .= '0';
        }
        $id = $z.$id;
        $zhetekshisi = $okatysu->o_katysushy_fio;
         if($okatysu->o_oblis == 1){//Международная олимпиада
             $img_name = $id."-ustdip.jpg";
             if($katysushy == 1){ //Учителя диплом международный
                 $center = 1240;
                 switch ($diplom) {
                    case '1':
                      $img = $dir_cert_path."/world/m-diplom1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                      $c_name = ImageColorAllocate($pic, 244, 181, 60);
                      break;
                    case '2':
                      $img = $dir_cert_path."/world/m-diplom2_2.jpg";
                      $pic = ImageCreateFromjpeg($img);
                      $c_name = ImageColorAllocate($pic, 92, 89, 89);
                      break;
                    case '3':
                      $img = $dir_cert_path."/world/m-diplom3.jpg";
                      $pic = ImageCreateFromjpeg($img);
                      $c_name = ImageColorAllocate($pic, 222, 116, 51);
                      break;
                    default:
                      $img = $dir_cert_path."/world/m-diplom1.jpg";
                      $pic = ImageCreateFromjpeg($img);
                      $c_name = ImageColorAllocate($pic, 244, 181, 60);
                      break;
                  }
                  Header("Content-type: image/jpeg");
                $c_black = ImageColorAllocate($pic, 7, 7, 7);
                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $font = $font_dir.'/calibri/Calibri.ttf';
                $font_cambria = $font_dir.'/cambria/cambriab.ttf';
                $font_cambria_it = $font_dir.'/cambria/cambriai.ttf';
                $font_robotobold = $font_dir.'/roboto/Roboto-Bold.ttf';
                $info = 'Халықаралық '.$olimpname.'сының жеңімпазы '.$work;
                $end = 'марапатталады';
                $width = 2480;
                $margin = 300;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1976;
                $k25 = 0;
                foreach ($text_b as $word) {
                $btext = imagettfbbox(48.75, 0, $font, $text_new.' '.$word);
                if($btext[2] > $width - $margin*2){
                    if($i <= 4){
                      $test[$i] = $text_new;
                      if($i-1 != -1){
                        $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                      }
                      else{
                        $q[$i] = $test[$i];
                      }
                      $i++;
                    }
                    $text_new = $text_new."\n".$word;
                    $kol++;
                }
                else {
                $text_new .= " ".$word;
                }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                  $text_new = trim($text_new);
                  $leftt = array();
                  for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(48.75, 0, $font, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 48.75, 0, $leftt[$k], $h_info, $c_black, $font, $text_new);
                      break;
                  }
                  else{
                      $q[$k]=trim($q[$k]);
                      $box1 = imagettfbbox(48.75, 0, $font, $q[$k]);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      $h_info+=70;
                      ImageTTFtext($pic, 48.75, 0, $leftt[$k], $h_info, $c_black, $font, $q[$k]);
                    }
                  }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*60 + $h_info;
                }
                $h_end = $h_name + 100;

                $box = imagettfbbox(85.38, 0, $font_cambria_it, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 85.38, 0, $left, $h_name, $c_name, $font_cambria_it, $username);

                $box2 = imagettfbbox(48.75, 0, $font, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 48.75, 0, $left2, $h_end, $c_black, $font, $end);

                ImageTTFtext($pic, 45, 0, 364, 2940, $c_black, $font, $month);
                $id1 = "№X-".$id;
                $id2 = "X-".$id;
                $box3 = imagettfbbox(60, 0, $font, $id1);
                $left3 = $center-round(($box3[2]-$box3[0])/2);
                ImageTTFtext($pic, 54.885, 0, $left3, 1852, $c_black, $font, $id1);

                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = $center-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 844, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 29.2125, 0, 900, 3272, $c_black, $font_robotobold, $id2);
                ImageTTFtext($pic, 29.2125, 0, 900, 3217, $c_black, $font_robotobold, $date);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
             }
             else //Студенты диплом международный
            if($katysushy == 2){
                  $center = 1240;
                switch ($diplom) {
                      case '1':
                        $img = $dir_cert_path."/world/s-diplom1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 239, 37, 4);
                        $hzh = 2572;
                        $wzh = 860;
                        break;
                      case '2':
                        $img = $dir_cert_path."/world/s-diplom2_2.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 238, 24, 54);
                        $hzh = 2605;
                        $wzh = 800;
                        break;
                      case '3':
                        $img = $dir_cert_path."/world/s-diplom3.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 167, 77, 4);
                        $hzh = 2580;
                        $wzh = 800;
                        break;
                      default:
                        $img = $dir_cert_path."/world/s-diplom1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 239, 37, 4);
                        $hzh = 2572;
                        $wzh = 860;
                        break;
                }
                Header("Content-type: image/jpeg");
                $c_black = ImageColorAllocate($pic, 7, 7, 7);
                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $font = $font_dir.'/calibri/Calibri.ttf';
                $font_cambria = $font_dir.'/cambria/cambriab.ttf';
                $font_robotobold = $font_dir.'/roboto/Roboto-Bold.ttf';
                $font_cal_lg_it = $font_dir.'/calibri/Calibri-LightItalic.ttf';
                $font_cal_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $info = 'Халықаралық '.$olimpname.'сының жеңімпазы '.$work;
                $end = 'марапатталады';
                $width = 2480;
                $margin = 350;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1780;
                $k25 = 0;
                foreach ($text_b as $word) {
                $btext = imagettfbbox(48.75, 0, $font, $text_new.' '.$word);
                if($btext[2] > $width - $margin*2){
                    if($i <= 4){
                      $test[$i] = $text_new;
                      if($i-1 != -1){
                        $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                      }
                      else{
                        $q[$i] = $test[$i];
                      }
                      $i++;
                    }
                    $text_new = $text_new."\n".$word;
                    $kol++;
                }
                else {
                $text_new .= " ".$word;
                }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                  $text_new = trim($text_new);
                  $leftt = array();
                  for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(48.75, 0, $font, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 48.75, 0, $leftt[$k], $h_info, $c_black, $font, $text_new);
                      break;
                  }
                  else{
                      $q[$k]=trim($q[$k]);
                      $box1 = imagettfbbox(48.75, 0, $font, $q[$k]);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      $h_info+=70;
                      ImageTTFtext($pic, 48.75, 0, $leftt[$k], $h_info, $c_black, $font, $q[$k]);
                    }
                  }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*50 + $h_info;
                }
                $h_end = $h_name + 100;

                $box = imagettfbbox(62.46, 0, $font_cal_lg_it, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 62.46, 0, $left, $h_name, $c_name, $font_cal_lg_it, $username);

                $box2 = imagettfbbox(48.75, 0, $font, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 48.75, 0, $left2, $h_end, $c_black, $font, $end);

                $box2 = imagettfbbox(45, 0, $font, $month);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 45, 0, $left2, 1013, $c_black, $font, $month);

                $id2 = "X-".$id;
                $box3 = imagettfbbox(60, 0, $font, $id1);
                $left3 = $center-round(($box3[2]-$box3[0])/2);

                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = $center-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 884, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 28.2125, 0, 880, 3135, $c_black, $font_robotobold, $id2);
                ImageTTFtext($pic, 28.2125, 0, 880, 3083, $c_black, $font_robotobold, $date);
                ImageTTFtext($pic, 45, 0, $wzh, $hzh, $c_black, $font_cal_lg_it, $zhetekshisi);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
            }else
            if($katysushy == 3){//Ученики диплом международный
                $center = 1245;
                switch ($diplom) {
                      case '1':
                        $img = $dir_cert_path."/world/o-diplom1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 247, 155, 12);
                        $hzh = 2615;
                        $wzh = 748;
                        break;
                      case '2':
                        $img = $dir_cert_path."/world/o-diplom2.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 36, 137, 206);
                        $hzh = 2615;
                        $wzh = 748;
                        break;
                      case '3':
                        $img = $dir_cert_path."/world/o-diplom3.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 228, 87, 18);
                        $hzh = 2615;
                        $wzh = 748;
                        break;
                      default:
                        $img = $dir_cert_path."/world/o-diplom1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 247, 155, 12);
                        $hzh = 2615;
                        $wzh = 748;
                        break;
                }
                Header("Content-type: image/jpeg");
                $c_black = ImageColorAllocate($pic, 7, 7, 7);
                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $font = $font_dir.'/calibri/Calibri.ttf';
                $font_cambria = $font_dir.'/cambria/cambriab.ttf';
                $font_robotobold = $font_dir.'/roboto/Roboto-Bold.ttf';
                $font_cal_lg_it = $font_dir.'/calibri/Calibri-LightItalic.ttf';
                $font_cal_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $info = 'Халықаралық '.$olimpname.'сының жеңімпазы '.$work;
                $end = 'марапатталады';
                $width = 1908;
                $margin = 80;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1760;
                $k25 = 0;
                foreach ($text_b as $word) {
                $btext = imagettfbbox(60, 0, $font_cal_lg_it, $text_new.' '.$word);
                if($btext[2] > $width - $margin*2){
                    if($i <= 4){
                      $test[$i] = $text_new;
                      if($i-1 != -1){
                        $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                      }
                      else{
                        $q[$i] = $test[$i];
                      }
                      $i++;
                    }
                    $text_new = $text_new."\n".$word;
                    $kol++;
                }
                else {
                $text_new .= " ".$word;
                }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                  $text_new = trim($text_new);
                  $leftt = array();
                  for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(48.75, 0, $font_cal_lg_it, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 48.75, 0, $leftt[$k], $h_info, $c_black, $font_cal_lg_it, $text_new);
                      break;
                  }
                  else{
                      $q[$k]=trim($q[$k]);
                      $box1 = imagettfbbox(48.75, 0, $font_cal_lg_it, $q[$k]);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      $h_info+=70;
                      ImageTTFtext($pic, 48.75, 0, $leftt[$k], $h_info, $c_black, $font_cal_lg_it, $q[$k]);
                    }
                  }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*50 + $h_info;
                }
                $h_end = $h_name + 100;

                $box = imagettfbbox(75, 0, $font_cambria, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 75, 0, $left, $h_name, $c_name, $font_cambria, $username);

                $box2 = imagettfbbox(48.75, 0, $font_cal_lg_it, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 48.75, 0, $left2, $h_end, $c_black, $font_cal_lg_it, $end);
                $box4 = imagettfbbox(55, 0, $font, $month);
                $left4 = $center-round(($box4[2]-$box4[0])/2);
                ImageTTFtext($pic, 45, 0, $left4, 964, $c_black, $font, $month);

                $id2 = "X-".$id;
                $box3 = imagettfbbox(60, 0, $font, $id1);
                $left3 = $center-round(($box3[2]-$box3[0])/2);

                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = $center-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 820, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 908, 3178, $c_black, $font_robotobold, $id2);
                ImageTTFtext($pic, 27.2125, 0, 908, 3123, $c_black, $font_robotobold, $date);
                ImageTTFtext($pic, 45, 0, $wzh, $hzh, $c_black, $font_cal_lg_it, $zhetekshisi);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
            }else
            if($katysushy == 4){//Воспитатели диплом международный
                $center = 1240;
                switch ($diplom) {
                      case '1':
                        $img = $dir_cert_path."/world/t-newdip1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 127, 106, 97);
                        $c_grey = ImageColorAllocate($pic, 127, 106, 97);
                        break;
                      case '2':
                        $img = $dir_cert_path."/world/t-newdip2_2.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 34, 118, 233);
                        $c_grey = ImageColorAllocate($pic, 69, 71, 71);
                        break;
                      case '3':
                        $img = $dir_cert_path."/world/t-newdip3.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 93, 64, 52);
                        $c_grey = ImageColorAllocate($pic, 93, 64, 52);
                        break;
                      default:
                        $img = $dir_cert_path."/world/t-newdip1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 127, 106, 97);
                        $c_grey = ImageColorAllocate($pic, 127, 106, 97);
                        break;
                }
                Header("Content-type: image/jpeg");
                $c_black = ImageColorAllocate($pic, 7, 7, 7);
                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $font = $font_dir.'/calibri/Calibri.ttf';
                $font_cambria = $font_dir.'/cambria/cambriab.ttf';
                $font_cal_bd = $font_dir.'/calibri/calibrib.ttf';
                $font_robotobold = $font_dir.'/roboto/Roboto-Bold.ttf';
                $font_cal_lg_it = $font_dir.'/calibri/Calibri-LightItalic.ttf';
                $font_cal_lg = $font_dir.'/calibri/Calibri-Light.ttf';
                $info = 'Халықаралық '.$olimpname.'сының жеңімпазы '.$work;
                $end = 'марапатталады';
                $width = 2480;
                $margin = 300;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1912;
                $k25 = 0;
                foreach ($text_b as $word) {
                $btext = imagettfbbox(48.75, 0, $font_cal_lg_it, $text_new.' '.$word);
                if($btext[2] > $width - $margin*2){
                    if($i <= 4){
                      $test[$i] = $text_new;
                      if($i-1 != -1){
                        $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                      }
                      else{
                        $q[$i] = $test[$i];
                      }
                      $i++;
                    }
                    $text_new = $text_new."\n".$word;
                    $kol++;
                }
                else {
                $text_new .= " ".$word;
                }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                  $text_new = trim($text_new);
                  $leftt = array();
                  for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(48.75, 0, $font_cal_lg_it, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 48.75, 0, $leftt[$k], $h_info, $c_grey, $font_cal_lg_it, $text_new);
                      break;
                  }
                  else{
                      $q[$k]=trim($q[$k]);
                      $box1 = imagettfbbox(48.75, 0, $font_cal_lg_it, $q[$k]);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      $h_info+=70;
                      ImageTTFtext($pic, 48.75, 0, $leftt[$k], $h_info, $c_grey, $font_cal_lg_it, $q[$k]);
                    }
                  }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*50 + $h_info;
                }
                $h_end = $h_name + 120;

                $box = imagettfbbox(75, 0, $font_cal_bd, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 75, 0, $left, $h_name, $c_name, $font_cal_bd, $username);

                $box2 = imagettfbbox(48.75, 0, $font_cal_lg_it, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 48.75, 0, $left2, $h_end, $c_grey, $font_cal_lg_it, $end);

                $month = mb_strtoupper($month);
                $box4 = imagettfbbox(45, 0, $font, $month);
                $left4 = $center-round(($box4[2]-$box4[0])/2);
                ImageTTFtext($pic, 45, 0, $left4, 2600, $c_grey, $font_cal_lg, $month);

                $id1 = "№X-".$id;
                $id2 = "X-".$id;
                $box3 = imagettfbbox(60, 0, $font, $id1);
                $left3 = $center-round(($box3[2]-$box3[0])/2);
                ImageTTFtext($pic, 54.885, 0, $left3, 1780, $c_grey, $font, $id1);

                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = $center-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 816, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 912, 3105, $c_grey, $font_robotobold, $id2);
                ImageTTFtext($pic, 27.2125, 0, 912, 3045, $c_grey, $font_robotobold, $date);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
              }
         }else
         if($okatysu->o_oblis == 2 || $okatysu->o_oblis == NULL || $okatysu->o_oblis == 0){//Республиканская олимпиада
             $img_name = $id."-ustdip.jpg";
             if($katysushy == 1){ //Учителя диплом республика
                 $center = 1240;
                switch ($diplom) {
                      case '1':
                        $img = $dir_cert_path."/republic/m-diplom1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 226, 120, 11);
                        break;
                      case '2':
                        $img = $dir_cert_path."/republic/m-diplom2_2.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 146, 9, 252);
                        break;
                      case '3':
                        $img = $dir_cert_path."/republic/m-diplom3.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 240, 137, 65);
                        break;
                      default:
                        $img = $dir_cert_path."/republic/m-diplom1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 226, 120, 11);
                        break;
                }
                Header("Content-type: image/jpeg");
                $c_black = ImageColorAllocate($pic, 7, 7, 7);
                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $c_text = ImageColorAllocate($pic, 109, 93, 86);
                $font = $font_dir.'/calibri/Calibri.ttf';
                $font_cambria = $font_dir.'/cambria/cambriab.ttf';
                $font_robotobold = $font_dir.'/roboto/Roboto-Bold.ttf';
                $font_cal_lg_it = $font_dir.'/calibri/Calibri-LightItalic.ttf';
                $font_cal_lg = $font_dir.'/calibri/Calibri-Light.ttf';
                $font_cal_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $info = 'Республикалық '.$olimpname.'сының жеңімпазы '.$work;
                $end = 'марапатталады';
                $width = 2480;
                $margin = 300;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1980;
                $k25 = 0;
                foreach ($text_b as $word) {
                $btext = imagettfbbox(56.25, 0, $font_cal_lg_it, $text_new.' '.$word);
                if($btext[2] > $width - $margin*2){
                    if($i <= 4){
                      $test[$i] = $text_new;
                      if($i-1 != -1){
                        $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                      }
                      else{
                        $q[$i] = $test[$i];
                      }
                      $i++;
                    }
                    $text_new = $text_new."\n".$word;
                    $kol++;
                }
                else {
                $text_new .= " ".$word;
                }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                  $text_new = trim($text_new);
                  $leftt = array();
                  for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(56.25, 0, $font_cal_lg_it, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 56.25, 0, $leftt[$k], $h_info, $c_text, $font_cal_lg_it, $text_new);
                      break;
                  }
                  else{
                      $q[$k]=trim($q[$k]);
                      $box1 = imagettfbbox(56.25, 0, $font_cal_lg_it, $q[$k]);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      $h_info+=70;
                      ImageTTFtext($pic, 56.25, 0, $leftt[$k], $h_info, $c_text, $font_cal_lg_it, $q[$k]);
                    }
                  }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*40 + $h_info;
                }
                $h_end = $h_name + 100;
                $h_month = $h_end + 100;

                $box = imagettfbbox(75, 0, $font_cal_it, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 75, 0, $left, $h_name, $c_name, $font_cal_it, $username);

                $box2 = imagettfbbox(56.25, 0, $font_cal_lg_it, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 56.25, 0, $left2, $h_end, $c_text, $font_cal_lg_it, $end);

                $month = mb_strtoupper($month);
                $box4 = imagettfbbox(45, 0, $font, $month);
                $left4 = $center-round(($box4[2]-$box4[0])/2);
                ImageTTFtext($pic, 45, 0, $left4, $h_month, $c_text, $font_cal_lg, $month);

                $id1 = "№R-".$id;
                $id2 = "R-".$id;
                $box3 = imagettfbbox(60, 0, $font, $id1);
                $left3 = $center-round(($box3[2]-$box3[0])/2);
                ImageTTFtext($pic, 51, 0, $left3, 1868, $c_text, $font, $id1);

                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = $center-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 900, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 900, 3135, $c_text, $font_robotobold, $id2);
                ImageTTFtext($pic, 27.2125, 0, 900, 3075, $c_text, $font_robotobold, $date);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
             }
             else //Студенты диплом республика
            if($katysushy == 2){
                  $center = 1240;
                switch ($diplom) {
                      case '1':
                        $img = $dir_cert_path."/republic/s-diplom1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 129, 30, 159);
                        $h_zh = 2582;
                        $w_zh = 920;
                        $wyear = 1468;
                        $hyear = 807;
                        break;
                      case '2':
                        $img = $dir_cert_path."/republic/s-diplom2_2.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 96, 95, 95);
                        $h_zh = 2595;
                        $w_zh = 920;
                        $wyear = 1468;
                        $hyear = 807;
                        break;
                      case '3':
                        $img = $dir_cert_path."/republic/s-diplom3.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 230, 123, 55);
                        $h_zh = 2578;
                        $w_zh = 920;
                        $wyear = 1450;
                        $hyear = 807;
                        break;
                      default:
                        $img = $dir_cert_path."/republic/s-diplom1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 129, 30, 159);
                        $h_zh = 2584;
                        $w_zh = 908;
                        $wyear = 1468;
                        $hyear = 807;
                        break;
                }
                Header("Content-type: image/jpeg");
                $c_black = ImageColorAllocate($pic, 7, 7, 7);
                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $c_text = ImageColorAllocate($pic, 109, 93, 86);
                $font = $font_dir.'/calibri/Calibri.ttf';
                $font_cam_reg = $font_dir.'/cambria/Cambria.ttf';
                $font_cambria = $font_dir.'/cambria/cambriab.ttf';
                $font_robotobold = $font_dir.'/roboto/Roboto-Bold.ttf';
                $font_cal_lg_it = $font_dir.'/calibri/Calibri-LightItalic.ttf';
                $font_cal_lg = $font_dir.'/calibri/Calibri-Light.ttf';
                $font_cal_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $info = 'Республикалық '.$olimpname.'сының жеңімпазы '.$work;
                $end = 'марапатталады';
                $width = 2480;
                $margin = 300;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1875;
                $k25 = 0;
                foreach ($text_b as $word) {
                $btext = imagettfbbox(48.7875, 0, $font_cal_lg, $text_new.' '.$word);
                if($btext[2] > $width - $margin*2){
                    if($i <= 4){
                      $test[$i] = $text_new;
                      if($i-1 != -1){
                        $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                      }
                      else{
                        $q[$i] = $test[$i];
                      }
                      $i++;
                    }
                    $text_new = $text_new."\n".$word;
                    $kol++;
                }
                else {
                $text_new .= " ".$word;
                }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                  $text_new = trim($text_new);
                  $leftt = array();
                  for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(48.7875, 0, $font_cal_lg, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_black, $font_cal_lg, $text_new);
                      break;
                  }
                  else{
                      $q[$k]=trim($q[$k]);
                      $box1 = imagettfbbox(48.7875, 0, $font_cal_lg, $q[$k]);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      $h_info+=70;
                      ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_black, $font_cal_lg, $q[$k]);
                    }
                  }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*40 + $h_info;
                }
                $h_end = $h_name + 100;
                $h_month = $h_end + 100;

                $box = imagettfbbox(63.75, 0, $font_cal_it, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 63.75, 0, $left, $h_name, $c_name, $font_cal_it, $username);

                $box2 = imagettfbbox(48.7875, 0, $font_cal_lg, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 48.7875, 0, $left2, $h_end, $c_black, $font_cal_lg, $end);

                $month = mb_strtoupper($month);
                $box4 = imagettfbbox(45, 0, $font_cal_lg, $month);
                $left4 = $center-round(($box4[2]-$box4[0])/2);
                ImageTTFtext($pic, 45, 0, 729, 2832, $c_black, $font_cal_lg, $month);

                $id1 = "№R-".$id;
                $id2 = "R-".$id;
                $box3 = imagettfbbox(60, 0, $font, $id1);
                $left3 = $center-round(($box3[2]-$box3[0])/2);
                ImageTTFtext($pic, 51, 0, 2040, 3370, $c_white, $font, $id1);

                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = $center-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 816, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 900, 3120, $c_black, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 900, 3177, $c_black, $font_robotobold, $id2);
                ImageTTFtext($pic, 45, 0, $w_zh, $h_zh, $c_black, $font_cal_lg_it, $zhetekshisi);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
            }else
            if($katysushy == 3){//Ученики диплом республика
                $center = 1737;
                switch ($diplom) {
                      case '1':
                        $img = $dir_cert_path."/republic/o-diplom1_1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 82, 82, 82);
                        $w_zh = 1560;
                        $h_zh = 1917;
                        $wyear = 1076;
                        $hyear = 2293;
                        $h1id = 1005;
                        $hdate = 2250;
                        $hid2 = 2305;
                        break;
                      case '2':
                        $img = $dir_cert_path."/republic/o-diplom2_2.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 82, 82, 82);
                        $w_zh = 1590;
                        $h_zh = 1892;
                        $wyear = 1078;
                        $hyear = 2275;
                        $h1id = 1080;
                        $hdate = 2243;
                        $hid2 = 2293;
                        break;
                      case '3':
                        $img = $dir_cert_path."/republic/o-diplom3_3.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 149, 65, 88);
                        $w_zh = 1560;
                        $h_zh = 1912;
                        $wyear = 1077;
                        $hyear = 2280;
                        $h1id = 1040;
                        $hdate = 2245;
                        $hid2 = 2298;
                        break;
                      default:
                        $img = $dir_cert_path."/republic/o-diplom1_1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 82, 82, 82);
                        $w_zh = 1560;
                        $h_zh = 1915;
                        $wyear = 1076;
                        $hyear = 2293;
                        $h1id = 1040;
                        $hdate = 2250;
                        $hid2 = 2305;
                        break;
                }
                Header("Content-type: image/jpeg");
                $c_black = ImageColorAllocate($pic, 7, 7, 7);
                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $c_text = ImageColorAllocate($pic, 85, 83, 83);
                $c_dark = ImageColorAllocate($pic, 55, 54, 54);
                $font = $font_dir.'/calibri/Calibri.ttf';
                $font_cam_reg = $font_dir.'/cambria/Cambria.ttf';
                $font_cambria = $font_dir.'/cambria/cambriab.ttf';
                $font_robotobold = $font_dir.'/roboto/Roboto-Bold.ttf';
                $font_cal_lg_it = $font_dir.'/calibri/Calibri-LightItalic.ttf';
                $font_cal_lg = $font_dir.'/calibri/Calibri-Light.ttf';
                $font_cal_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $info = 'Республикалық '.$olimpname.'сының жеңімпазы '.$work;
                $end = 'марапатталады';
                $width = 2000;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1135;
                $k25 = 0;
                foreach ($text_b as $word) {
                $btext = imagettfbbox(46.836, 0, $font, $text_new.' '.$word);
                if($btext[2] > $width - $margin*2){
                    if($i <= 4){
                      $test[$i] = $text_new;
                      if($i-1 != -1){
                        $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                      }
                      else{
                        $q[$i] = $test[$i];
                      }
                      $i++;
                    }
                    $text_new = $text_new."\n".$word;
                    $kol++;
                }
                else {
                $text_new .= " ".$word;
                }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                  $text_new = trim($text_new);
                  $leftt = array();
                  for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(46.836, 0, $font, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 46.836, 0, $leftt[$k], $h_info, $c_black, $font, $text_new);
                      break;
                  }
                  else{
                      $q[$k]=trim($q[$k]);
                      $box1 = imagettfbbox(46.836, 0, $font, $q[$k]);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      $h_info+=70;
                      ImageTTFtext($pic, 46.836, 0, $leftt[$k], $h_info, $c_black, $font, $q[$k]);
                    }
                  }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*40 + $h_info;
                }
                $h_end = $h_name + 100;
                $h_month = $h_end + 120;

                $box = imagettfbbox(63.75, 0, $font_cambria, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 63.75, 0, $left, $h_name, $c_name, $font_cambria, $username);

                $box2 = imagettfbbox(46.836, 0, $font, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 46.836, 0, $left2, $h_end, $c_black, $font, $end);

                $month = mb_strtoupper($month);
                $box4 = imagettfbbox(45, 0, $font, $month);
                $left4 = $center-round(($box4[2]-$box4[0])/2);
                ImageTTFtext($pic, 45, 0, 630, $h_zh, $c_black, $font, $month);

                $id1 = "№R-".$id;
                $id2 = "R-".$id;
                $box3 = imagettfbbox(45, 0, $font, $id1);
                $left3 = $center-round(($box3[2]-$box3[0])/2);
                ImageTTFtext($pic, 45, 0, $left3, $h1id, $c_text, $font, $id1);

                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = 900-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 2289, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 1734, $hdate, $c_dark, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 1734, $hid2, $c_dark, $font_robotobold, $id2);
                ImageTTFtext($pic, 45, 0, $w_zh, $h_zh, $c_black, $font_cal_lg_it, $zhetekshisi);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
            }else
            if($katysushy == 4){//Воспитатели диплом республика
                $center = 1605;
                switch ($diplom) {
                      case '1':
                        $img = $dir_cert_path."/republic/t-diplom1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 24, 137, 233);
                        break;
                      case '2':
                        $img = $dir_cert_path."/republic/t-diplom2.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 24, 137, 233);
                        break;
                      case '3':
                        $img = $dir_cert_path."/republic/t-diplom3.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 24, 137, 233);
                        break;
                      default:
                        $img = $dir_cert_path."/republic/t-diplom1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 24, 137, 233);
                        break;
                }
                Header("Content-type: image/jpeg");
                $c_black = ImageColorAllocate($pic, 7, 7, 7);
                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $c_text = ImageColorAllocate($pic, 85, 83, 83);
                $c_dark = ImageColorAllocate($pic, 55, 54, 54);
                $font = $font_dir.'/calibri/Calibri.ttf';
                $font_cam_reg = $font_dir.'/cambria/Cambria.ttf';
                $font_cambria = $font_dir.'/cambria/cambriab.ttf';
                $font_robotobold = $font_dir.'/roboto/Roboto-Bold.ttf';
                $font_cal_lg_it = $font_dir.'/calibri/Calibri-LightItalic.ttf';
                $font_cal_lg = $font_dir.'/calibri/Calibri-Light.ttf';
                $font_cal_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $font_cal_bold_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $info = 'Республикалық '.$olimpname.'сының жеңімпазы '.$work;
                $end = 'марапатталады';
                $width = 2000;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1284;
                $k25 = 0;
                foreach ($text_b as $word) {
                $btext = imagettfbbox(46.836, 0, $font, $text_new.' '.$word);
                if($btext[2] > $width - $margin*2){
                    if($i <= 4){
                      $test[$i] = $text_new;
                      if($i-1 != -1){
                        $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                      }
                      else{
                        $q[$i] = $test[$i];
                      }
                      $i++;
                    }
                    $text_new = $text_new."\n".$word;
                    $kol++;
                }
                else {
                $text_new .= " ".$word;
                }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                  $text_new = trim($text_new);
                  $leftt = array();
                  for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(46.836, 0, $font, $text_new);
                      $leftt[$k] = 2*$center-round(($box1[2]));
                      ImageTTFtext($pic, 46.836, 0, $leftt[$k], $h_info, $c_black, $font, $text_new);
                      break;
                  }
                  else{
                      $q[$k]=trim($q[$k]);
                      $box1 = imagettfbbox(46.836, 0, $font, $q[$k]);
                      $leftt[$k] = 2*$center-round(($box1[2]));
                      $h_info+=70;
                      ImageTTFtext($pic, 46.836, 0, $leftt[$k], $h_info, $c_black, $font, $q[$k]);
                    }
                  }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*40 + $h_info;
                }
                $h_end = $h_name + 100;
                $h_month = $h_end + 120;

                $box = imagettfbbox(63.75, 0, $font_cambria, $username);
                $left = 2*$center-round(($box[2]));
                ImageTTFtext($pic, 63.75, 0, $left, $h_name, $c_name, $font_cambria, $username);

                $box2 = imagettfbbox(46.836, 0, $font, $end);
                $left2 = 2*$center-round(($box[2])/2.75);
                ImageTTFtext($pic, 46.836, 0, $left2, $h_end, $c_black, $font, $end);

                $month = mb_strtoupper($month);
                $box4 = imagettfbbox(45, 0, $font, $month);
                $left4 = $center-round(($box4[2])/2);
                ImageTTFtext($pic, 45, 0, 1645, 2076, $c_text, $font_cal_lg_it, $month);

                $id1 = "№R-".$id;
                $id2 = "R-".$id;
                $box3 = imagettfbbox(54, 0, $font, $id1);
                ImageTTFtext($pic, 54, 0, 2783, 1149, $c_text, $font, $id1);

                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = 1218-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 2364, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 2138, 2340, $c_dark, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 2138, 2397, $c_dark, $font_robotobold, $id2);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
              }
         }else
         if($okatysu->o_oblis == 3){//Областная олимпиада
             $img_name = $id."-ustdip.jpg";
             $oblys = OlimpiadaTurnir::getOblys($okatysu->oblysy);
             if($katysushy == 1){ //Учителя диплом облыс
                 $center = 1740;
                switch ($diplom) {
                      case '1':
                        $img = $dir_cert_path."/oblys/m-diplom1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 2, 96, 172);
                        break;
                      case '2':
                        $img = $dir_cert_path."/oblys/m-diplom2.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 2, 96, 172);
                        break;
                      case '3':
                        $img = $dir_cert_path."/oblys/m-diplom3.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 2, 96, 172);
                        break;
                      default:
                        $img = $dir_cert_path."/oblys/m-diplom1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 2, 96, 172);
                        break;
                }
                Header("Content-type: image/jpeg");
                $c_black = ImageColorAllocate($pic, 7, 7, 7);
                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $c_text = ImageColorAllocate($pic, 109, 93, 86);
                $c_dark = ImageColorAllocate($pic, 55, 54, 54);
                $font = $font_dir.'/calibri/Calibri.ttf';
                $font_cambria = $font_dir.'/cambria/cambriab.ttf';
                $font_robotobold = $font_dir.'/roboto/Roboto-Bold.ttf';
                $font_cal_lg_it = $font_dir.'/calibri/Calibri-LightItalic.ttf';
                $font_cal_lg = $font_dir.'/calibri/Calibri-Light.ttf';
                $font_cal_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $info = $oblys.' бойынша '.$olimpname.'сының жеңімпазы '.$work;
                $end = 'марапатталады';
                $width = 1900;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 985;
                foreach ($text_b as $word) {
                $btext = imagettfbbox(56.25, 0, $font_cal_lg, $text_new.' '.$word);
                if($btext[2] > $width - $margin*2){
                    if($i <= 4){
                      $test[$i] = $text_new;
                      if($i-1 != -1){
                        $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                      }
                      else{
                        $q[$i] = $test[$i];
                      }
                      $i++;
                    }
                    $text_new = $text_new."\n".$word;
                    $kol++;
                }
                else {
                $text_new .= " ".$word;
                }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                  $text_new = trim($text_new);
                  $leftt = array();
                  for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(56.25, 0, $font_cal_lg, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 56.25, 0, $leftt[$k], $h_info, $c_text, $font_cal_lg, $text_new);
                      break;
                  }
                  else{
                      $q[$k]=trim($q[$k]);
                      $box1 = imagettfbbox(56.25, 0, $font_cal_lg, $q[$k]);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      $h_info+=70;
                      ImageTTFtext($pic, 56.25, 0, $leftt[$k], $h_info, $c_text, $font_cal_lg, $q[$k]);
                    }
                  }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*50 + $h_info;
                }
                $h_end = $h_name + 100;
                $h_month = $h_end + 120;

                $box = imagettfbbox(75, 0, $font_cambria, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 75, 0, $left, $h_name, $c_name, $font_cambria, $username);

                $box2 = imagettfbbox(56.25, 0, $font_cal_lg_it, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 56.25, 0, $left2, $h_end, $c_text, $font_cal_lg, $end);

                $month = mb_strtoupper($month);
                ImageTTFtext($pic, 45, 0, 1503, 1930, $c_dark, $font_cal_lg, $month);

                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = 1218-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 2262, $c_white, $font_robotobold, $year);

                $id2 = "O-".$id;
                ImageTTFtext($pic, 27.2125, 0, 2090, 2233, $c_dark, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 2090, 2287, $c_dark, $font_robotobold, $id2);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
             }
             else //Студенты диплом облыс
            if($katysushy == 2){
                  $center = 1754;
                switch ($diplom) {
                      case '1':
                        $img = $dir_cert_path."/oblys/s-diplom1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 238, 176, 7);
                        $h_zh = 1962;
                        $w_zh = 1160;
                        $wyear = 665;
                        $hyear = 2298;
                        break;
                      case '2':
                        $img = $dir_cert_path."/oblys/s-diplom2_2.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 238, 29, 34);
                        $h_zh = 1965;
                        $w_zh = 1160;
                        $wyear = 665;
                        $hyear = 2298;
                        break;
                      case '3':
                        $img = $dir_cert_path."/oblys/s-diplom3.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 227, 110, 39);
                        $h_zh = 1965;
                        $w_zh = 1160;
                        $wyear = 665;
                        $hyear = 2298;
                        break;
                      default:
                        $img = $dir_cert_path."/oblys/s-diplom1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 238, 176, 7);
                        $h_zh = 1965;
                        $w_zh = 1160;
                        $wyear = 665;
                        $hyear = 2298;
                        break;
                }
                Header("Content-type: image/jpeg");
                $c_black = ImageColorAllocate($pic, 7, 7, 7);
                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $c_text = ImageColorAllocate($pic, 109, 93, 86);
                $c_dark = ImageColorAllocate($pic, 55, 54, 54);
                $font = $font_dir.'/calibri/Calibri.ttf';
                $font_cam_reg = $font_dir.'/cambria/Cambria.ttf';
                $font_cambria = $font_dir.'/cambria/cambriab.ttf';
                $font_robotobold = $font_dir.'/roboto/Roboto-Bold.ttf';
                $font_cal_lg_it = $font_dir.'/calibri/Calibri-LightItalic.ttf';
                $font_cal_lg = $font_dir.'/calibri/Calibri-Light.ttf';
                $font_cal_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $info = $oblys.' бойынша '.$olimpname.'сының жеңімпазы '.$work;
                $end = 'марапатталады';
                $width = 3508;
                $margin = 300;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1260;
                foreach ($text_b as $word) {
                $btext = imagettfbbox(48.7875, 0, $font_cam_reg, $text_new.' '.$word);
                if($btext[2] > $width - $margin*2){
                    if($i <= 4){
                      $test[$i] = $text_new;
                      if($i-1 != -1){
                        $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                      }
                      else{
                        $q[$i] = $test[$i];
                      }
                      $i++;
                    }
                    $text_new = $text_new."\n".$word;
                    $kol++;
                }
                else {
                $text_new .= " ".$word;
                }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                  $text_new = trim($text_new);
                  $leftt = array();
                  for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(48.7875, 0, $font, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font, $text_new);
                      break;
                  }
                  else{
                      $q[$k]=trim($q[$k]);
                      $box1 = imagettfbbox(48.7875, 0, $font, $q[$k]);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      $h_info+=70;
                      ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font, $q[$k]);
                    }
                  }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*60 + $h_info;
                }
                $h_end = $h_name + 120;
                $h_month = $h_end + 120;

                $box = imagettfbbox(90, 0, $font_cambria, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 90, 0, $left, $h_name, $c_name, $font_cambria, $username);

                $box2 = imagettfbbox(56.25, 0, $font_cal_lg_it, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 56.25, 0, $left2, $h_end, $c_text, $font, $end);

                $month = mb_strtoupper($month);
                $centm = 450;
                $box4 = imagettfbbox(40, 0, $font_cal_lg_it, $month);
                $left4 = $centm-round(($box4[2]-$box4[0])/2);
                ImageTTFtext($pic, 40, 0, $left4, 1887, $c_dark, $font_cal_lg_it, $month);

                $id1 = "№O-".$id;
                $id2 = "O-".$id;
                $c_id1c = ImageColorAllocate($pic, 45, 110, 144);
                ImageTTFtext($pic, 54, 0, 2984, 2378, $c_id1c, $font, $id1);

                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = 471-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 2316, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 1338, 2296, $c_dark, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 1338, 2348, $c_dark, $font_robotobold, $id2);
                ImageTTFtext($pic, 45, 0, $w_zh, $h_zh, $c_black, $font_cal_lg_it, $zhetekshisi);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
            }else
            if($katysushy == 3){//Ученики диплом облыс
                $center = 1754;
                switch ($diplom) {
                      case '1':
                        $img = $dir_cert_path."/oblys/o-diplom1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 84, 155, 96);
                        $w_zh = 1638;
                        $h_zh = 1920;
                        $wyear = 1093;
                        $hyear = 2210;
                        break;
                      case '2':
                        $img = $dir_cert_path."/oblys/o-diplom2_2.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 4, 88, 226);
                        $w_zh = 1638;
                        $h_zh = 1933;
                        $wyear = 1093;
                        $hyear = 2210;
                        break;
                      case '3':
                        $img = $dir_cert_path."/oblys/o-diplom3.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 84, 155, 96);
                        $w_zh = 1638;
                        $h_zh = 1900;
                        $wyear = 1093;
                        $hyear = 2210;
                        break;
                      default:
                        $img = $dir_cert_path."/oblys/o-diplom1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 84, 155, 96);
                        $w_zh = 1638;
                        $h_zh = 1930;
                        $wyear = 1093;
                        $hyear = 2210;
                        break;
                }
                Header("Content-type: image/jpeg");
                $c_black = ImageColorAllocate($pic, 7, 7, 7);
                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $c_text = ImageColorAllocate($pic, 85, 83, 83);
                $c_red = ImageColorAllocate($pic, 40, 9, 9);
                $c_dark = ImageColorAllocate($pic, 55, 54, 54);
                $font = $font_dir.'/calibri/Calibri.ttf';
                $font_cam_reg = $font_dir.'/cambria/Cambria.ttf';
                $font_cambria = $font_dir.'/cambria/cambriab.ttf';
                $font_robotobold = $font_dir.'/roboto/Roboto-Bold.ttf';
                $font_cal_lg_it = $font_dir.'/calibri/Calibri-LightItalic.ttf';
                $font_cal_lg = $font_dir.'/calibri/Calibri-Light.ttf';
                $font_cal_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $info = $oblys.' бойынша '.$olimpname.'сының жеңімпазы '.$work;
                $end = 'марапатталады';
                $width = 1900;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1180;
                foreach ($text_b as $word) {
                $btext = imagettfbbox(46.836, 0, $font_cal_lg, $text_new.' '.$word);
                if($btext[2] > $width - $margin*2){
                    if($i <= 4){
                      $test[$i] = $text_new;
                      if($i-1 != -1){
                        $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                      }
                      else{
                        $q[$i] = $test[$i];
                      }
                      $i++;
                    }
                    $text_new = $text_new."\n".$word;
                    $kol++;
                }
                else {
                $text_new .= " ".$word;
                }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                  $text_new = trim($text_new);
                  $leftt = array();
                  for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(46.836, 0, $font_cal_lg, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 46.836, 0, $leftt[$k], $h_info, $c_red, $font_cal_lg, $text_new);
                      break;
                  }
                  else{
                      $q[$k]=trim($q[$k]);
                      $box1 = imagettfbbox(46.836, 0, $font_cal_lg, $q[$k]);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      $h_info+=70;
                      ImageTTFtext($pic, 46.836, 0, $leftt[$k], $h_info, $c_red, $font_cal_lg, $q[$k]);
                    }
                  }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*50 + $h_info;
                }
                $h_end = $h_name + 100;
                $h_month = $h_end + 120;

                $box = imagettfbbox(63.75, 0, $font_cambria, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 63.75, 0, $left, $h_name, $c_name, $font_cambria, $username);

                $box2 = imagettfbbox(46.836, 0, $font_cal_lg_it, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 46.836, 0, $left2, $h_end, $c_red, $font_cal_lg, $end);

                $month = mb_strtoupper($month);
                $centm = 890;
                $box4 = imagettfbbox(40, 0, $font_cal_lg, $month);
                $left4 = $centm-round(($box4[2]-$box4[0])/2);
                ImageTTFtext($pic, 40, 0, $left4, 1800, $c_dark, $font_cal_lg, $month);

                $id1 = "№R-".$id;
                $id2 = "R-".$id;
                $box3 = imagettfbbox(45, 0, $font, $id1);
                $left3 = $center-round(($box3[2]-$box3[0])/2);
                #ImageTTFtext($pic, 45, 0, $left3, $h1id, $c_text, $font, $id1);
                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = 894-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 2226, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 1805, 2202, $c_dark, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 1805, 2258, $c_dark, $font_robotobold, $id2);
                ImageTTFtext($pic, 45, 0, $w_zh, $h_zh, $c_black, $font_cal_lg_it, $zhetekshisi);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
            }else
            if($katysushy == 4){//Воспитатели диплом облыс
                $center = 2270;
                switch ($diplom) {
                      case '1':
                        $img = $dir_cert_path."/oblys/t-diplom1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 6, 138, 206);
                        break;
                      case '2':
                        $img = $dir_cert_path."/oblys/t-diplom2.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 96, 95, 95);
                        break;
                      case '3':
                        $img = $dir_cert_path."/oblys/t-diplom3.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 59, 175, 223);
                        break;
                      default:
                        $img = $dir_cert_path."/oblys/t-diplom1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 6, 138, 206);
                        break;
                }
                Header("Content-type: image/jpeg");
                $c_black = ImageColorAllocate($pic, 7, 7, 7);
                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $c_text = ImageColorAllocate($pic, 85, 83, 83);
                $c_dark = ImageColorAllocate($pic, 55, 54, 54);
                $c_blue = ImageColorAllocate($pic, 6, 36, 51);
                $c_db = ImageColorAllocate($pic, 8, 113, 168);
                $font = $font_dir.'/calibri/Calibri.ttf';
                $font_cam_reg = $font_dir.'/cambria/Cambria.ttf';
                $font_cambria = $font_dir.'/cambria/cambriab.ttf';
                $font_robotobold = $font_dir.'/roboto/Roboto-Bold.ttf';
                $font_cal_lg_it = $font_dir.'/calibri/Calibri-LightItalic.ttf';
                $font_cal_lg = $font_dir.'/calibri/Calibri-Light.ttf';
                $font_cal_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $font_cal_bold_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $info = $oblys.' бойынша '.$olimpname.'сының жеңімпазы '.$work;
                $end = 'марапатталады';
                $width = 2000;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1020;
                foreach ($text_b as $word) {
                    $btext = imagettfbbox(46.836, 0, $font, $text_new.' '.$word);
                    if($btext[2] > $width - $margin*2){
                        if($i <= 4){
                          $test[$i] = $text_new;
                          if($i-1 != -1){
                            $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                          }
                          else{
                            $q[$i] = $test[$i];
                          }
                          $i++;
                        }
                        $text_new = $text_new."\n".$word;
                        $kol++;
                    }
                    else {
                    $text_new .= " ".$word;
                    }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                $text_new = trim($text_new);
                $leftt = array();
                for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(46.836, 0, $font, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 46.836, 0, $leftt[$k], $h_info, $c_black, $font, $text_new);
                      break;
                    }
                    else{
                        $q[$k]=trim($q[$k]);
                        $box1 = imagettfbbox(46.836, 0, $font, $q[$k]);
                        $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                        $h_info+=70;
                        ImageTTFtext($pic, 46.836, 0, $leftt[$k], $h_info, $c_black, $font, $q[$k]);
                    }
                }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*50 + $h_info;
                }
                $h_end = $h_name + 100;
                $h_month = $h_end + 120;

                $box = imagettfbbox(63.75, 0, $font_cambria, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 63.75, 0, $left, $h_name, $c_name, $font_cambria, $username);

                $box2 = imagettfbbox(46.836, 0, $font_cal_lg_it, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 46.836, 0, $left2, $h_end, $c_black, $font, $end);

                $month = mb_strtoupper($month);
                $box4 = imagettfbbox(45, 0, $font, $month);
                #$left4 = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 45, 0, 1500, 1960, $c_text, $font_cal_lg_it, $month);

                $id1 = "№R-".$id;
                $id2 = "R-".$id;
                $box3 = imagettfbbox(45, 0, $font, $id1);
                $left3 = $center-round(($box3[2]-$box3[0])/2);
                ImageTTFtext($pic, 45, 0, $left3, 927, $c_blue, $font, $id1);

                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = 471-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 2310, $c_db, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 2080, 2260, $c_dark, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 2080, 2315, $c_dark, $font_robotobold, $id2);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
              }
         }
    }

    public function getSertificate($code){
        $otizim = OlimpiadaTizim::where('code', $code)->first();
        $obw = $otizim->obwcode;
        $okatysu = OlimpiadaKatysu::where('obwcode', $obw)->where('o_order_id', $otizim->o_order_id)->first();
        $katysushy = $okatysu->o_katysushy_idd;
        $obagyt = OlimpiadaBagyty::find($okatysu->o_bagyty_idd);
        $tury = OlimpiadaTury::find($okatysu->o_tury_idd);
        $oturnirmd = OlimpiadaTurnir::where('enable', 1)->first();

        $dir_cert_path = public_path(OlimpiadaTizim::CERTIFICATE_PATH);
        $font_dir = public_path('/fonts');

        $olimpname = $tury->o_tury;
        $username = $otizim->katysushy_name;
        $work = $otizim->katysushy_work;
        $kun = $okatysu->o_date;
        $datetime = new DateTime($kun);
        $year = $datetime->format('Y');
        $year = '«Зиаткерлік олимпиада - '.$year.'»';
        $month = $oturnirmd->o_turnir;
        $kol = 1;
        $date = date('d.m.Y');
        $id = $otizim->id;
        $ln = strlen($id);
        $z = '';
        $font = $font_dir.'/calibri/Calibri.ttf';
        $font_times = $font_dir.'/times-new-roman.ttf';
        $font_cam_reg = $font_dir.'/cambria/Cambria.ttf';
        $font_cambria = $font_dir.'/cambria/cambriab.ttf';
        $font_cam_it = $font_dir.'/cambria/cambriai.ttf';
        $font_robotobold = $font_dir.'/roboto/Roboto-Bold.ttf';
        $font_cal_lg_it = $font_dir.'/calibri/Calibri-LightItalic.ttf';
        $font_cal_lg = $font_dir.'/calibri/Calibri-Light.ttf';
        $font_cal_it = $font_dir.'/calibri/Calibri-Italic.ttf';
        $font_cal_bold_it = $font_dir.'/calibri/Calibri-Italic.ttf';
        for($i = $ln; $i<7;$i++){
            $z .= '0';
        }
        $oblys = OlimpiadaTurnir::getOblys($okatysu->oblysy);
        $id = $z.$id;
        $zhetekshisi = $okatysu->o_katysushy_fio;
        if($okatysu->o_oblis == 1){//Международная олимпиада
             $img_name = $id."-ustdip.jpg";
             if($katysushy == 1){
                 $center = 1272;
                 $img = $dir_cert_path.'/world/m-sertificate.jpg';
                 $pic = ImageCreateFromjpeg($img);
                $c_name = ImageColorAllocate($pic, 6, 146, 205);
                $c_text = ImageColorAllocate($pic, 7, 7, 7);
                $c_dark = ImageColorAllocate($pic, 55, 54, 54);
                $info = 'Халықаралық '.$olimpname.'ға '.$work;
                $end = '    қатысқандығын растайды';
                $width = 1800;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1635;
                $kol = 1;
                foreach ($text_b as $word) {
                    $btext = imagettfbbox(48.7875, 0, $font, $text_new.' '.$word);
                    if($btext[2] > $width - $margin*2){
                        if($i <= 4){
                          $test[$i] = $text_new;
                          if($i-1 != -1){
                            $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                          }
                          else{
                            $q[$i] = $test[$i];
                          }
                          $i++;
                        }
                        $text_new = $text_new."\n".$word;
                        $kol++;
                    }
                    else {
                    $text_new .= " ".$word;
                    }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                $text_new = trim($text_new);
                $leftt = array();
                for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(48.7875, 0, $font, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font, $text_new);
                      break;
                    }
                    else{
                        $q[$k]=trim($q[$k]);
                        $box1 = imagettfbbox(48.7875, 0, $font, $q[$k]);
                        $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                        $h_info+=70;
                        ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font, $q[$k]);
                    }
                }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*90 + $h_info;
                }
                $h_end = $h_name + 120;
                $h_month = $h_end + 120;

                $box = imagettfbbox(85.38, 0, $font_cambria, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 85.38, 0, $left, $h_name, $c_name, $font_cambria, $username);

                $box2 = imagettfbbox(48.7875, 0, $font_cal_lg_it, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 48.7875, 0, $left2, $h_end, $c_text, $font, $end);

                $month = mb_strtoupper($month);
                ImageTTFtext($pic, 40, 0, 376, 2752, $c_text, $font, $month);

                $id1 = "№X-".$id;
                $id2 = "X-".$id;

                $box3 = imagettfbbox(54.885, 0, $font_cal_lg_it, $id1);
                $left3 = $center-round(($box3[2]-$box3[0])/2);
                ImageTTFtext($pic, 54.885, 0, $left3, 1500, $c_text, $font, $id1);

                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = $center-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 884, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 908, 3048, $c_text, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 908, 3103, $c_text, $font_robotobold, $id2);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
             }else
             if($katysushy == 2){
                 $center = 1240;
                 $img = $dir_cert_path.'/world/s-sertificate.jpg';
                 $pic = ImageCreateFromjpeg($img);
                $c_name = ImageColorAllocate($pic, 16, 89, 119);
                $c_text = ImageColorAllocate($pic, 7, 7, 7);
                $c_dark = ImageColorAllocate($pic, 55, 54, 54);
                $info = 'Халықаралық '.$olimpname.'ға '.$work;
                $end = '    қатысқандығын растайды';
                $width = 1600;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1632;
                $kol = 1;
                foreach ($text_b as $word) {
                    $btext = imagettfbbox(48.7875, 0, $font, $text_new.' '.$word);
                    if($btext[2] > $width - $margin*2){
                        if($i <= 4){
                          $test[$i] = $text_new;
                          if($i-1 != -1){
                            $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                          }
                          else{
                            $q[$i] = $test[$i];
                          }
                          $i++;
                        }
                        $text_new = $text_new."\n".$word;
                        $kol++;
                    }
                    else {
                    $text_new .= " ".$word;
                    }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                $text_new = trim($text_new);
                $leftt = array();
                for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(48.7875, 0, $font, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font, $text_new);
                      break;
                    }
                    else{
                        $q[$k]=trim($q[$k]);
                        $box1 = imagettfbbox(48.7875, 0, $font, $q[$k]);
                        $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                        $h_info+=70;
                        ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font, $q[$k]);
                    }
                }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*90 + $h_info;
                }
                $h_end = $h_name + 120;
                $h_month = $h_end + 120;

                $box = imagettfbbox(85.38, 0, $font_cambria, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 85.38, 0, $left, $h_name, $c_name, $font_cambria, $username);

                $box2 = imagettfbbox(48.7875, 0, $font, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 48.7875, 0, $left2, $h_end, $c_text, $font, $end);

                $month = mb_strtoupper($month);
                $box4 = imagettfbbox(40, 0, $font, $month);
                $left4 = $center-round(($box4[2]-$box4[0])/2);
                ImageTTFtext($pic, 40, 0, $left4, 1032, $c_text, $font, $month);

                $id1 = "№X-".$id;
                $id2 = "X-".$id;

                $box3 = imagettfbbox(54.885, 0, $font, $id1);
                $left3 = $center-round(($box3[2]-$box3[0])/2);
                ImageTTFtext($pic, 54.885, 0, $left3, 1496, $c_text, $font, $id1);

                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = $center-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 880, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 883, 3079, $c_text, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 883, 3135, $c_text, $font_robotobold, $id2);
                ImageTTFtext($pic, 45, 0, 800, 2555, $c_text, $font_cal_lg_it, $zhetekshisi);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
             }else
             if($katysushy == 3){
                 $center = 1240;
                 $img = $dir_cert_path.'/world/o-sertificate.jpg';
                 $pic = ImageCreateFromjpeg($img);
                $c_name = ImageColorAllocate($pic, 35, 174, 235);
                $c_text = ImageColorAllocate($pic, 12, 12, 12);
                $c_dark = ImageColorAllocate($pic, 44, 44, 44);
                $info = 'Халықаралық '.$olimpname.'ға '.$work;
                $end = '    қатысқандығын растайды';
                $width = 1600;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1568;
                $kol = 1;
                foreach ($text_b as $word) {
                    $btext = imagettfbbox(48.7875, 0, $font_cal_lg_it, $text_new.' '.$word);
                    if($btext[2] > $width - $margin*2){
                        if($i <= 4){
                          $test[$i] = $text_new;
                          if($i-1 != -1){
                            $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                          }
                          else{
                            $q[$i] = $test[$i];
                          }
                          $i++;
                        }
                        $text_new = $text_new."\n".$word;
                        $kol++;
                    }
                    else {
                    $text_new .= " ".$word;
                    }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                $text_new = trim($text_new);
                $leftt = array();
                for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(48.7875, 0, $font_cal_lg_it, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font_cal_lg_it, $text_new);
                      break;
                    }
                    else{
                        $q[$k]=trim($q[$k]);
                        $box1 = imagettfbbox(48.7875, 0, $font_cal_lg_it, $q[$k]);
                        $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                        $h_info+=70;
                        ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font_cal_lg_it, $q[$k]);
                    }
                }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*90 + $h_info;
                }
                $h_end = $h_name + 120;
                $h_month = $h_end + 120;

                $box = imagettfbbox(85.38, 0, $font_cambria, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 85.38, 0, $left, $h_name, $c_name, $font_cambria, $username);

                $box2 = imagettfbbox(48.7875, 0, $font_cal_lg_it, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 48.7875, 0, $left2, $h_end, $c_text, $font_cal_lg_it, $end);

                $month = mb_strtoupper($month);
                $box4 = imagettfbbox(40, 0, $font, $month);
                $left4 = $center-round(($box4[2]-$box4[0])/2);
                ImageTTFtext($pic, 40, 0, $left4, 984, $c_text, $font, $month);

                $id1 = "№X-".$id;
                $id2 = "X-".$id;

                $box3 = imagettfbbox(54.885, 0, $font, $id1);
                $left3 = $center-round(($box3[2]-$box3[0])/2);
                ImageTTFtext($pic, 54.885, 0, $left3, 1412, $c_text, $font, $id1);

                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = $center-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 825, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 908, 3120, $c_dark, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 908, 3179, $c_dark, $font_robotobold, $id2);
                ImageTTFtext($pic, 45, 0, 710, 2570, $c_text, $font_cal_lg_it, $zhetekshisi);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
             }else
             if($katysushy == 4){
                 $center = 1240;
                 $img = $dir_cert_path.'/world/t-newsertificate.jpg';
                 $pic = ImageCreateFromjpeg($img);
                $c_name = ImageColorAllocate($pic, 127, 106, 97);
                $c_text = ImageColorAllocate($pic, 109, 93, 86);
                $c_dark = ImageColorAllocate($pic, 44, 44, 44);
                $info = 'Халықаралық '.$olimpname.'ға '.$work;
                $end = '    қатысқандығын растайды';
                $width = 1600;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1636;
                $kol = 1;
                foreach ($text_b as $word) {
                    $btext = imagettfbbox(48.7875, 0, $font_cal_lg_it, $text_new.' '.$word);
                    if($btext[2] > $width - $margin*2){
                        if($i <= 4){
                          $test[$i] = $text_new;
                          if($i-1 != -1){
                            $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                          }
                          else{
                            $q[$i] = $test[$i];
                          }
                          $i++;
                        }
                        $text_new = $text_new."\n".$word;
                        $kol++;
                    }
                    else {
                    $text_new .= " ".$word;
                    }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                $text_new = trim($text_new);
                $leftt = array();
                for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(48.7875, 0, $font_cal_lg_it, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font_cal_lg_it, $text_new);
                      break;
                    }
                    else{
                        $q[$k]=trim($q[$k]);
                        $box1 = imagettfbbox(48.7875, 0, $font_cal_lg_it, $q[$k]);
                        $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                        $h_info+=70;
                        ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font_cal_lg_it, $q[$k]);
                    }
                }
                if($kol == 1){
                    $h_name = $kol*120 + $h_info;
                }else{
                    $h_name = $kol*80 + $h_info;
                }
                $h_end = $h_name + 120;
                $h_month = $h_end + 120;

                $box = imagettfbbox(85.38, 0, $font_cal_it, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 85.38, 0, $left, $h_name, $c_name, $font_cal_it, $username);

                $box2 = imagettfbbox(48.7875, 0, $font_cal_lg_it, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 48.7875, 0, $left2, $h_end, $c_text, $font_cal_lg_it, $end);

                $month = mb_strtoupper($month);
                $box4 = imagettfbbox(40, 0, $font_cal_lg, $month);
                $left4 = $center-round(($box4[2]-$box4[0])/2);
                ImageTTFtext($pic, 40, 0, $left4, $h_month, $c_text, $font_cal_lg, $month);

                $id1 = "№X-".$id;
                $id2 = "X-".$id;

                $box3 = imagettfbbox(54.885, 0, $font, $id1);
                $left3 = $center-round(($box3[2]-$box3[0])/2);
                ImageTTFtext($pic, 54.885, 0, $left3, 1452, $c_text, $font, $id1);

                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = $center-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 825, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 912, 3049, $c_text, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 912, 3105, $c_text, $font_robotobold, $id2);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
             }
         }else
         if($okatysu->o_oblis == 2 || $okatysu->o_oblis == NULL || $okatysu->o_oblis == 0){//Республиканская олимпиада
             $img_name = $id."-ustdip.jpg";
             if($katysushy == 1){
                 $center = 1236;
                 $img = $dir_cert_path.'/republic/m-sertificate.jpg';
                 $pic = ImageCreateFromjpeg($img);
                $c_name = ImageColorAllocate($pic, 189, 145, 57);
                $c_text = ImageColorAllocate($pic, 109, 93, 86);
                $info = 'Республикалық '.$olimpname.'ға '.$work;
                $end = '    қатысқандығын растайды';
                $width = 1600;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1748;
                $kol = 1;
                foreach ($text_b as $word) {
                    $btext = imagettfbbox(48.7875, 0, $font_cal_lg_it, $text_new.' '.$word);
                    if($btext[2] > $width - $margin*2){
                        if($i <= 4){
                          $test[$i] = $text_new;
                          if($i-1 != -1){
                            $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                          }
                          else{
                            $q[$i] = $test[$i];
                          }
                          $i++;
                        }
                        $text_new = $text_new."\n".$word;
                        $kol++;
                    }
                    else {
                    $text_new .= " ".$word;
                    }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                $text_new = trim($text_new);
                $leftt = array();
                for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(48.7875, 0, $font_cal_lg_it, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font_cal_lg_it, $text_new);
                      break;
                    }
                    else{
                        $q[$k]=trim($q[$k]);
                        $box1 = imagettfbbox(48.7875, 0, $font_cal_lg_it, $q[$k]);
                        $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                        $h_info+=70;
                        ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font_cal_lg_it, $q[$k]);
                    }
                }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*90 + $h_info;
                }
                $h_end = $h_name + 120;
                $h_month = $h_end + 120;

                $box = imagettfbbox(85.38, 0, $font_cal_it, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 85.38, 0, $left, $h_name, $c_name, $font_cal_it, $username);

                $box2 = imagettfbbox(48.7875, 0, $font_cal_lg_it, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 48.7875, 0, $left2, $h_end, $c_text, $font_cal_lg_it, $end);

                $month = mb_strtoupper($month);
                $box4 = imagettfbbox(40, 0, $font_cal_lg, $month);
                $left4 = $center-round(($box4[2]-$box4[0])/2);
                ImageTTFtext($pic, 40, 0, $left4, $h_month, $c_text, $font_cal_lg, $month);

                $id1 = "№R-".$id;
                $id2 = "R-".$id;

                $box3 = imagettfbbox(53.885, 0, $font, $id1);
                $left3 = $center-round(($box3[2]-$box3[0])/2);
                ImageTTFtext($pic, 53.885, 0, $left3, 1592, $c_text, $font, $id1);

                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = $center-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 904, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 905, 3080, $c_text, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 905, 3136, $c_text, $font_robotobold, $id2);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
             }else
             if($katysushy == 2){
                 $center = 1304;
                 $img = $dir_cert_path.'/republic/s-sertificate.jpg';
                 $pic = ImageCreateFromjpeg($img);
                $c_name = ImageColorAllocate($pic, 129, 30, 159);
                $c_text = ImageColorAllocate($pic, 7, 7, 7);
                $c_dark = ImageColorAllocate($pic, 55, 54, 54);
                $info = 'Республикалық '.$olimpname.'ға '.$work;
                $end = '    қатысқандығын растайды';
                $width = 1600;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1778;
                $kol = 1;
                foreach ($text_b as $word) {
                    $btext = imagettfbbox(48.7875, 0, $font, $text_new.' '.$word);
                    if($btext[2] > $width - $margin*2){
                        if($i <= 4){
                          $test[$i] = $text_new;
                          if($i-1 != -1){
                            $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                          }
                          else{
                            $q[$i] = $test[$i];
                          }
                          $i++;
                        }
                        $text_new = $text_new."\n".$word;
                        $kol++;
                    }
                    else {
                    $text_new .= " ".$word;
                    }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                $text_new = trim($text_new);
                $leftt = array();
                for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(48.7875, 0, $font, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font, $text_new);
                      break;
                    }
                    else{
                        $q[$k]=trim($q[$k]);
                        $box1 = imagettfbbox(48.7875, 0, $font, $q[$k]);
                        $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                        $h_info+=70;
                        ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font, $q[$k]);
                    }
                }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*60 + $h_info;
                }
                $h_end = $h_name + 120;
                $h_month = $h_end + 120;

                $box = imagettfbbox(85.38, 0, $font_cambria, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 85.38, 0, $left, $h_name, $c_name, $font_cambria, $username);

                $box2 = imagettfbbox(48.7875, 0, $font, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 48.7875, 0, $left2, $h_end, $c_text, $font, $end);

                $month = mb_strtoupper($month);
                $box4 = imagettfbbox(40, 0, $font_cal_lg, $month);
                $left4 = $center-round(($box4[2]-$box4[0])/2);
                ImageTTFtext($pic, 40, 0, 732, 2832, $c_text, $font_cal_lg, $month);

                $id1 = "№R-".$id;
                $id2 = "R-".$id;

                $box3 = imagettfbbox(54.885, 0, $font, $id1);
                $left3 = $center-round(($box3[2]-$box3[0])/2);
                ImageTTFtext($pic, 54.885, 0, $left3, 1636, $c_text, $font, $id1);

                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = $center-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 877, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 900, 3124, $c_text, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 900, 3174, $c_text, $font_robotobold, $id2);
                ImageTTFtext($pic, 45, 0, 890, 2577, $c_text, $font_cal_lg_it, $zhetekshisi);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
             }else
             if($katysushy == 3){
                 $center = 1766;
                 $img = $dir_cert_path.'/republic/o-sertificate.jpg';
                 $pic = ImageCreateFromjpeg($img);
                $c_name = ImageColorAllocate($pic, 77, 195, 130);
                $c_text = ImageColorAllocate($pic, 4, 3, 3);
                $c_dark = ImageColorAllocate($pic, 55, 54, 54);
                $info = 'Республикалық '.$olimpname.'ға '.$work;
                $end = '    қатысқандығын растайды';
                $width = 2000;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 984;
                $kol = 1;
                foreach ($text_b as $word) {
                    $btext = imagettfbbox(48.7875, 0, $font, $text_new.' '.$word);
                    if($btext[2] > $width - $margin*2){
                        if($i <= 4){
                          $test[$i] = $text_new;
                          if($i-1 != -1){
                            $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                          }
                          else{
                            $q[$i] = $test[$i];
                          }
                          $i++;
                        }
                        $text_new = $text_new."\n".$word;
                        $kol++;
                    }
                    else {
                    $text_new .= " ".$word;
                    }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                $text_new = trim($text_new);
                $leftt = array();
                for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(48.7875, 0, $font, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font, $text_new);
                      break;
                    }
                    else{
                        $q[$k]=trim($q[$k]);
                        $box1 = imagettfbbox(48.7875, 0, $font, $q[$k]);
                        $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                        $h_info+=70;
                        ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font, $q[$k]);
                    }
                }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*70 + $h_info;
                }
                $h_end = $h_name + 120;
                $h_month = $h_end + 120;

                $box = imagettfbbox(85.38, 0, $font_cal_lg_it, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 85.38, 0, $left, $h_name, $c_name, $font_cal_lg_it, $username);

                $box2 = imagettfbbox(48.7875, 0, $font, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 48.7875, 0, $left2, $h_end, $c_text, $font, $end);

                $month = mb_strtoupper($month);
                $box4 = imagettfbbox(40, 0, $font, $month);
                $left4 = 898-round(($box4[2]-$box4[0])/2);
                ImageTTFtext($pic, 40, 0, $left4, 1889, $c_text, $font, $month);

                $id1 = "№R-".$id;
                $id2 = "R-".$id;

                $box3 = imagettfbbox(54.885, 0, $font, $id1);
                $left3 = $center-round(($box3[2]-$box3[0])/2);
                ImageTTFtext($pic, 54.885, 0, $left3, 837, $c_name, $font, $id1);

                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = 897-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 2287, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 1737, 2232, $c_dark, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 1737, 2285, $c_dark, $font_robotobold, $id2);
                ImageTTFtext($pic, 45, 0, 1565, 1885, $c_text, $font_cal_lg_it, $zhetekshisi);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
             }else
             if($katysushy == 4){
                 $center = 1580;
                 $img = $dir_cert_path.'/republic/t-sertificate.jpg';
                 $pic = ImageCreateFromjpeg($img);
                $c_name = ImageColorAllocate($pic, 70, 157, 230);
                $c_text = ImageColorAllocate($pic, 87, 86, 86);
                $c_dark = ImageColorAllocate($pic, 55, 54, 54);
                $info = 'Республикалық '.$olimpname.'ға '.$work;
                $end = '    қатысқандығын растайды';
                $width = 1800;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1220;
                $kol = 1;
                foreach ($text_b as $word) {
                $btext = imagettfbbox(46.836, 0, $font, $text_new.' '.$word);
                if($btext[2] > $width - $margin*2){
                    if($i <= 4){
                      $test[$i] = $text_new;
                      if($i-1 != -1){
                        $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                      }
                      else{
                        $q[$i] = $test[$i];
                      }
                      $i++;
                    }
                    $text_new = $text_new."\n".$word;
                    $kol++;
                }
                else {
                $text_new .= " ".$word;
                }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                  $text_new = trim($text_new);
                  $leftt = array();
                  for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(46.836, 0, $font, $text_new);
                      $leftt[$k] = 2*$center-round(($box1[2]));
                      ImageTTFtext($pic, 46.836, 0, $leftt[$k], $h_info, $c_text, $font, $text_new);
                      break;
                  }
                  else{
                      $q[$k]=trim($q[$k]);
                      $box1 = imagettfbbox(46.836, 0, $font, $q[$k]);
                      $leftt[$k] = 2*$center-round(($box1[2]));
                      $h_info+=70;
                      ImageTTFtext($pic, 46.836, 0, $leftt[$k], $h_info, $c_text, $font, $q[$k]);
                    }
                  }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*40 + $h_info;
                }
                $h_end = $h_name + 120;
                $h_month = $h_end + 120;

                $box = imagettfbbox(63.75, 0, $font_cambria, $username);
                $left = 2*$center-round(($box[2]));
                ImageTTFtext($pic, 63.75, 0, $left, $h_name, $c_name, $font_cambria, $username);

                $box2 = imagettfbbox(46.836, 0, $font, $end);
                $left2 = 2*$center-round(($box[2])/1.644);
                ImageTTFtext($pic, 46.836, 0, $left2, $h_end, $c_text, $font, $end);

                $month = mb_strtoupper($month);
                $box4 = imagettfbbox(45, 0, $font_cal_it, $month);
                $left4 = $center-round(($box4[2])/2);
                ImageTTFtext($pic, 45, 0, 1645, 2076, $c_text, $font_cal_it, $month);

                $id1 = "№R-".$id;
                $id2 = "R-".$id;
                $box3 = imagettfbbox(54, 0, $font, $id1);
                ImageTTFtext($pic, 54, 0, 2760, 1086, $c_text, $font, $id1);
                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = 1209-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 2367, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 2138, 2340, $c_dark, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 2138, 2397, $c_dark, $font_robotobold, $id2);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
             }
         }else
         if($okatysu->o_oblis == 3){//Областная олимпиада
             $img_name = $id."-ustdip.jpg";
             if($katysushy == 1){
                 $center = 1752;
                 $img = $dir_cert_path.'/oblys/m-sertificate.jpg';
                 $pic = ImageCreateFromjpeg($img);
                $c_name = ImageColorAllocate($pic, 1, 85, 152);
                $c_dark = ImageColorAllocate($pic, 55, 54, 54);
                $c_text = ImageColorAllocate($pic, 87, 86, 86);
                $info = $oblys.' бойынша '.$olimpname.'ға '.$work;
                $end = '    қатысқандығын растайды';
                $width = 2400;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1020;
                $kol = 1;
                foreach ($text_b as $word) {
                    $btext = imagettfbbox(48.7875, 0, $font, $text_new.' '.$word);
                    if($btext[2] > $width - $margin*2){
                        if($i <= 4){
                          $test[$i] = $text_new;
                          if($i-1 != -1){
                            $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                          }
                          else{
                            $q[$i] = $test[$i];
                          }
                          $i++;
                        }
                        $text_new = $text_new."\n".$word;
                        $kol++;
                    }
                    else {
                    $text_new .= " ".$word;
                    }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                $text_new = trim($text_new);
                $leftt = array();
                for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(48.7875, 0, $font, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font, $text_new);
                      break;
                    }
                    else{
                        $q[$k]=trim($q[$k]);
                        $box1 = imagettfbbox(48.7875, 0, $font, $q[$k]);
                        $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                        $h_info+=70;
                        ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font, $q[$k]);
                    }
                }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*90 + $h_info;
                }
                $h_end = $h_name + 120;
                $h_month = $h_end + 120;

                $box = imagettfbbox(85.38, 0, $font_cal_it, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 85.38, 0, $left, $h_name, $c_name, $font_cal_it, $username);

                $box2 = imagettfbbox(48.7875, 0, $font, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 48.7875, 0, $left2, $h_end, $c_text, $font, $end);

                $month = mb_strtoupper($month);
                ImageTTFtext($pic, 40, 0, 1503, 1950, $c_text, $font, $month);

                $id2 = "O-".$id;

                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = 1191-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 2260, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 2090, 2232, $c_dark, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 2090, 2289, $c_dark, $font_robotobold, $id2);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
             }else
             if($katysushy == 2){
                 $center = 1787;
                 $img = $dir_cert_path.'/oblys/s-sertificate.jpg';
                 $pic = ImageCreateFromjpeg($img);
                $c_name = ImageColorAllocate($pic, 0, 102, 135);
                $c_dark = ImageColorAllocate($pic, 55, 54, 54);
                $c_text = ImageColorAllocate($pic, 87, 86, 86);
                $info = $oblys.' бойынша '.$olimpname.'ға '.$work;
                $end = '    қатысқандығын растайды';
                $width = 2400;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1122;
                $kol = 1;
                foreach ($text_b as $word) {
                    $btext = imagettfbbox(48.7875, 0, $font, $text_new.' '.$word);
                    if($btext[2] > $width - $margin*2){
                        if($i <= 4){
                          $test[$i] = $text_new;
                          if($i-1 != -1){
                            $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                          }
                          else{
                            $q[$i] = $test[$i];
                          }
                          $i++;
                        }
                        $text_new = $text_new."\n".$word;
                        $kol++;
                    }
                    else {
                    $text_new .= " ".$word;
                    }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                $text_new = trim($text_new);
                $leftt = array();
                for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(48.7875, 0, $font, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font, $text_new);
                      break;
                    }
                    else{
                        $q[$k]=trim($q[$k]);
                        $box1 = imagettfbbox(48.7875, 0, $font, $q[$k]);
                        $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                        $h_info+=70;
                        ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font, $q[$k]);
                    }
                }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*90 + $h_info;
                }
                $h_end = $h_name + 120;
                $h_month = $h_end + 120;

                $box = imagettfbbox(85.38, 0, $font_cambria, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 85.38, 0, $left, $h_name, $c_name, $font_cambria, $username);

                $box2 = imagettfbbox(48.7875, 0, $font, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 48.7875, 0, $left2, $h_end, $c_text, $font, $end);

                $month = mb_strtoupper($month);
                $box4 = imagettfbbox(40, 0, $font, $month);
                $left4 = 465-round(($box4[2]-$box4[0])/2);
                ImageTTFtext($pic, 40, 0, $left4, 1887, $c_text, $font, $month);

                $id1 = "№O-".$id;
                $id2 = "O-".$id;

                $box3 = imagettfbbox(54.885, 0, $font, $id1);
                $left3 = 3236-round(($box3[2]-$box3[0])/2);
                ImageTTFtext($pic, 54.885, 0, $left3, 2379, $c_name, $font, $id1);

                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = 465-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 2315, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 1335, 2295, $c_dark, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 1335, 2349, $c_dark, $font_robotobold, $id2);
                ImageTTFtext($pic, 45, 0, 1149, 1955, $c_text, $font_cal_lg_it, $zhetekshisi);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
             }else
             if($katysushy == 3){
                 $center = 1754;
                 $img = $dir_cert_path.'/oblys/o-sertificate.jpg';
                 $pic = ImageCreateFromjpeg($img);
                $c_name = ImageColorAllocate($pic, 84, 155, 96);
                $c_dark = ImageColorAllocate($pic, 55, 54, 54);
                $c_text = ImageColorAllocate($pic, 87, 86, 86);
                $info = $oblys.' бойынша '.$olimpname.'ға '.$work;
                $end = '    қатысқандығын растайды';
                $width = 2400;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1095;
                $kol = 1;
                foreach ($text_b as $word) {
                    $btext = imagettfbbox(48.7875, 0, $font, $text_new.' '.$word);
                    if($btext[2] > $width - $margin*2){
                        if($i <= 4){
                          $test[$i] = $text_new;
                          if($i-1 != -1){
                            $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                          }
                          else{
                            $q[$i] = $test[$i];
                          }
                          $i++;
                        }
                        $text_new = $text_new."\n".$word;
                        $kol++;
                    }
                    else {
                    $text_new .= " ".$word;
                    }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                $text_new = trim($text_new);
                $leftt = array();
                for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(48.7875, 0, $font, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font, $text_new);
                      break;
                    }
                    else{
                        $q[$k]=trim($q[$k]);
                        $box1 = imagettfbbox(48.7875, 0, $font, $q[$k]);
                        $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                        $h_info+=70;
                        ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font, $q[$k]);
                    }
                }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*90 + $h_info;
                }
                $h_end = $h_name + 120;
                $h_month = $h_end + 120;

                $box = imagettfbbox(85.38, 0, $font_cal_it, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 85.38, 0, $left, $h_name, $c_name, $font_cal_it, $username);

                $box2 = imagettfbbox(48.7875, 0, $font, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 48.7875, 0, $left2, $h_end, $c_text, $font, $end);

                $month = mb_strtoupper($month);
                $box4 = imagettfbbox(40, 0, $font, $month);
                $left4 = 891-round(($box4[2]-$box4[0])/2);
                ImageTTFtext($pic, 40, 0, $left4, 1800, $c_text, $font, $month);

                $id1 = "№O-".$id;
                $id2 = "O-".$id;

                $box3 = imagettfbbox(54.885, 0, $font_robotobold, $id1);
                $left3 = $center-round(($box3[2]-$box3[0])/2);
                ImageTTFtext($pic, 54.885, 0, $left3, 975, $c_text, $font_robotobold, $id1);

                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = 891-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 2226, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 1796, 2200, $c_dark, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 1796, 2254, $c_dark, $font_robotobold, $id2);
                ImageTTFtext($pic, 45, 0, 1630, 1880, $c_text, $font_cal_lg_it, $zhetekshisi);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
             }else
             if($katysushy == 4){
                 $center = 2303;
                 $img = $dir_cert_path.'/oblys/t-sertificate.jpg';
                 $pic = ImageCreateFromjpeg($img);
                $c_name = ImageColorAllocate($pic, 230, 177, 66);
                $c_dark = ImageColorAllocate($pic, 55, 54, 54);
                $c_text = ImageColorAllocate($pic, 87, 86, 86);
                $info = $oblys.' бойынша '.$olimpname.'ға '.$work;
                $end = '    қатысқандығын растайды';
                $width = 2000;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1047;
                $kol = 1;
                foreach ($text_b as $word) {
                    $btext = imagettfbbox(48.7875, 0, $font, $text_new.' '.$word);
                    if($btext[2] > $width - $margin*2){
                        if($i <= 4){
                          $test[$i] = $text_new;
                          if($i-1 != -1){
                            $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                          }
                          else{
                            $q[$i] = $test[$i];
                          }
                          $i++;
                        }
                        $text_new = $text_new."\n".$word;
                        $kol++;
                    }
                    else {
                    $text_new .= " ".$word;
                    }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                $text_new = trim($text_new);
                $leftt = array();
                for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(48.7875, 0, $font, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font, $text_new);
                      break;
                    }
                    else{
                        $q[$k]=trim($q[$k]);
                        $box1 = imagettfbbox(48.7875, 0, $font, $q[$k]);
                        $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                        $h_info+=70;
                        ImageTTFtext($pic, 48.7875, 0, $leftt[$k], $h_info, $c_text, $font, $q[$k]);
                    }
                }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*60 + $h_info;
                }
                $h_end = $h_name + 120;
                $h_month = $h_end + 120;

                $box = imagettfbbox(85.38, 0, $font_cambria, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 85.38, 0, $left, $h_name, $c_name, $font_cambria, $username);

                $box2 = imagettfbbox(48.7875, 0, $font, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 48.7875, 0, $left2, $h_end, $c_text, $font, $end);

                $month = mb_strtoupper($month);
                $box4 = imagettfbbox(40, 0, $font_cal_it, $month);
                $left4 = 1800-round(($box4[2]-$box4[0])/2);
                ImageTTFtext($pic, 40, 0, $left4, 1965, $c_text, $font_cal_it, $month);

                $id1 = "№O-".$id;
                $id2 = "O-".$id;

                $box3 = imagettfbbox(54.885, 0, $font_robotobold, $id1);
                $left3 = $center-round(($box3[2]-$box3[0])/2);
                ImageTTFtext($pic, 54.885, 0, $left3, 912, $c_name, $font_robotobold, $id1);

                $c_db = ImageColorAllocate($pic, 9, 99, 137);
                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = 500-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 2262, $c_db, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 2078, 2259, $c_dark, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 2078, 2312, $c_dark, $font_robotobold, $id2);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
             }
         }
    }

    public function getAlgys($order_id, $type, $code){
        $okatysu = OlimpiadaKatysu::with('o_zhetekshi')->where('o_order_id', $order_id)->first();
        $katysushy = $okatysu->o_katysushy_idd;
        $obagyt = OlimpiadaBagyty::findOrFail($okatysu->o_bagyty_idd);
        $tury = OlimpiadaTury::findOrFail($okatysu->o_tury_idd);
        $oturnirmd = OlimpiadaTurnir::where('enable', 1)->first();
        $otizim = OlimpiadaTizim::where('code', $code)->first();

        $dir_cert_path = public_path(OlimpiadaTizim::CERTIFICATE_PATH);
        $font_dir = public_path('/fonts');

        $ida = $otizim->id;
        $lna = strlen($ida);
        $za = '';
        for($i = $lna; $i<7;$i++){
            $za .= '0';
        }
        $ida = $za.$ida;

        $olimpname = $tury->o_tury;
        $username = $okatysu->o_zhetekshi->name;
        $work = $okatysu->o_mekeme;
        $kun = $okatysu->o_date;
        $datetime = new DateTime($kun);
        $year = $datetime->format('Y');
        $year = '«Зиаткерлік олимпиада - '.$year.'»';
        $month = $oturnirmd->o_turnir;
        $kol = 1;
        $date = date('d.m.Y');
        $id = $okatysu->idd;
        $ln = strlen($id);
        $z = '';
        for($i = $ln; $i<7;$i++){
            $z .= '0';
        }
        $id = $z.$id;
        if($okatysu->o_oblis == 1){
            $img_name = $id."-ustdip.jpg";
            if($type == 1){
                 $center = 1752;
                $img = $dir_cert_path."/world/m-algys.jpg";
                $pic = ImageCreateFromjpeg($img);
                $c_name = ImageColorAllocate($pic, 76, 76, 78);
                $c_text = ImageColorAllocate($pic, 87, 86, 86);
                $c_dark = ImageColorAllocate($pic, 55, 54, 54);
                Header("Content-type: image/jpeg");
                $font = $font_dir.'/calibri/Calibri.ttf';
                $font_times = $font_dir.'/times-new-roman.ttf';
                $font_cam_reg = $font_dir.'/cambria/Cambria.ttf';
                $font_cambria = $font_dir.'/cambria/cambriab.ttf';
                $font_robotobold = $font_dir.'/roboto/Roboto-Bold.ttf';
                $font_cal_lg_it = $font_dir.'/calibri/Calibri-LightItalic.ttf';
                $font_cal_lg = $font_dir.'/calibri/Calibri-Light.ttf';
                $font_cal_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $font_cal_bold_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $info = 'Халықаралық '.$olimpname.'ға жеңімпаздарды дайындағаны үшін';
                $end = '    марапатталады';
                $width = 2000;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1050;
                $kol = 1;
                foreach ($text_b as $word) {
                    $btext = imagettfbbox(46.836, 0, $font, $text_new.' '.$word);
                    if($btext[2] > $width - $margin*2){
                        if($i <= 4){
                          $test[$i] = $text_new;
                          if($i-1 != -1){
                            $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                          }
                          else{
                            $q[$i] = $test[$i];
                          }
                          $i++;
                        }
                        $text_new = $text_new."\n".$word;
                        $kol++;
                    }
                    else {
                    $text_new .= " ".$word;
                    }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                $text_new = trim($text_new);
                $leftt = array();
                for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(46.836, 0, $font, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 46.836, 0, $leftt[$k], $h_info, $c_text, $font, $text_new);
                      break;
                    }
                    else{
                        $q[$k]=trim($q[$k]);
                        $box1 = imagettfbbox(46.836, 0, $font, $q[$k]);
                        $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                        $h_info+=70;
                        ImageTTFtext($pic, 46.836, 0, $leftt[$k], $h_info, $c_text, $font, $q[$k]);
                    }
                }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*90 + $h_info;
                }
                $h_end = $h_name + 120;
                $h_month = $h_end + 120;

                $box = imagettfbbox(127.5, 0, $font_times, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 127.5, 0, $left, $h_name, $c_name, $font_times, $username);

                $box2 = imagettfbbox(46.836, 0, $font_cal_lg_it, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 46.836, 0, $left2, $h_end, $c_text, $font, $end);

                $month = mb_strtoupper($month);
                $box4 = imagettfbbox(40, 0, $font_cal_lg_it, $month);
                #$left4 = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 40, 0, 1500, 1923, $c_text, $font_cal_lg_it, $month);

                $id1 = "№ZH-".$id;
                $id2 = "ZH-".$id;

                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = 894-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 2187, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 1686, 2223, $c_dark, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 1686, 2278, $c_dark, $font_robotobold, $id2);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
            }else
            if($type == 2){
                $center = 1772;
                $otizim = OTizimModel::find()->where(['code'=>$code])->one();

                $balaname = $otizim->katysushy_name;
                $img = $dir_cert_path."/world/ataana-algys.jpg";
                $pic = ImageCreateFromjpeg($img);
                $c_name = ImageColorAllocate($pic, 189, 153, 55);
                $c_text = ImageColorAllocate($pic, 87, 86, 86);
                $c_dark = ImageColorAllocate($pic, 55, 54, 54);
                Header("Content-type: image/jpeg");
                $font = $font_dir.'/calibri/Calibri.ttf';
                $font_times = $font_dir.'/times-new-roman.ttf';
                $font_cam_reg = $font_dir.'/cambria/Cambria.ttf';
                $font_cambria = $font_dir.'/cambria/cambriab.ttf';
                $font_robotobold = $font_dir.'/roboto/Roboto-Bold.ttf';
                $font_cal_lg_it = $font_dir.'/calibri/Calibri-LightItalic.ttf';
                $font_cal_lg = $font_dir.'/calibri/Calibri-Light.ttf';
                $font_cal_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $font_cal_bold_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $width = 2000;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1164;
                $info = 'Балаңыз, '.$balaname;

                $box = imagettfbbox(63.75, 0, $font_times, $info);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 63.75, 0, $left, $h_info, $c_name, $font_times, $info);

                $month = mb_strtoupper($month);
                ImageTTFtext($pic, 45, 0, 1515, 1914, $c_text, $font, $month);

                $id2 = "A-".$ida;

                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = 860-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 2202, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 1686, 2223, $c_dark, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 1686, 2278, $c_dark, $font_robotobold, $id2);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
            }
        }else
        if($okatysu->o_oblis == 2  || $okatysu->o_oblis == NULL || $okatysu->o_oblis == 0){
            $img_name = $id."-ustdip.jpg";
            if($type == 1){
                 $center = 1775;
                $img = $dir_cert_path."/republic/m-algys.jpg";
                $pic = ImageCreateFromjpeg($img);
                $c_name = ImageColorAllocate($pic, 76, 76, 78);
                $c_text = ImageColorAllocate($pic, 87, 86, 86);
                $c_dark = ImageColorAllocate($pic, 55, 54, 54);
                Header("Content-type: image/jpeg");
                $font = $font_dir.'/calibri/Calibri.ttf';
                $font_times = $font_dir.'/times-new-roman.ttf';
                $font_cam_reg = $font_dir.'/cambria/Cambria.ttf';
                $font_cambria = $font_dir.'/cambria/Cambria-BoldItalic.ttf';
                $font_robotobold = $font_dir.'/roboto/Roboto-Bold.ttf';
                $font_cal_lg_it = $font_dir.'/calibri/Calibri-LightItalic.ttf';
                $font_cal_lg = $font_dir.'/calibri/Calibri-Light.ttf';
                $font_cal_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $font_cal_bold_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $info = 'Республикалық '.$olimpname.'ға жеңімпаздарды дайындағаны үшін';
                $end = '    марапатталады';
                $width = 2000;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1050;
                $kol = 1;
                foreach ($text_b as $word) {
                    $btext = imagettfbbox(46.836, 0, $font, $text_new.' '.$word);
                    if($btext[2] > $width - $margin*2){
                        if($i <= 4){
                          $test[$i] = $text_new;
                          if($i-1 != -1){
                            $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                          }
                          else{
                            $q[$i] = $test[$i];
                          }
                          $i++;
                        }
                        $text_new = $text_new."\n".$word;
                        $kol++;
                    }
                    else {
                    $text_new .= " ".$word;
                    }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                $text_new = trim($text_new);
                $leftt = array();
                for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(46.836, 0, $font, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 46.836, 0, $leftt[$k], $h_info, $c_text, $font, $text_new);
                      break;
                    }
                    else{
                        $q[$k]=trim($q[$k]);
                        $box1 = imagettfbbox(46.836, 0, $font, $q[$k]);
                        $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                        $h_info+=70;
                        ImageTTFtext($pic, 46.836, 0, $leftt[$k], $h_info, $c_text, $font, $q[$k]);
                    }
                }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*90 + $h_info;
                }
                $h_end = $h_name + 120;
                $h_month = $h_end + 120;

                $box = imagettfbbox(127.5, 0, $font_times, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 127.5, 0, $left, $h_name, $c_name, $font_times, $username);

                $box2 = imagettfbbox(46.836, 0, $font_cal_lg_it, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 46.836, 0, $left2, $h_end, $c_text, $font, $end);

                $month = mb_strtoupper($month);
                $box4 = imagettfbbox(40, 0, $font, $month);
                ImageTTFtext($pic, 40, 0, 1500, 1923, $c_text, $font, $month);

                $id2 = "ZH-".$id;

                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = 878-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 2187, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 1686, 2223, $c_dark, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 1686, 2278, $c_dark, $font_robotobold, $id2);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
            }else
            if($type == 2){
                $center = 1772;
                $otizim = OTizimModel::find()->where(['code'=>$code])->one();
                $balaname = $otizim->katysushy_name;
                $img = $dir_cert_path."/republic/ataana-algys.jpg";
                $pic = ImageCreateFromjpeg($img);
                $c_name = ImageColorAllocate($pic, 189, 153, 55);
                $c_text = ImageColorAllocate($pic, 87, 86, 86);
                $c_dark = ImageColorAllocate($pic, 55, 54, 54);
                Header("Content-type: image/jpeg");
                $font = $font_dir.'/calibri/Calibri.ttf';
                $font_times = $font_dir.'/times-new-roman.ttf';
                $font_cam_reg = $font_dir.'/cambria/Cambria.ttf';
                $font_cambria = $font_dir.'/cambria/Cambria-BoldItalic.ttf';
                $font_robotobold = $font_dir.'/roboto/Roboto-Bold.ttf';
                $font_cal_lg_it = $font_dir.'/calibri/Calibri-LightItalic.ttf';
                $font_cal_lg = $font_dir.'/calibri/Calibri-Light.ttf';
                $font_cal_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $font_cal_bold_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $width = 2000;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1060;
                $info = 'Балаңыз, '.$balaname;

                $box = imagettfbbox(63.75, 0, $font_times, $info);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 63.75, 0, $left, $h_info, $c_name, $font_times, $info);

                $month = mb_strtoupper($month);
                ImageTTFtext($pic, 40, 0, 1515, 1914, $c_text, $font, $month);

                $id2 = "A-".$ida;

                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = 858-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 2202, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 1686, 2223, $c_dark, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 1686, 2278, $c_dark, $font_robotobold, $id2);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
            }
        }else
        if($okatysu->o_oblis == 3){
            $img_name = $id."-ustdip.jpg";
            $oblys = OTurnirModel::getOblys($okatysu->oblysy);
            if($type == 1){
                 $center = 1754;
                $img = $dir_cert_path."/oblys/m-algys.jpg";
                $pic = ImageCreateFromjpeg($img);
                $c_name = ImageColorAllocate($pic, 76, 76, 78);
                $c_text = ImageColorAllocate($pic, 87, 86, 86);
                $c_dark = ImageColorAllocate($pic, 55, 54, 54);
                Header("Content-type: image/jpeg");
                $font = $font_dir.'/calibri/Calibri.ttf';
                $font_times = $font_dir.'/times-new-roman.ttf';
                $font_cam_reg = $font_dir.'/cambria/Cambria.ttf';
                $font_cambria = $font_dir.'/cambria/Cambria-BoldItalic.ttf';
                $font_robotobold = $font_dir.'/roboto/Roboto-Bold.ttf';
                $font_cal_lg_it = $font_dir.'/calibri/Calibri-LightItalic.ttf';
                $font_cal_lg = $font_dir.'/calibri/Calibri-Light.ttf';
                $font_cal_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $font_cal_bold_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $info = $oblys.' бойынша '.$olimpname.'ға жеңімпаздарды дайындағаны үшін';
                $end = '    марапатталады';
                $width = 2000;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_info = 1050;
                $kol = 1;
                foreach ($text_b as $word) {
                    $btext = imagettfbbox(46.836, 0, $font, $text_new.' '.$word);
                    if($btext[2] > $width - $margin*2){
                        if($i <= 4){
                          $test[$i] = $text_new;
                          if($i-1 != -1){
                            $q[$i] = str_replace($test[$i-1],'',$test[$i]);
                          }
                          else{
                            $q[$i] = $test[$i];
                          }
                          $i++;
                        }
                        $text_new = $text_new."\n".$word;
                        $kol++;
                    }
                    else {
                    $text_new .= " ".$word;
                    }
                }
                if($i-1 != -1){
                    $q[$i] = str_replace($test[$i-1],'',$text_new);
                }
                $text_new = trim($text_new);
                $leftt = array();
                for($k = 0;$k<=$i; $k++){
                    if(!$q[0]){
                      $box1 = imagettfbbox(46.836, 0, $font, $text_new);
                      $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                      ImageTTFtext($pic, 46.836, 0, $leftt[$k], $h_info, $c_text, $font, $text_new);
                      break;
                    }
                    else{
                        $q[$k]=trim($q[$k]);
                        $box1 = imagettfbbox(46.836, 0, $font, $q[$k]);
                        $leftt[$k] = $center-round(($box1[2]-$box1[0])/2);
                        $h_info+=70;
                        ImageTTFtext($pic, 46.836, 0, $leftt[$k], $h_info, $c_text, $font, $q[$k]);
                    }
                }
                if($kol == 1){
                    $h_name = $kol*100 + $h_info;
                }else{
                    $h_name = $kol*90 + $h_info;
                }
                $h_end = $h_name + 120;
                $h_month = $h_end + 120;

                $box = imagettfbbox(127.5, 0, $font_times, $username);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 127.5, 0, $left, $h_name, $c_name, $font_times, $username);

                $box2 = imagettfbbox(46.836, 0, $font_cal_lg_it, $end);
                $left2 = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 46.836, 0, $left2, $h_end, $c_text, $font, $end);

                $month = mb_strtoupper($month);
                $box4 = imagettfbbox(40, 0, $font, $month);
                ImageTTFtext($pic, 40, 0, 1500, 1923, $c_text, $font, $month);

                $id2 = "ZH-".$id;

                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = 897-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 2187, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 1686, 2172, $c_dark, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 1686, 2227, $c_dark, $font_robotobold, $id2);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
            }else
            if($type == 2){
                $center = 1772;
                $otizim = OTizimModel::find()->where(['code'=>$code])->one();
                $balaname = $otizim->katysushy_name;
                $img = $dir_cert_path."/oblys/ataana-algys.jpg";
                $pic = ImageCreateFromjpeg($img);
                $c_name = ImageColorAllocate($pic, 189, 153, 55);
                $c_text = ImageColorAllocate($pic, 87, 86, 86);
                $c_dark = ImageColorAllocate($pic, 55, 54, 54);
                Header("Content-type: image/jpeg");
                $font = $font_dir.'/calibri/Calibri.ttf';
                $font_times = $font_dir.'/times-new-roman.ttf';
                $font_cam_reg = $font_dir.'/cambria/Cambria.ttf';
                $font_cambria = $font_dir.'/cambria/Cambria-BoldItalic.ttf';
                $font_robotobold = $font_dir.'/roboto/Roboto-Bold.ttf';
                $font_cal_lg_it = $font_dir.'/calibri/Calibri-LightItalic.ttf';
                $font_cal_lg = $font_dir.'/calibri/Calibri-Light.ttf';
                $font_cal_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $font_cal_bold_it = $font_dir.'/calibri/Calibri-Italic.ttf';
                $width = 2000;
                $margin = 15;
                $text_b = explode(' ',$info);
                $text_new = '';
                $test = array();
                $i = 0;
                $h_name = 1130;
                $h_info = $h_name + 100;
                $info = $oblys.' бойынша олимпиадаға қатысып,';
                $bala = 'Балаңыз, '.$balaname;

                $box = imagettfbbox(63.75, 0, $font_times, $bala);
                $left = $center-round(($box[2]-$box[0])/2);
                ImageTTFtext($pic, 63.75, 0, $left, $h_name, $c_name, $font_times, $bala);

                $box2 = imagettfbbox(48.7875, 0, $font, $info);
                $left = $center-round(($box2[2]-$box2[0])/2);
                ImageTTFtext($pic, 48.7875, 0, $left, $h_info, $c_text, $font, $info);

                $month = mb_strtoupper($month);
                ImageTTFtext($pic, 40, 0, 1182, 1905, $c_text, $font, $month);

                $id2 = "A-".$ida;

                $c_white = ImageColorAllocate($pic, 251, 252, 252);
                $boxyear = imagettfbbox(22.5, 0, $font_robotobold, $year);
                $leftyear = 822-round(($boxyear[2]-$boxyear[0])/2);
                ImageTTFtext($pic, 22.5, 0, $leftyear, 2175, $c_white, $font_robotobold, $year);

                ImageTTFtext($pic, 27.2125, 0, 1675, 2164, $c_dark, $font_robotobold, $date);
                ImageTTFtext($pic, 27.2125, 0, 1675, 2220, $c_dark, $font_robotobold, $id2);
                if (!Storage::disk('public')->exists(OlimpiadaTizim::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(OlimpiadaTizim::CERTIFICATE_PATH);
                }
                Imagejpeg($pic,Storage::disk('public')->path(OlimpiadaTizim::CERTIFICATE_PATH)."/".$img_name);
                ImageDestroy($pic);
                return $img_name;
            }
        }
    }
}
