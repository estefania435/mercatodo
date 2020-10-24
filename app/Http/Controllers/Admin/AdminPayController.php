<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Pay\PaymentRepository;
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
     * @param PaymentRepository $pay
     */
    public function __construct(PlaceToPayRepository $conectionP, PaymentRepository $pay)
    {
        $this->conection = $conectionP;
        $this->pays = $pay;
    }

    /**
     * function to connect to the payment gateway of place to pay
     *
     * @return RedirectResponse
     */
    public function createPay(): RedirectResponse
    {
        $result = $this->conection->conectionPlaceToPay();
        $this->dataOfOrder($result);

        return redirect()->route('pay.redirection');
    }

    /**
     * Method to redirect
     *
     * @return RedirectResponse
     */
    public function redirection(): RedirectResponse
    {
        $url = $this->pays->redirect();

        return redirect()->to($url);
    }

    /**
     * Method to save payment details
     *
     * @param object $data
     */
    public function dataOfOrder(object $data)
    {
        $this->pays->ordersData($data);
    }

    /**
     * Method to obtain the data generated from the payment
     *
     * @param $reference
     * @return RedirectResponse
     */
    public function consultPayment(int $reference): RedirectResponse
    {
        $res = $this->conection->consultPay($reference);
        $this->updateDataOfPay($res);

        return redirect()->route('pay.updateOrderStatus');
    }

    /**
     * Method to update the payment details
     *
     * @param $dato
     */
    public function updateDataOfPay(object $dato)
    {
        $this->pays->updatePay($dato);
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
    public function updateOrderStatus(): RedirectResponse
    {
        $this->pays->updateStatusOfOrder();

        return redirect()->route('pay.show');
    }

    /**
     * method to see all purchases made
     *
     * @return View
     */
    public function showAllOrders(): View
    {
        $Payments = $this->pays->seeAllOrders();

        return view('product.payments', compact('Payments'));
    }

    /**
     * method to retry failed payments
     *
     * @return RedirectResponse
     */
    public function retryPayment(): RedirectResponse
    {
        return redirect()->route('pay.createPay');
    }
}
