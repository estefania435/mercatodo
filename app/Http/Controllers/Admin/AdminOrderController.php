<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MercatodoModels\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminOrderController extends Controller
{
    /**
     * @var string[]
     */
    public $statusOrders = ['entregado', 'no entregado'];

    /**
     *list all orders
     *
     * @return \Illuminate\View\View
     */
    public function index(): \Illuminate\View\View
    {
        $orders = Order::all();

        return view('admin.order.index', compact('orders'));
    }

    /**
     * edit order
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit(int $id): \Illuminate\View\View
    {
        $order = Order::whereId($id)->first();

        return view('admin.order.edit', compact('order'));
    }

    /**
     * update order
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $order = Order::findOrfail($id);

        if ($request->status) {
            $order->status = 1;
        } else {
            $order->status = 0;
        }
        $order->save();

        return redirect()->route('admin.order.index');
    }

    /**
     * show details of orders
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(string $id): \Illuminate\Http\RedirectResponse
    {
        Session::put('order_id', $id);

        return redirect('/admin/detail');
    }
}
