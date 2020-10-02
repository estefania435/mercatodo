<?php

namespace App\Repositories\Pay;

use App\MercatodoModels\Order;
use App\MercatodoModels\Pay;
use App\Repositories\BaseRepository;
use GuzzleHttp\Client;

class PlaceToPayRepository extends BaseRepository
{
    /**
     * @return Order
     */
    public function getModel(): Order
    {
        return new Order();
    }

    /**
     * function to connect to the payment gateway of place to pay
     *
     * @return object
     */
    public function conectionPlaceToPay(): object
    {
        $order = $this->getModel()->order()->Orwhere('status', 'REJECTED')->first();

        if (function_exists('random_bytes')) {
            $nonce = bin2hex(random_bytes(16));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $nonce = bin2hex(openssl_random_pseudo_bytes(16));
        } else {
            $nonce = mt_rand();
        }

        $nonceBase64 = base64_encode($nonce);
        $seed = date('c');
        $secretKey = config('app.SECRET_KEY', '024h1IlD');
        $tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));
        $reference = $order->id;
        $total = $order->total;
        $auth =
            [

                'login' => config('app.LOGIN', '6dd490faf9cb87a9862245da41170ff2'),
                'seed' => $seed,
                'nonce' => $nonceBase64,
                'tranKey' => $tranKey,

            ];

        $amount =
            [
                "currency" => "COP",
                "total" => $total,
            ];

        $payment =
            [
                "reference" => $order->id,
                "description" => "Pago básico de prueba",
                'amount' => $amount,
            ];

        $data =
            [
                'auth' => $auth,
                'payment' => $payment,
                "expiration" => date('c', strtotime('+1 hour')),
                "returnUrl" => 'http://127.0.0.1:8000/pay/consult/' . $reference,
                "ipAddress" => "127.0.0.1",
                "userAgent" => "PlacetoPay Sandbox",
            ];
        $url = 'https://test.placetopay.com/redirection/api/session/';

        $client = new Client([
            'headers' => ['Content-Type' => 'application/json'],
        ]);

        $response = $client->post($url, [
            'json' => $data,
        ]);

        $body = $response->getBody();
        $result = json_decode($response->getBody());

        return $result;
    }

    /**
     * function to check the details of the payment made
     *
     * @param int $reference
     * @return object
     */
    public function consultPay(int $reference): object
    {
        $pay = Pay::where('reference', $reference)->pay()->first();
        $pay->reference = $reference;
        $requestId = $pay->requestId;

        if (function_exists('random_bytes')) {
            $nonce = bin2hex(random_bytes(16));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $nonce = bin2hex(openssl_random_pseudo_bytes(16));
        } else {
            $nonce = mt_rand();
        }

        $nonceBase64 = base64_encode($nonce);
        $seed = date('c');
        $secretKey = '024h1IlD';
        $tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));
        $auth =
            [
                'login' => '6dd490faf9cb87a9862245da41170ff2',
                'seed' => $seed,
                'nonce' => $nonceBase64,
                'tranKey' => $tranKey,

            ];

        $data =
            [
                'auth' => $auth,
                "expiration" => date('c', strtotime('+1 hour')),
                "returnUrl" => 'http://127.0.0.1:8000/pay/updatedata/' . $reference,
                "ipAddress" => "127.0.0.1",
                "userAgent" => "PlacetoPay Sandbox",
            ];

        $url = 'https://test.placetopay.com/redirection/api/session/' . $requestId;

        $client = new Client([
            'headers' => ['Content-Type' => 'application/json'],
        ]);

        $response = $client->post($url, [
            'json' => $data, ]);

        $body = $response->getBody();
        $res = json_decode($response->getBody());

        return $res;
    }
}
