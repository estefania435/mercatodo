<?php

namespace App\Repositories\Pay;

use App\MercatodoModels\Order;
use App\MercatodoModels\Pay;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PayRepository extends BaseRepository
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
        $pay = Pay::pay()->first();
        $url= $pay->process_url;

        return $url;
    }

    /**
     * function to save payment details
     *
     * @param object $data
     */
    public function datas(object $data)
    {
        $order = Order::order()->Orwhere('status', 'REJECTED')->first();

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

    /**
     * function to update payment details
     *
     * @param object $dato
     */
    public function updateDates(object $dato)
    {
        $paymen = Pay::pay()->first();

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

    /**
     * function to view payment details
     *
     * @return \Illuminate\Database\Eloquent\Model
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
        $order = Order::order()->Orwhere('status', 'REJECTED')->first();
        $payer = Pay::all()->where('user_id', Auth::user()->id)->last();

        $order->status = $payer->status;
        $order->save();

        return $order;
    }

    /**
     * function to see payments for all orders
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function seeAllOrders(): Collection
    {
        return $this->getModel()->all()->where('user_id', Auth::user()->id);
    }
}
