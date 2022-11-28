<?php


namespace App\Services\V1\Turnir;

use Illuminate\Support\Facades\Storage;
use App\Models\TurnirUser;
use App\Models\Turnirs;

class TurnirCertificateGenerateService
{
    private static $center = 1750;

    public static function getDiplom($id, $diplom)
    {
        $turuser = TurnirUser::with(['turnir', 'user'])->find($id);
        $user = $turuser->user;
        $turnir = $turuser->turnir;
        $dir_cert_path = public_path(TurnirUser::CERTIFICATE_PATH);
        $font_dir = public_path('/fonts');

        $font_calibri_reg = $font_dir . '/calibri/Calibri.ttf';
        $font_calibri_bold = $font_dir . '/calibri/calibrib.ttf';
        $font_cambria_bold = $font_dir . '/cambria/cambriab.ttf';
        $font_cambria_reg = $font_dir . '/cambria/cambria.ttc';
        $font_source_reg = $font_dir . '/sourcesans/sourcereg.otf';
        $font_source_bold = $font_dir . '/sourcesans/sourcebold.otf';
        $font_source_light = $font_dir . '/sourcesans/sourcelight.otf';
        $font_times_roman = $font_dir . '/times-new-roman.ttf';
        $font_arial_reg = $font_dir . '/calibri/arial.ttf';
        $font_arial_bold = $font_dir . '/calibri/arialbd.ttf';
        $font_verdana_reg = $font_dir . '/verdana/verdana.ttf';
        $font_assylbek = $font_dir . '/assylbek/Asylbekm02shelley.Kz.ttf';

        if ($turnir->texttype == 0) $t_tp_t = 'пәнінен '; else $t_tp_t = '';

        $username = $turuser->fio_user;
        $work = $turuser->work_user;
        $turname = $turuser->turnir_name;
        $id = $turuser->id;
        $c = 0;
        $kol = 1;
        $zhetekshi = $turuser->zh_name;
        $turuser->order_id = substr($turuser->order_id, 0, 10);
        $day = date('d', $turuser->order_id);
        $year = date('Y', $turuser->order_id);
        $m = date('m', $turuser->order_id);

        switch ($m) {
            case '1':
                $monthname = 'қаңтар';
                break;
            case '2':
                $monthname = 'ақпан';
                break;
            case '3':
                $monthname = 'наурыз';
                break;
            case '4':
                $monthname = 'сәуір';
                break;
            case '5':
                $monthname = 'мамыр';
                break;
            case '6':
                $monthname = 'маусым';
                break;
            case '7':
                $monthname = 'шілде';
                break;
            case '8':
                $monthname = 'тамыз';
                break;
            case '9':
                $monthname = 'қыркүйек';
                break;
            case '10':
                $monthname = 'қазан';
                break;
            case '11':
                $monthname = 'қараша';
                break;
            case '12':
                $monthname = 'желтоқсан';
                break;
            default:
                $monthname = 'қаңтар';
                break;
        }
        $date = $day . ' ' . $monthname . ', ' . $year . ' жыл';
        if (strlen($id) < 7) {
            for ($i = 0; $i < 6 - strlen($id); $i++) {
                $c .= '0';
            }
            $id = $c . $id;
        }
        $id = 'T-' . $id;
        $number = '№' . $id;
        $img_name = $id . "-ustdip.jpg";
        if ($turnir->category == 1) {
            switch ($diplom) {
                case '1':
                    $img = $dir_cert_path . "/turnir/tarbie/3/1.jpg";
                    $pic = ImageCreateFromjpeg($img);
                    $c_name = ImageColorAllocate($pic, 217, 94, 8);
                    $hname = 2228;
                    $hdate = 2524;
                    $htext = 2004;
                    break;
                case '2':
                    $img = $dir_cert_path . "/turnir/tarbie/3/2.jpg";
                    $pic = ImageCreateFromjpeg($img);
                    $c_name = ImageColorAllocate($pic, 62, 148, 166);
                    $hname = 2296;
                    $hdate = 2604;
                    $htext = 2083;
                    break;
                case '3':
                    $img = $dir_cert_path . "/turnir/tarbie/3/3.jpg";
                    $pic = ImageCreateFromjpeg($img);
                    $c_name = ImageColorAllocate($pic, 48, 147, 106);
                    $hname = 2296;
                    $hdate = 2612;
                    $htext = 2075;
                    break;
                default:
                    $img = $dir_cert_path . "/turnir/tarbie/3/3.jpg";
                    $pic = ImageCreateFromjpeg($img);
                    $c_name = ImageColorAllocate($pic, 48, 147, 106);
                    $hname = 2296;
                    $hdate = 2612;
                    $htext = 2075;
                    break;
            }
            Header("Content-type: image/jpeg");
            $c_black = ImageColorAllocate($pic, 7, 7, 7);
            $width = 2480;
            $center = 1240;
            $margin = 500;
            $midtext = '"' . $turnir->name . '" тәрбиешілер арасындағы онлайн';

            $box = imagettfbbox(58.6, 0, $font_times_roman, $number);
            $left = $center - round(($box[2] - $box[0]) / 2);
            ImageTTFtext($pic, 58.6, 0, $left, 1225, $c_black, $font_times_roman, $number);

            $box = imagettfbbox(46.89, 0, $font_times_roman, $midtext);
            $left = $center - round(($box[2] - $box[0]) / 2);
            ImageTTFtext($pic, 46.89, 0, $left, $htext, $c_black, $font_times_roman, $midtext);

            $box = imagettfbbox(97.69, 0, $font_assylbek, $username);
            $left = $center - round(($box[2] - $box[0]) / 2);
            ImageTTFtext($pic, 97.69, 0, $left, $hname, $c_name, $font_assylbek, $username);

            $box = imagettfbbox(46.89, 0, $font_times_roman, $date);
            $left = $center - round(($box[2] - $box[0]) / 2);
            ImageTTFtext($pic, 46.89, 0, $left, $hdate, $c_black, $font_times_roman, $date);
            if (!Storage::disk('public')->exists(TurnirUser::CERTIFICATE_PATH)) {
                Storage::disk('public')->makeDirectory(TurnirUser::CERTIFICATE_PATH);
            }
            Imagejpeg($pic, Storage::disk('public')->path(TurnirUser::CERTIFICATE_PATH)."/" . $img_name);
            ImageDestroy($pic);
            return $img_name;
        } else
            if ($turnir->category == 2) {
                switch ($diplom) {
                    case '1':
                        $img = $dir_cert_path . "/turnir/ustaz/3/1.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 217, 94, 8);
                        $htext = 2008;
                        $hname = 2230;
                        $hdate = 2530;
                        break;
                    case '2':
                        $img = $dir_cert_path . "/turnir/ustaz/3/2.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 62, 148, 166);
                        $htext = 2084;
                        $hname = 2310;
                        $hdate = 2600;
                        break;
                    case '3':
                        $img = $dir_cert_path . "/turnir/ustaz/3/3.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 48, 147, 106);
                        $htext = 2068;
                        $hname = 2295;
                        $hdate = 2620;
                        break;
                    default:
                        $img = $dir_cert_path . "/turnir/ustaz/3/3.jpg";
                        $pic = ImageCreateFromjpeg($img);
                        $c_name = ImageColorAllocate($pic, 48, 147, 106);
                        $htext = 2068;
                        $hname = 2295;
                        $hdate = 2620;
                        break;
                }
                Header("Content-type: image/jpeg");
                $c_black = ImageColorAllocate($pic, 7, 7, 7);
                $width = 2480;
                $center = 1240;
                $margin = 500;

                $box = imagettfbbox(58.6, 0, $font_times_roman, $number);
                $left = $center - round(($box[2] - $box[0]) / 2);
                ImageTTFtext($pic, 58.6, 0, $left, 1225, $c_black, $font_times_roman, $number);

                $midtext = $turnir->name . ' ' . $t_tp_t . 'ұстаздар арасындағы онлайн';

                $box = imagettfbbox(46.89, 0, $font_times_roman, $midtext);
                $left = $center - round(($box[2] - $box[0]) / 2);
                ImageTTFtext($pic, 46.89, 0, $left, $htext, $c_black, $font_times_roman, $midtext);

                $box = imagettfbbox(97.69, 0, $font_assylbek, $username);
                $left = $center - round(($box[2] - $box[0]) / 2);
                ImageTTFtext($pic, 97.69, 0, $left, $hname, $c_name, $font_assylbek, $username);

                $box = imagettfbbox(46.89, 0, $font_times_roman, $date);
                $left = $center - round(($box[2] - $box[0]) / 2);
                ImageTTFtext($pic, 46.89, 0, $left, $hdate, $c_black, $font_times_roman, $date);

                if (!Storage::disk('public')->exists(TurnirUser::CERTIFICATE_PATH)) {
                    Storage::disk('public')->makeDirectory(TurnirUser::CERTIFICATE_PATH);
                }

                Imagejpeg($pic, Storage::disk('public')->path(TurnirUser::CERTIFICATE_PATH)."/" . $img_name);
                ImageDestroy($pic);
                return $img_name;
            } else
                if ($turnir->category == 3) {
                    switch ($diplom) {
                        case '1':
                            $img = $dir_cert_path . "/turnir/ustaz/3/1.jpg";
                            $pic = ImageCreateFromjpeg($img);
                            $c_name = ImageColorAllocate($pic, 217, 94, 8);
                            $htext = 2008;
                            $hname = 2230;
                            $hdate = 2530;
                            break;
                        case '2':
                            $img = $dir_cert_path . "/turnir/ustaz/3/2.jpg";
                            $pic = ImageCreateFromjpeg($img);
                            $c_name = ImageColorAllocate($pic, 62, 148, 166);
                            $htext = 2084;
                            $hname = 2310;
                            $hdate = 2600;
                            break;
                        case '3':
                            $img = $dir_cert_path . "/turnir/ustaz/3/3.jpg";
                            $pic = ImageCreateFromjpeg($img);
                            $c_name = ImageColorAllocate($pic, 48, 147, 106);
                            $htext = 2068;
                            $hname = 2295;
                            $hdate = 2620;
                            break;
                        default:
                            $img = $dir_cert_path . "/turnir/ustaz/3/3.jpg";
                            $pic = ImageCreateFromjpeg($img);
                            $c_name = ImageColorAllocate($pic, 48, 147, 106);
                            $htext = 2068;
                            $hname = 2295;
                            $hdate = 2620;
                            break;
                    }
                    Header("Content-type: image/jpeg");
                    $c_black = ImageColorAllocate($pic, 7, 7, 7);
                    $width = 2480;
                    $center = 1240;
                    $margin = 500;

                    $box = imagettfbbox(58.6, 0, $font_times_roman, $number);
                    $left = $center - round(($box[2] - $box[0]) / 2);
                    ImageTTFtext($pic, 58.6, 0, $left, 1225, $c_black, $font_times_roman, $number);

                    $midtext = $turnir->name . ' ' . $t_tp_t . 'оқушылар арасындағы онлайн';

                    $box = imagettfbbox(46.89, 0, $font_times_roman, $midtext);
                    $left = $center - round(($box[2] - $box[0]) / 2);
                    ImageTTFtext($pic, 46.89, 0, $left, $htext, $c_black, $font_times_roman, $midtext);

                    $box = imagettfbbox(97.69, 0, $font_assylbek, $username);
                    $left = $center - round(($box[2] - $box[0]) / 2);
                    ImageTTFtext($pic, 97.69, 0, $left, $hname, $c_name, $font_assylbek, $username);

                    $box = imagettfbbox(46.89, 0, $font_times_roman, $date);
                    $left = $center - round(($box[2] - $box[0]) / 2);
                    ImageTTFtext($pic, 46.89, 0, $left, $hdate, $c_black, $font_times_roman, $date);

                    if (!Storage::disk('public')->exists(TurnirUser::CERTIFICATE_PATH)) {
                        Storage::disk('public')->makeDirectory(TurnirUser::CERTIFICATE_PATH);
                    }

                    Imagejpeg($pic, Storage::disk('public')->path(TurnirUser::CERTIFICATE_PATH)."/" . $img_name);
                    ImageDestroy($pic);
                    return $img_name;
                } else
                    if ($turnir->category == 4) {
                        switch ($diplom) {
                            case '1':
                                $img = $dir_cert_path . "/turnir/student/3/1.jpg";
                                $pic = ImageCreateFromjpeg($img);
                                $c_name = ImageColorAllocate($pic, 217, 94, 8);
                                $htext = 2008;
                                $hname = 2292;
                                $hdate = 2592;
                                break;
                            case '2':
                                $img = $dir_cert_path . "/turnir/student/3/2.jpg";
                                $pic = ImageCreateFromjpeg($img);
                                $c_name = ImageColorAllocate($pic, 62, 148, 166);
                                $htext = 2084;
                                $hname = 2292;
                                $hdate = 2612;
                                break;
                            case '3':
                                $img = $dir_cert_path . "/turnir/student/3/3.jpg";
                                $pic = ImageCreateFromjpeg($img);
                                $c_name = ImageColorAllocate($pic, 48, 147, 106);
                                $htext = 2068;
                                $hname = 2300;
                                $hdate = 2650;
                                break;
                            default:
                                $img = $dir_cert_path . "/turnir/student/3/3.jpg";
                                $pic = ImageCreateFromjpeg($img);
                                $c_name = ImageColorAllocate($pic, 48, 147, 106);
                                $htext = 2068;
                                $hname = 2300;
                                $hdate = 2650;
                                break;
                        }
                        Header("Content-type: image/jpeg");
                        $c_black = ImageColorAllocate($pic, 7, 7, 7);
                        $width = 2480;
                        $center = 1240;
                        $margin = 500;

                        $box = imagettfbbox(58.6, 0, $font_times_roman, $number);
                        $left = $center - round(($box[2] - $box[0]) / 2);
                        ImageTTFtext($pic, 58.6, 0, $left, 1225, $c_black, $font_times_roman, $number);

                        $box = imagettfbbox(97.69, 0, $font_assylbek, $username);
                        $left = $center - round(($box[2] - $box[0]) / 2);
                        ImageTTFtext($pic, 97.69, 0, $left, $hname, $c_name, $font_assylbek, $username);

                        $box = imagettfbbox(46.89, 0, $font_times_roman, $date);
                        $left = $center - round(($box[2] - $box[0]) / 2);
                        ImageTTFtext($pic, 46.89, 0, $left, $hdate, $c_black, $font_times_roman, $date);

                        if (!Storage::disk('public')->exists(TurnirUser::CERTIFICATE_PATH)) {
                                Storage::disk('public')->makeDirectory(TurnirUser::CERTIFICATE_PATH);
                        }

                        Imagejpeg($pic, Storage::disk('public')->path(TurnirUser::CERTIFICATE_PATH)."/" . $img_name);
                        ImageDestroy($pic);
                        return $img_name;
                    }
    }

