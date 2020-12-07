<?php

namespace App\Repositories\Order;

use App\Exports\ReportOrders;
use App\Exports\ReportSales;
use App\Jobs\NotifyUserOfCompletedReport;
use App\MercatodoModels\Order;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class OrderRepository extends BaseRepository
{
    /**
     * @return Order
     */
    public function getModel(): Order
    {
        return new Order();
    }

    /**
     * function for show all orders
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllOrders(Request $request)
    {
        $status = $request->get('searchbystate');
        $date = $request->get('searchbydate');
        $orders = Order::statusorder($status)->dateorder($date)->paginate(10);

        return $orders;
    }

    /**
     * Function for see a order
     *
     * @param int $id
     */
    public function seeOrder(int $id): void
    {
        Session::put('order_id', $id);
    }

    /**
     * report of products
     *
     * @param Request $request
     * @return void
     */
    public function orderReport(Request $request): void
    {
        (new ReportOrders($request->all()))->queue('reportOrders.xlsx')->chain([
            new NotifyUserOfCompletedReport(request()->user()),
        ]);

        Log::channel('contlog')->info('El usuario ' .
            Auth::user()->name . ' ' . Auth::user()->surname . ' ' .
            'ha generado un reporte de ordenes');
    }

    public function saleReport(Request $request): void
    {
        (new ReportSales($request->all()))->queue('reportSales.xlsx')->chain([
            new NotifyUserOfCompletedReport(request()->user()),
        ]);

        Log::channel('contlog')->info('El usuario ' .
            Auth::user()->name . ' ' . Auth::user()->surname . ' ' .
            'ha generado un reporte de ventas');
    }
}
