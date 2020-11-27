<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ReportOrders;
use App\Http\Controllers\Controller;
use App\Repositories\Order\OrderRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    protected $orders;

    /**
     * AdminPayController constructor.
     *
     * @param OrderRepository $OrdersRepository
     */
    public function __construct(OrderRepository $OrdersRepository)
    {
        $this->orders = $OrdersRepository;
    }

    /**
     *list all orders
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $this->authorize('haveaccess', 'admin.order.index');

        $orders = $this->orders->getAllOrders($request);

        $request = $request->all();


        return view('admin.order.index', compact('orders', 'request'));
    }

    /**
     * show details of orders
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(int $id): RedirectResponse
    {
        $this->authorize('haveaccess', 'admin.order.show');
        $this->orders->seeOrder($id);

        return redirect('/admin/detail');
    }

    /**
     * report of products
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function reportOrder(Request $request): RedirectResponse
    {
        $this->orders->orderReport($request);

        return redirect()->back()->with('data', 'Reporte generado correctamente');
    }
}
