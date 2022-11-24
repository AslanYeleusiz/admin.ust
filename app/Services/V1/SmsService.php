<?php


namespace App\Services\V1;

use App\Exceptions\ErrorException;
use App\Models\SmsVerification;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

class SmsService
{
    public function send($msg, $phone)
    {
        $login = config('services.smsc.login');
        $password = config('services.smsc.password');
        try {
            $link = "https://smsc.kz/sys/send.php?login=$login&psw=$password&phones=+7" . $phone . '&mes=' . $msg . '&sender=ust.kz'; #$subdomain уже объявляли выше
            $curl = curl_init(); #Сохраняем дескриптор сеанса cURL
            #Устанавливаем необходимые опции для сеанса cURL
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, $link);
            curl_setopt($curl, CURLOPT_HEADER, false);
            $resText = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
            $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $res = curl_close($curl);

            if (str_contains($resText, 'ERROR')) {
                throw ValidationException::withMessages([
                    'sendSms' => [__('errors.internal_server_error')]
                ]);
            }
            return $resText;
            // Log::channel('sms')->error('$res sms ' . json_encode($res));
        } catch (ErrorException $errorException) {
            Log::channel('sms')->error('sms err ' . json_encode($errorException->getMessage()));
            throw new ErrorException("Ошибка");
        }
    }

    public function getSmsVerificationOrFail($phone)
    {
        $smsVerification = SmsVerification::where('phone', $phone)
            ->where('status', SmsVerification::STATUS_PENDING)
            ->latest() //show the latest if there are multiple
            ->firstOr(function () {
                throw new ErrorException(
                    __('errors.user.sms_not_found'),
                    Response::HTTP_NOT_FOUND
                );
            });
        return $smsVerification;
    }

    public function generateCode($length = 10)
    {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    public function checkLimitSms($phone)
    {
        $limitSmsCount = SmsVerification::phoneBy($phone)
            ->whereDate('created_at', '>=', now()->subMinutes(SmsVerification::LIMIT_SMS_MINUTE))
            ->count();
        if ($limitSmsCount >= SmsVerification::LIMIT_SMS) {
            throw new \App\Exceptions\ErrorException(__('errors.limited_sms'));
        }
    }
}