    public static function getSertificate($id)
    {
        $turuser = TurnirUser::with(['turnir', 'user'])->find($id);
        $user = $turuser->user;
        $turnir = $turuser->turnir;
        $dir_cert_path = public_path(TurnirUser::CERTIFICATE_PATH);
        $font_dir = public_path('/fonts');

        $font_calibri_reg = $font_dir . '/calibri/Calibri.ttf';
        $font_calibri_bold = $font_dir . '/calibri/calibrib.ttf';
        $font_cambria_bold = $font_dir . '/cambria/cambriab.ttf';
        $font_cambria_reg = $font_dir . '/cambria/cambria.ttc';
        $font_source_reg = $font_dir . '/sourcesans/sourcereg.otf';
        $font_source_bold = $font_dir . '/sourcesans/sourcebold.otf';
        $font_source_light = $font_dir . '/sourcesans/sourcelight.otf';
        $font_times_roman = $font_dir . '/times-new-roman.ttf';
        $font_arial_reg = $font_dir . '/calibri/arial.ttf';
        $font_arial_bold = $font_dir . '/calibri/arialbd.ttf';
        $font_verdana_reg = $font_dir . '/verdana/verdana.ttf';
        $font_assylbek = $font_dir . '/assylbek/Asylbekm02shelley.Kz.ttf';

        $username = $turuser->fio_user;
        $work = $turuser->work_user;
        $turname = $turuser->turnir_name;
        $id = $turuser->id;
        $c = 0;
        $kol = 1;
        $zhetekshi = $turuser->zh_name;
        $turuser->order_id = substr($turuser->order_id, 0, 10);
        $day = date('d', $turuser->order_id);
        $year = date('Y', $turuser->order_id);
        $m = date('m', $turuser->order_id);
        switch ($m) {
            case '1':
                $monthname = 'қаңтар';
                break;
            case '2':
                $monthname = 'ақпан';
                break;
            case '3':
                $monthname = 'наурыз';
                break;
            case '4':
                $monthname = 'сәуір';
                break;
            case '5':
                $monthname = 'мамыр';
                break;
            case '6':
                $monthname = 'маусым';
                break;
            case '7':
                $monthname = 'шілде';
                break;
            case '8':
                $monthname = 'тамыз';
                break;
            case '9':
                $monthname = 'қыркүйек';
                break;
            case '10':
                $monthname = 'қазан';
                break;
            case '11':
                $monthname = 'қараша';
                break;
            case '12':
                $monthname = 'желтоқсан';
                break;
            default:
                $monthname = 'қаңтар';
                break;
        }
        $date = $day . ' ' . $monthname . ', ' . $year . ' жыл';
        if (strlen($id) < 7) {
            for ($i = 0; $i < 6 - strlen($id); $i++) {
                $c .= '0';
            }
            $id = $c . $id;
        }
        $id = 'T-' . $id;
        $number = '№' . $id;
        $img_name = $id . "-ustdip.jpg";
        switch($turnir->category){
            case 1: {
                $img = $dir_cert_path . "/turnir/tarbie/3/cert.jpg";
                break;
            }
            case 2: {
                $img = $dir_cert_path . "/turnir/ustaz/3/cert.jpg";
                break;
            }
            case 3: {
                $img = $dir_cert_path . "/turnir/okushi/3/cert.jpg";
                break;
            }
            case 4: {
                $img = $dir_cert_path . "/turnir/student/3/cert.jpg";
                break;
            }
        }
        $pic = ImageCreateFromjpeg($img);
        $c_name = ImageColorAllocate($pic, 74, 20, 119);
        Header("Content-type: image/jpeg");
        $c_black = ImageColorAllocate($pic, 7, 7, 7);
        $c_gray = ImageColorAllocate($pic, 94, 90, 88);
        $width = 3500;
        $center = 1750;
        $margin = 700;

        $box = imagettfbbox(116.3, 0, $font_assylbek, $username);
        $left = $center - round(($box[2] - $box[0]) / 2);
        ImageTTFtext($pic, 116.3, 0, $left, 1615, $c_name, $font_assylbek, $username);

        $box = imagettfbbox(50.8, 0, $font_times_roman, $number);
        $left = $center - round(($box[2] - $box[0]) / 2);
        ImageTTFtext($pic, 50.8, 0, $left, 1195, $c_gray, $font_times_roman, $number);
        if (!Storage::disk('public')->exists(TurnirUser::CERTIFICATE_PATH)) {
                Storage::disk('public')->makeDirectory(TurnirUser::CERTIFICATE_PATH);
        }
        Imagejpeg($pic, Storage::disk('public')->path(TurnirUser::CERTIFICATE_PATH)."/". $img_name);
        ImageDestroy($pic);

        return $img_name;
    }

