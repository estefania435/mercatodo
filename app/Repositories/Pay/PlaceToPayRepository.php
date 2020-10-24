<?php

namespace App\Repositories\Pay;

use App\MercatodoModels\Order;
use App\MercatodoModels\Pay;
use App\Repositories\BaseRepository;
use App\Repositories\Pay\ConectionPTPRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7;
use Illuminate\Support\Facades\Auth;
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

    protected $conection;

    /**
     * AdminPayController constructor.
     *
     * @param ConectionPTPRepository $conectionP
     * @param PaymentRepository $pay
     */
    public function __construct(ConectionPTPRepository $conection)
    {
        $this->conection = $conection;
    }

    /**
     * function to connect to the payment gateway of place to pay
     *
     * @return object
     */
    public function conectionPlaceToPay(): object
    {
        $p = Pay::inProcess()->first();

        if ($p)
        {
            $p->delete();
            $order = $this->getModel()->order()->Orwhere('status', 'REJECTED')->first();
            $total = $order->total;
            $reference = $order->id;
        }
        else {
            $order = $this->getModel()->order()->Orwhere('status', 'REJECTED')->first();

            $total = $order->total;
            $reference = $order->id;
        }



        $auth = $this->conection->conectioPlaceToPay();

        $amount =
            [
                "currency" => "COP",
                "total" => $total,
            ];

        $payment =
            [
                "reference" => $reference,
                "description" => "Pago básico de prueba",
                'amount' => $amount,
            ];

        $data =
            [
                'auth' => $auth,
                'payment' => $payment,
                "expiration" => date('c', strtotime("+15 minutes")),
                "returnUrl" => 'http://127.0.0.1:8000/pay/consultPayment/' . $reference,
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
        $pay = Pay::where('reference', $reference)->inProcess()->OrWhere('status', 'PENDING')->first();
        $pay->reference = $reference;
        $requestId = $pay->requestId;

        $auth = $this->conection->conectioPlaceToPay();

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

        $auth = $this->conection->conectioPlaceToPay();

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
