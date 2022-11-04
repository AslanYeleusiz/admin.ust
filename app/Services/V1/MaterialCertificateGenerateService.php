<?php


namespace App\Services\V1;

use App\Models\Material;
use Illuminate\Support\Facades\Storage;

class MaterialCertificateGenerateService
{
        private static $center = 1750;

        public static function getCertificate($material): string
        {
                $number = str_pad($material->id, 5, '0', STR_PAD_LEFT);
                $certificateName = '№ CRA-' . $number . ".jpg";

                //     if (self::isCertificateExists($certificateName)) {
                //         return Storage::disk('public')->url(Material::CERTIFICATE_PATH . "/" . $certificateName) ;
                //     }

                $path = public_path('/fonts/Gilroy');
                $fontGilroyBold = $path . '/Gilroy-Bold.ttf';
                $fontGilroyMedium = $path . '/Gilroy-Medium.ttf';
                $fontGilroySemibold = $path . '/Gilroy-Semibold.ttf';

                $pathTemplateImg = public_path('images/certificates/materials/Certificate.jpg');
                $pic = ImageCreateFromjpeg($pathTemplateImg);
                $colorBlack = imagecolorallocate($pic, 0x00, 0x00, 0x00);

                Header("Content-type: image/jpeg");
                //certificate number
                self::printWords($pic, explode('.', $certificateName)[0], $colorBlack, $fontGilroySemibold, 50, 1060, 3216, 282);


                //material title
                self::printWords($pic, '«' .  $material->title . '»', $colorBlack, $fontGilroySemibold, 57.75, 1300, 3216, 282, true);

                //User name
                self::printWords($pic, $material->author, $colorBlack, $fontGilroyMedium, 65, 1465, 2896, 603);

                // Date
                //     $box1 = imagettfbbox(63, 0, $fontPTSansReg, $newText);
                //     $center1 =  self::$center - (($box1[2] - $box1[0]) / 2);
                //     $leftt[$k] = self::$center - round(($box1[2] - $box1[0]) / 2);
                //     ImageTTFtext($pic, $fontSize, 0, $marginUserName, $heightData, $color, $font, $newText);
                ImageTTFtext($pic, 50, 0, 1500, 2281, $colorBlack, $fontGilroyBold, self::dmYKZ(now()) . ' ж.');

                if (!Storage::disk('public')->exists(Material::CERTIFICATE_PATH)) {
                        Storage::disk('public')->makeDirectory(Material::CERTIFICATE_PATH);
                }
                Imagejpeg($pic, Storage::disk('public')->path(Material::CERTIFICATE_PATH) . "/" . $certificateName);
                ImageDestroy($pic);
                return $certificateName;
        }
        public static function getHonor($material): string
        {
                $number = str_pad($material->id, 5, '0', STR_PAD_LEFT);
                $certificateName = '№ CRH-' . $number . ".jpg";

                //     if (self::isCertificateExists($certificateName)) {
                //         return Storage::disk('public')->url(Material::CERTIFICATE_PATH . "/" . $certificateName) ;
                //     }

                $path = public_path('/fonts/Gilroy');
                $fontGilroyBold = $path . '/Gilroy-Bold.ttf';
                $fontGilroyMedium = $path . '/Gilroy-Medium.ttf';
                $fontGilroySemibold = $path . '/Gilroy-Semibold.ttf';

                $pathTemplateImg = public_path('images/certificates/materials/Honor.jpg');
                $pic = ImageCreateFromjpeg($pathTemplateImg);
                $colorBlack = imagecolorallocate($pic, 0x00, 0x00, 0x00);

                Header("Content-type: image/jpeg");
                //certificate number
                self::printWords($pic, explode('.', $certificateName)[0], $colorBlack, $fontGilroySemibold, 50, 1030, 3216, 282);


                //User name
                self::printWords($pic, $material->user->full_name, $colorBlack, $fontGilroyMedium, 65, 1465, 2896, 603);

                // Date
                ImageTTFtext($pic, 50, 0, 1500, 2281, $colorBlack, $fontGilroyBold, self::dmYKZ(now()) . ' ж.');

                if (!Storage::disk('public')->exists(Material::CERTIFICATE_PATH)) {
                        Storage::disk('public')->makeDirectory(Material::CERTIFICATE_PATH);
                }
                Imagejpeg($pic, Storage::disk('public')->path(Material::CERTIFICATE_PATH) . "/" . $certificateName);
                ImageDestroy($pic);
                return $certificateName;
        }

        public static function getThankLetter($material): string
        {
                $number = str_pad($material->id, 5, '0', STR_PAD_LEFT);
                $certificateName = '№ CRT-' . $number . ".jpg";

                //     if (self::isCertificateExists($certificateName)) {
                //         return Storage::disk('public')->url(Material::CERTIFICATE_PATH . "/" . $certificateName) ;
                //     }

                $path = public_path('/fonts/Gilroy');
                $fontGilroyBold = $path . '/Gilroy-Bold.ttf';
                $fontGilroyMedium = $path . '/Gilroy-Medium.ttf';
                $fontGilroySemibold = $path . '/Gilroy-Semibold.ttf';

                $pathTemplateImg = public_path('images/certificates/materials/ThankLetter.jpg');
                $pic = ImageCreateFromjpeg($pathTemplateImg);
                $colorBlack = imagecolorallocate($pic, 0x00, 0x00, 0x00);

                Header("Content-type: image/jpeg");
                //certificate number
                self::printWords($pic, explode('.', $certificateName)[0], $colorBlack, $fontGilroySemibold, 50, 1035, 3216, 282);


                //User name
                self::printWords($pic, $material->user->full_name, $colorBlack, $fontGilroyMedium, 65, 1185, 2896, 603);

                // Date
                ImageTTFtext($pic, 50, 0, 1500, 2281, $colorBlack, $fontGilroyBold, self::dmYKZ(now()) . ' ж.');

                if (!Storage::disk('public')->exists(Material::CERTIFICATE_PATH)) {
                        Storage::disk('public')->makeDirectory(Material::CERTIFICATE_PATH);
                }
                Imagejpeg($pic, Storage::disk('public')->path(Material::CERTIFICATE_PATH) . "/" . $certificateName);
                ImageDestroy($pic);
                return $certificateName;
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
                return !empty($certificateName) && Storage::disk('public')->exists(Material::CERTIFICATE_PATH . "/" . $certificateName);
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
