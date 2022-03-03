<?php


namespace App\Services\Acquiring;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\RequestOptions;

class Rshb
{
    /**
     * API
     */
    public const API = 'belaya.stroyka-api';

    private $password;

    public const DEV_PASSWORD = 'belaya.stroyka';

    public const PROD_PASSWORD = '';

    /** @var HttpClient $httpClient */
    private $httpClient;

    /**
     * Rshb constructor.
     */
    public function __construct()
    {
        // $this->password = config('app.debug') ? self::DEV_PASSWORD : self::PROD_PASSWORD;
        $this->password = self::DEV_PASSWORD;
        $this->httpClient = new HttpClient([
            //'base_uri' => config('app.debug') ? 'https://web.rbsuat.com' : '',
            'base_uri' => 'https://web.rbsuat.com',
        ]);
    }

    public function orderRegistration($orderId, $amount, $confirmOrderPaymentCode, $cancelOrderPaymentCode)
    {
        try {

            $response = $this->httpClient->post('/rshb/payment/rest/register.do', [
                'allow_redirects' => true,
                'port' => 443,
                RequestOptions::FORM_PARAMS => [
                    'userName' => self::API,
                    'password' => $this->password,
                    'orderNumber' => $this->getOrderNumber($orderId),
                    'amount' => $this->amount($amount),// Переводим рубли в копейки
                    'returnUrl' => route('order.confirm.payment', compact('confirmOrderPaymentCode')),
                    'failUrl' => route('order.cancel.payment', compact('cancelOrderPaymentCode')),
                ],
            ]);
        } catch (ServerException $e) {
            return false;
        } catch (GuzzleException $e) {
            return false;
        }

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param $amount
     * @return float|int
     */
    private function amount($amount)
    {
        return ((int)$amount * 100) + ($amount - (int)$amount);
    }

    /**
     * Create number order
     * @param integer $orderId
     * @return string
     */
    public function getOrderNumber($orderId): string
    {
        return str_pad($orderId, 9, '0', STR_PAD_LEFT);
    }

}
