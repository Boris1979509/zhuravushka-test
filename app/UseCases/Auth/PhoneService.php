<?php


namespace App\UseCases\Auth;

use App\Services\Sms\SmsSender;
use Exception;
use Illuminate\Support\Carbon;

class PhoneService
{
    private $sms;
    public const ATTEMPTS = 3;
    public const TIMER = 60; // 60 sec.

    public function __construct(SmsSender $sms)
    {
        $this->sms = $sms;
    }

    public function request($phone)
    {
        $data = $this->getToken($phone, Carbon::now());
        if (isset($data['token']) && !config('app.debug')) {
            $this->sms->send($phone, $data['token']); // Send ...
        }
        return $data;
    }

    /**
     * @param string $phone
     * @param Carbon $now
     * @return bool | array
     * @throws Exception
     */
    private function getToken($phone, Carbon $now)
    {
        if (session('attempts') <= self::ATTEMPTS) {
            $i = 0;
            $phone_verify_token = (string)random_int(1000, 9999);
            $expire_token = $now->copy()->addSeconds(self::TIMER)->timestamp;

            if (session('expireToken') && session('expireToken') > $now->timestamp) {
                return ['status' => false, 'message' => __('Token is already requested')];
            } else {
                $i = session('attempts'); // number of attempts
                session([
                    'expireToken' => $expire_token,
                    'token' => $phone_verify_token,
                    'phone' => $phone,
                    'attempts' => ++$i,
                ]);
                return ['status' => true, 'token' => $phone_verify_token];
            }
        }
        return [
            'status' => false,
            'attempts' => true,
            'message' => __('The maximum number of attempts has been reached'),
        ];
    }

    /**
     * @param string $tokenClient
     * @return array|bool
     */
    public function verify($tokenClient)
    {
        if (session('token') === $tokenClient) {
            $data = [
                'verified' => true,
                'message' => __('Successful confirmation code')
            ];
            session($data);
            return $data;
        }
        $this->forget();
        return [
            'verified' => false,
            'message' => __('Invalid confirmation code'),
        ];
    }

    /**
     * Forget session
     */
    public function forget(): void
    {
        session()->forget([
            'expireToken',
            'token',
            'verified',
            'phone',
        ]);
    }

    /**
     * @param string $phone
     * @return string|string[]|null
     */
    public function filterPhone($phone)
    {
        return preg_replace('/[^0-9]/', '', $phone); //
    }

}
