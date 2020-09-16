<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MercatodoModels\Order;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\MercatodoModels\Pay;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;


class AdminPayController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     * @throws \Exception
     */
    public function pay()
    {
        $order = Order::where('user_id', Auth::user()->id)->where('status', '0')->Orwhere('status', 'REJECTED')->first();

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
        $reference = $order->id;
        $total = $order->total;
        $auth = array
        (
            'login' => '6dd490faf9cb87a9862245da41170ff2',
            'seed' => $seed,
            'nonce' => $nonceBase64,
            'tranKey' => $tranKey,

        );

        $amount = array
        (
            "currency" => "COP",
            "total" => $total
        );

        $payment = array
        (
            "reference" => $order->id,
            "description" => "Pago básico de prueba",
            'amount' => $amount
        );


        $data = array
        (
            'auth' => $auth,
            'payment' => $payment,
            "expiration" => date('c', strtotime('+1 hour')),
            "returnUrl" => 'http://127.0.0.1:8000/pay/consult/' . $reference,
            "ipAddress" => "127.0.0.1",
            "userAgent" => "PlacetoPay Sandbox"
        );
        $url = 'https://test.placetopay.com/redirection/api/session/';

        $client = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);
        try {

            $response = $client->post($url, [
                'json' => $data
            ]);

            $body = $response->getBody();
            $result = json_decode($response->getBody());
            $this->data($result);

            return redirect()->route('pay.reredirection');


        } catch (\Exception $e) {
            Log::channel('contlog')->error("pago" .
                "getMessage: " . $e->getMessage() .
                " - getFile: " . $e->getFile() .
                " - getLine: " . $e->getLine());
        }
    }

    public function reredirection()
    {
        $pay = Pay::where
        ('user_id', Auth::user()->id)->where('status', '0')->first();
        $url= $pay->process_url;

        return redirect()->to($url);
    }

    public function data($data)
    {
        $order = Order::where('user_id', Auth::user()->id)->where('status', '0')->Orwhere('status', 'REJECTED')->first();

        $paymen = new Pay();
        $paymen->status;
        $paymen->reference = $order->id;
        $paymen->requestId = $data->requestId;
        $paymen->process_url =$data->processUrl;
        $paymen->user_id = Auth::user()->id;
        $paymen->name;
        $paymen->surname;
        $paymen->document_type;
        $paymen->document;
        $paymen->email;
        $paymen->phone;
        $paymen->payment_method;
        $paymen->order_total = $order->total;
        $paymen->save();
    }

    public function consult($reference)
    {

        $pay = Pay::where('reference', $reference)->where
        ('user_id', Auth::user()->id)->where('status', '0')->first();
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
        $auth = array
        (
            'login' => '6dd490faf9cb87a9862245da41170ff2',
            'seed' => $seed,
            'nonce' => $nonceBase64,
            'tranKey' => $tranKey,

        );

        $data = array
        (
            'auth' => $auth,
            "expiration" => date('c', strtotime('+1 hour')),
            "returnUrl" => 'http://127.0.0.1:8000/pay/updatedata/' . $reference,
            "ipAddress" => "127.0.0.1",
            "userAgent" => "PlacetoPay Sandbox"
        );

        $url = 'https://test.placetopay.com/redirection/api/session/' . $requestId;

        $client = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);
        try {

            $response = $client->post($url, [
                'json' => $data]);

            $body = $response->getBody();
            $res = json_decode($response->getBody());
            $this->updatedata($res);

            return redirect()->route('pay.updateorderstatus');

            //return response($body);

        } catch (\Exception $e) {
            Log::channel('contlog')->error("pago" .
                "getMessage: " . $e->getMessage() .
                " - getFile: " . $e->getFile() .
                " - getLine: " . $e->getLine());
        }
    }

    public function updatedata($dato)
    {
        $paymen = Pay::where
        ('user_id', Auth::user()->id)->where('status', '0')->first();

        $paymen->status = $dato->status->status;
        $paymen->name = $dato->request->payer->name;
        $paymen->surname = $dato->request->payer->surname;
        $paymen->document_type = $dato->request->payer->documentType;
        $paymen->document = $dato->request->payer->document;
        $paymen->email = $dato->request->payer->email;
        $paymen->phone = $dato->request->payer->mobile;
        foreach ($dato->payment as $d) {
            $paymen->payment_method = $d->paymentMethod;
        }
        $paymen->save();
    }

    public function show()
    {
        $payment = Pay::all()->where
        ('user_id', Auth::user()->id)->last();

        return view('product.estado', compact('payment'));
    }

    public function updateorderstatus()
    {
        $order = Order::where('user_id', Auth::user()->id)->where('status', '0')->Orwhere('status', 'REJECTED')->first();
        $payer = Pay::all()->where('user_id', Auth::user()->id)->last();

        $order->status = $payer->status;
        $order->save();

        return redirect()->route('pay.show');
    }

}
