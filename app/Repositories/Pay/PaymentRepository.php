<?php

namespace App\Repositories\Pay;

use App\Jobs\UpdateStatusPay;
use App\MercatodoModels\Detail;
use App\MercatodoModels\Order;
use App\MercatodoModels\Pay;
use App\MercatodoModels\Product;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Cast\Object_;

class PaymentRepository extends BaseRepository
{
    /**
     * @return Pay
     */
    public function getModel(): Pay
    {
        return new Pay();
    }

    /**
     * function to redirect to the payment gateway
     *
     * @return string
     */
    public function redirect(): string
    {
        $pay = Pay::inProcess()->first();
        $url = $pay->process_url;

        return $url;
    }

    /**
     * function to save payment details
     *
     * @param object $data
     */
    public function ordersData(object $data): void
    {

        $order = Order::open()->rejected()->first();

            $paymen = new Pay();
            $paymen->status;
            $paymen->reference = $order->id;
            $paymen->requestId = $data->requestId;
            $paymen->process_url = $data->processUrl;
            $paymen->user_id = Auth::user()->id;
            $paymen->name;
            $paymen->surname;
            $paymen->document_type;
            $paymen->document;
            $paymen->email;
            $paymen->phone = Auth::user()->phone;
            $paymen->payment_method;
            $paymen->order_total = $order->total;
            $paymen->save();
    }

    /**
     * function to update payment details
     *
     * @param object $dato
     */
    public function updatePay(object $dato): void
    {

        $paymen = Pay::where('requestId', $dato->requestId)->first();

        $paymen->status = $dato->status->status;
        $paymen->name = $dato->request->payer->name;
        $paymen->surname = $dato->request->payer->surname;
        $paymen->document_type = $dato->request->payer->documentType;
        $paymen->document = $dato->request->payer->document;
        $paymen->email = $dato->request->payer->email;
        $paymen->phone = Auth::user()->phone;

        if ($dato->status->status == 'PENDING') {
            $paymen->payment_method = 'PENDING';

            UpdateStatusPay::dispatch($paymen);
        } else {
            foreach ($dato->payment as $d) {
                $paymen->payment_method = $d->paymentMethod;
            }
        }
        $paymen->save();


        Log::channel('contlog')->info('pago realizado por: ' .
            $paymen->name . ' ' . $paymen->surname . ' ' .
            'Con identificación' . ' ' . $paymen->document);
    }

    /**
     * function to update the payment details after executing the job
     *
     * @param object $dato
     * @return void
     */
    public function updateDatesJob(object $dato): void
    {
        $paymen = Pay::where('requestId', $dato->requestId)->pending()->first();

        $paymen->status = $dato->status->status;
        $paymen->name = $dato->request->payer->name;
        $paymen->surname = $dato->request->payer->surname;
        $paymen->document_type = $dato->request->payer->documentType;
        $paymen->document = $dato->request->payer->document;
        $paymen->email = $dato->request->payer->email;

        if ($dato->status->status == 'PENDING') {
            $paymen->payment_method = 'PENDING';

            UpdateStatusPay::dispatch($paymen)->delay(now()->addMinutes(10));
        } else {
            foreach ($dato->payment as $d) {
                $paymen->payment_method = $d->paymentMethod;
            }
        }
        $paymen->save();

        $order = Order::where('id', $paymen->reference)->first();
        $order->status = $paymen->status;
        $order->save();

        Log::channel('contlog')->info('pago realizado por: ' .
            $paymen->name . ' ' . $paymen->surname . ' ' .
            'Con identificación' . ' ' . $paymen->document);
    }

    /**
     * function to view payment details
     *
     * @return Model
     */
    public function seePay(): Model
    {
        return $this->getModel()->all()->where('user_id', Auth::user()->id)->last();
    }

    /**
     * function to update payment status
     *
     * @return string
     */
    public function updateStatusOfOrder(): string
    {
        $order = Order::open()->rejected()->Orwhere('status', '=', 'PENDING')->first();
        $payer = Pay::all()->where('reference', $order->id)->last();
        $order->status = $payer->status;
        $order->save();
        if ($order->status == 'APPROVED') {
            $detail = Detail::where('order_id', $order->id)->get();
            foreach ($detail as $d) {
                $product = Product::where('id', $d->products_id)->get();

                foreach ($product as $p) {
                    $p->quantity = $p->quantity - $d->quantity;
                    $p->save();
                }
            }
        }
        return $order;
    }

    /**
     * function to see payments for all orders
     *
     * @return Collection
     */
    public function seeAllOrders(): Collection
    {
        $c = 0;
        $pays = $this->getModel()->all()->where('user_id', Auth::user()->id);
        foreach ($pays as $p) {
            if ($this->countPays($p->reference) > 0 & $p->status == 'REJECTED') {
                $pays->forget($c);
            }
            $c += 1;
        }

        return $pays;
    }

    /**
     * function for count the payments of an user
     *
     * @param $reference
     * @return int
     */
    public function countPays(int $reference): int
    {
        $payments = $this->getModel()->all()->where('status', 'APPROVED')
            ->where('reference', $reference)->count();

        return $payments;
    }
}
