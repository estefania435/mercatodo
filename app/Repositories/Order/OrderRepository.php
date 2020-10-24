<?php

namespace App\Repositories\Order;

use App\MercatodoModels\Order;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
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
    public function getAllOrders(): Collection
    {
        $orders = Order::all();

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
}