    public static function getAlgys($id)
    {
        $user = auth()->guard('api')->user();

        $turuser = TurnirUser::with('turnir')->findOrFail($id);

        $turnir = $turuser->turnir;

        $dir_cert_path = public_path(TurnirUser::CERTIFICATE_PATH);
        $font_dir = public_path('/fonts');

        $font_calibri_reg = $font_dir . '/calibri/Calibri.ttf';
        $font_calibri_bold = $font_dir . '/calibri/calibrib.ttf';
        $font_cambria_bold = $font_dir . '/cambria/cambriab.ttf';
        $font_cambria_reg = $font_dir . '/cambria/cambria.ttc';
        $font_source_reg = $font_dir . '/sourcesans/sourcereg.otf';
        $font_source_bold = $font_dir . '/sourcesans/sourcebold.otf';
        $font_source_light = $font_dir . '/sourcesans/sourcelight.otf';
        $font_times_roman = $font_dir . '/times-new-roman.ttf';
        $font_arial_reg = $font_dir . '/calibri/arial.ttf';
        $font_arial_bold = $font_dir . '/calibri/arialbd.ttf';
        $font_verdana_reg = $font_dir . '/verdana/verdana.ttf';
        $font_assylbek = $font_dir . '/assylbek/Asylbekm02shelley.Kz.ttf';

        $username = $turuser->zh_name;
        $work = ($turuser->zh_work) ? $turuser->zh_work : $turuser->zh_work;
        $turname = $turuser->turnir_name;
        $id = $turuser->id;
        $c = 0;
        $kol = 1;
        $zhetekshi = $turuser->zh_name;
        $turorder_id = substr($turuser->order_id, 0, 10);
        $m = date('m', $turorder_id);
        $day = date('d', $turorder_id);
        $year = date('Y', $turorder_id);

        switch ($m) {
            case '1':
                $monthname = 'қаңтар';
                break;
            case '2':
                $monthname = 'ақпан';
                break;
            case '3':
                $monthname = 'наурыз';
                break;
            case '4':
                $monthname = 'сәуір';
                break;
            case '5':
                $monthname = 'мамыр';
                break;
            case '6':
                $monthname = 'маусым';
                break;
            case '7':
                $monthname = 'шілде';
                break;
            case '8':
                $monthname = 'тамыз';
                break;
            case '9':
                $monthname = 'қыркүйек';
                break;
            case '10':
                $monthname = 'қазан';
                break;
            case '11':
                $monthname = 'қараша';
                break;
            case '12':
                $monthname = 'желтоқсан';
                break;
            default:
                $monthname = 'қаңтар';
                break;
        }
        if (strlen($id) < 7) {
            for ($i = 0; $i < 6 - strlen($id); $i++) {
                $c .= '0';
            }
            $id = $c . $id;
        }
        $date = $day . ' ' . $monthname . ', ' . $year . ' жыл';
        $id = 'T-' . $id;
        $number = '№' . $id;
        $img_name = $id . "-ustdip.jpg";

        $img = $dir_cert_path . "/turnir/algys/algys3.jpg";
        $pic = ImageCreateFromjpeg($img);
        $c_name = ImageColorAllocate($pic, 0, 99, 151);
        $c_dark = ImageColorAllocate($pic, 70, 69, 69);

        Header("Content-type: image/jpeg");

        $c_black = ImageColorAllocate($pic, 7, 7, 7);
        $width = 3500;
        $center = 1750;
        $margin = 500;

        $box = imagettfbbox(49.7, 0, $font_times_roman, $number);
        $left = $center - round(($box[2] - $box[0]) / 2);
        ImageTTFtext($pic, 49.7, 0, $left, 1015, $c_name, $font_times_roman, $number);

        $box = imagettfbbox(117.2, 0, $font_assylbek, $username);
        $left = $center - round(($box[2] - $box[0]) / 2);
        ImageTTFtext($pic, 117.2, 0, $left, 1464, $c_name, $font_assylbek, $username);

        $box = imagettfbbox(48.8, 0, $font_times_roman, $date);
        $left = $center - round(($box[2] - $box[0]) / 2);
        ImageTTFtext($pic, 48.8, 0, $left, 1785, $c_black, $font_times_roman, $date);

        if (!Storage::disk('public')->exists(TurnirUser::CERTIFICATE_PATH)) {
            Storage::disk('public')->makeDirectory(TurnirUser::CERTIFICATE_PATH);
        }
        Imagejpeg($pic, Storage::disk('public')->path(TurnirUser::CERTIFICATE_PATH)."/". $img_name);
        ImageDestroy($pic);

        return $img_name;
    }

