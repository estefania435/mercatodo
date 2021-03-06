<?php

namespace App\Jobs;

use App\MercatodoModels\Pay;
use App\Repositories\Pay\PaymentRepository;
use App\Repositories\Pay\PlaceToPayRepository;
use App\Repositories\Pay\ConectionPTPRepository;
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
        $p = new ConectionPTPRepository();
        $paymen = new PlaceToPayRepository($p);
        $reference = $this->paymen->reference;
        $res = $paymen->consultPayJob($reference);
        $actualiza = new PaymentRepository();
        $actualiza->updateDatesJob($res);
    }
}
