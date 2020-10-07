<?php

namespace App\Jobs;

use App\MercatodoModels\Pay;
use App\Repositories\Pay\PayRepository;
use App\Repositories\Pay\PlaceToPayRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateStatusPay implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $paymen;

    /**
     * Create a new job instance.
     *
     * @param Pay $payment
     * @return void
     */
    public function __construct(Pay $payment)
    {
        $this->paymen = $payment;
    }

    /**
     *Execute the job for update status of pay.
     *
     */
    public function handle()
    {
        $paymen = new PlaceToPayRepository();

        $pay = Pay::where('status', 'PENDING')->first();
        $reference = $pay->reference;

        $res = $paymen->consultPayJob($reference);

        $actualiza = new PayRepository();
        $actualiza->updateDatesJob($res);
    }
}
