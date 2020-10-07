<?php

namespace App\Repositories\Pay;

use App\Repositories\BaseRepository;

class ConectionPTPRepository extends BaseRepository
{
    public function getModel()
    {
    }

    /**
     * function to connect to the payment gateway of place to pay
     *
     * @return array
     */
    public function conectioPlaceToPay(): array
    {
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

        return $auth;
    }
}
