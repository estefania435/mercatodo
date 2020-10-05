<?php

namespace App\Repositories\Pay;

use App\MercatodoModels\Order;
use App\MercatodoModels\Pay;
use App\Repositories\BaseRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7;
use Illuminate\Support\Facades\Log;

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
        $secretKey = config('app.SECRET_KEY');
        $tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));
        $reference = $order->id;
        $total = $order->total;
        $auth =
            [

                'login' => config('app.LOGIN'),
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
                "expiration" => date('c', strtotime("+15 minutes")),
                "returnUrl" => 'http://127.0.0.1:8000/pay/consult/' . $reference,
                "ipAddress" => "127.0.0.1",
                "userAgent" => "PlacetoPay Sandbox",
            ];
        $url = 'https://test.placetopay.com/redirection/api/session/';

        $client = new Client([
            'headers' => ['Content-Type' => 'application/json'],
        ]);
        try {
            $response = $client->post($url, [
                'json' => $data,
            ]);

            $body = $response->getBody();
            $result = json_decode($response->getBody());

            return $result;
        } catch (RequestException $e) {
            Log::channel('contlog')->error("RequestException" .
                    Psr7\str($e->getResponse()));
        } catch (ServerException $e) {
            Log::channel('contlog')->error("ServerException" .
                    Psr7\str($e->getResponse()));
        } catch (BadResponseException $e) {
            Log::channel('contlog')->error("BadResponseException" .
                   Psr7\str($e->getResponse()));
        }
    }

    /**
     * function to check the details of the payment made
     *
     * @param int $reference
     * @return object
     */
    public function consultPay(int $reference): object
    {
        $pay = Pay::where('reference', $reference)->pay()->OrWhere('status', 'PENDING')->first();
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
        $secretKey = config('app.SECRET_KEY');
        $tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));
        $auth =
            [
                'login' => config('app.LOGIN'),
                'seed' => $seed,
                'nonce' => $nonceBase64,
                'tranKey' => $tranKey,

            ];

        $data =
            [
                'auth' => $auth,
                "expiration" => date('c', strtotime("+15 minutes")),
                "returnUrl" => 'http://127.0.0.1:8000/pay/updatedata/' . $reference,
                "ipAddress" => "127.0.0.1",
                "userAgent" => "PlacetoPay Sandbox",
            ];

        $url = 'https://test.placetopay.com/redirection/api/session/' . $requestId;

        $client = new Client([
            'headers' => ['Content-Type' => 'application/json'],
        ]);

        try {
            $response = $client->post($url, [
            'json' => $data, ]);

            $body = $response->getBody();
            $res = json_decode($response->getBody());
            Log::channel('contlog')->info("respuesta pago: " . $body);

            return $res;
        } catch (RequestException $e) {
            Log::channel('contlog')->error("RequestException" .
                Psr7\str($e->getResponse()));
        } catch (ServerException $e) {
            Log::channel('contlog')->error("ServerException" .
                Psr7\str($e->getResponse()));
        } catch (BadResponseException $e) {
            Log::channel('contlog')->error("BadResponseException" .
                Psr7\str($e->getResponse()));
        }
    }

    /**
     * function to check the details of the payment made after job
     *
     * @param int $reference
     * @return object
     */
    public function consultPayJob(int $reference): object
    {
        $pay = Pay::where('reference', $reference)->where('status', 'PENDING')->first();
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
        $secretKey = config('app.SECRET_KEY');
        $tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));
        $auth =
            [
                'login' => config('app.LOGIN'),
                'seed' => $seed,
                'nonce' => $nonceBase64,
                'tranKey' => $tranKey,

            ];

        $data =
            [
                'auth' => $auth,
                "expiration" => date('c', strtotime("+15 minutes")),
                "returnUrl" => 'http://127.0.0.1:8000/pay/updatedata/' . $reference,
                "ipAddress" => "127.0.0.1",
                "userAgent" => "PlacetoPay Sandbox",
            ];

        $url = 'https://test.placetopay.com/redirection/api/session/' . $requestId;

        $client = new Client([
            'headers' => ['Content-Type' => 'application/json'],
        ]);

        try {
            $response = $client->post($url, [
                'json' => $data, ]);

            $body = $response->getBody();
            $res = json_decode($response->getBody());
            Log::channel('contlog')->info("respuesta pago: " . $body);

            return $res;
        } catch (RequestException $e) {
            Log::channel('contlog')->error("RequestException" .
                Psr7\str($e->getResponse()));
        } catch (ServerException $e) {
            Log::channel('contlog')->error("ServerException" .
                Psr7\str($e->getResponse()));
        } catch (BadResponseException $e) {
            Log::channel('contlog')->error("BadResponseException" .
                Psr7\str($e->getResponse()));
        }
    }
}