    public static function dmYKZ($date)
    {
            $date = strtotime($date);
            $day = date('d', $date);
            $year = date('Y', $date);
            $month = date('m', $date);
            switch ($month) {
                    case 1:
                            $month = 'Қаңтар';
                            break;
                    case 2:
                            $month = 'Ақпан';
                            break;
                    case 3:
                            $month = 'Наурыз';
                            break;
                    case 4:
                            $month = 'Сәуір';
                            break;
                    case 5:
                            $month = 'Мамыр';
                            break;
                    case 6:
                            $month = 'Маусым';
                            break;
                    case 7:
                            $month = 'Шілде';
                            break;
                    case 8:
                            $month = 'Тамыз';
                            break;
                    case 9:
                            $month = 'Қырқүйек';
                            break;
                    case 10:
                            $month = 'Қазан';
                            break;
                    case 11:
                            $month = 'Қараша';
                            break;
                    case 12:
                            $month = 'Желтоқсан';
                            break;
            }
            return "{$day} {$month} {$year}";
    }

    private static function isCertificateExists($certificateName)
    {
            return !empty($certificateName) && Storage::disk('public')->exists(TurnirUser::CERTIFICATE_PATH . "/" . $certificateName);
    }

    public static function printWords($pic, $data, $color, $font, $fontSize, $heightData, $nameMaxLength, $marginUserName, $title = false)
    {
            $dataWords = explode(' ', $data);
            $path = public_path('/fonts/Gilroy');
            $fontGilroyMedium = $path . '/Gilroy-Medium.ttf';
            $newText = '';
            $test = [];
            $i = 0;
            $kol = 1;

            $q = null;
            foreach ($dataWords as $key => $word) {
                    $boxWord = imagettfbbox($fontSize, 0, $font, trim($newText . ' ' . $word));
                    if ($boxWord[2] > ($nameMaxLength - $marginUserName)) {
                            if ($i <= 4) {
                                    $test[$i] = $newText;
                                    if (isset($test[$i - 1])) {
                                            $q[$i] = str_replace($test[$i - 1], '', $test[$i]);
                                    } else {
                                            $q[$i] = $test[$i];
                                    }
                                    $i++;
                            }
                            $newText = $newText . "\n" . $word;
                            $kol++;
                    } else {
                            $newText .= " " . $word;
                    }
            }

            if (isset($test[$i - 1])) {
                    $q[$i] = str_replace($test[$i - 1], '', $newText);
            }
            $newText = trim($newText);
            $leftt = [];

            if ($kol > 1) {
                    $heightData = $heightData - $kol * 70;
            }

            for ($k = 0; $k <= $i; $k++) {

                    if (!isset($q[0])) {
                            $box1 = imagettfbbox($fontSize, 0, $font, $newText);
                            $leftt[$k] = self::$center - round(($box1[2] - $box1[0]) / 2);
                            ImageTTFtext($pic, $fontSize, 0, $leftt[$k], $heightData, $color, $font, $newText);
                    } else {
                            $q[$k] = trim($q[$k]);
                            $box1 = imagettfbbox($fontSize, 0, $font, $q[$k]);
                            $leftt[$k] = self::$center - round(($box1[2] - $box1[0]) / 2);
                            //                $heightData += $fontSize;
                            $heightData += 70;
                            ImageTTFtext($pic, $fontSize, 0, $leftt[$k], $heightData, $color, $font, trim($q[$k]));
                    }
                    if ($k == $i && $title) {
                            $text = 'атты мақаласын жариялағаны үшін';
                            $box1 = imagettfbbox($fontSize, 0, $font, $text);
                            $textLeft = self::$center - round(($box1[2] - $box1[0]) / 2);
                            $heightData += 70;
                            ImageTTFtext($pic, $fontSize, 0, $textLeft, $heightData, $color, $fontGilroyMedium, $text);
                    }
            }
    }
}
