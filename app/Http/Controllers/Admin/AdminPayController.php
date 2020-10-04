<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Pay\PayRepository;
use App\Repositories\Pay\PlaceToPayRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminPayController extends Controller
{
    protected $conection;
    protected $pays;

    /**
     * AdminPayController constructor.
     *
     * @param PlaceToPayRepository $conectionP
     * @param PayRepository $pay
     */
    public function __construct(PlaceToPayRepository $conectionP, PayRepository $pay)
    {
        $this->conection = $conectionP;
        $this->pays = $pay;
    }

    /**
     * function to connect to the payment gateway of place to pay
     *
     * @return RedirectResponse
     */
    public function pay(): RedirectResponse
    {
        $result = $this->conection->conectionPlaceToPay();
        $this->data($result);

        return redirect()->route('pay.reredirection');
    }

    /**
     * Method to redirect
     *
     * @return RedirectResponse
     */
    public function reredirection(): RedirectResponse
    {
        $url = $this->pays->redirect();

        return redirect()->to($url);
    }

    /**
     * Method to save payment details
     *
     * @param object $data
     */
    public function data(object $data)
    {
        $this->pays->datas($data);
    }

    /**
     * Method to obtain the data generated from the payment
     *
     * @param $reference
     * @return RedirectResponse
     */
    public function consult(int $reference): RedirectResponse
    {
        $res = $this->conection->consultPay($reference);
        $this->updatedata($res);

        return redirect()->route('pay.updateorderstatus');
    }

    /**
     * Method to update the payment details
     *
     * @param $dato
     */
    public function updatedata(object $dato)
    {
        $this->pays->updateDates($dato);
    }

    /**
     * Method to see the payment detail
     *
     * @return \Illuminate\View\View
     */
    public function show(): View
    {
        $payment = $this->pays->seePay();

        return view('product.estado', compact('payment'));
    }

    /**
     * Method to update order status
     *
     * @return RedirectResponse
     */
    public function updateorderstatus(): RedirectResponse
    {
        $this->pays->updateStatusOfOrder();

        return redirect()->route('pay.show');
    }

    /**
     * method to see all purchases made
     *
     * @return View
     */
    public function showallorders(): View
    {
        $Payments = $this->pays->seeAllOrders();

        return view('product.payments', compact('Payments'));
    }

    /**
     * method to retry failed payments
     *
     * @return RedirectResponse
     */
    public function repay(): RedirectResponse
    {
        return redirect()->route('pay.pay');
    }
}
