<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MercatodoModels\Detail;
use App\MercatodoModels\Order;
use App\MercatodoModels\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCartController extends Controller
{
    /**
     * show cart
     *
     * @return \Illuminate\View\View
     */
    public function show(): \Illuminate\View\View
    {
        $cart = Order::join('details', 'orders.id', '=', 'details.order_id')
            ->join('products', 'products.id', '=', 'details.products_id')
            ->join('images', 'images.imageable_id', '=', 'products.id')
            ->select(
                'products.id as id',
                'products.name as name',
                'products.slug as slug',
                'products.price as price',
                'details.quantity as quantity',
                'images.url as image'
            )
            ->where('orders.user_id', '=', Auth::user()->id)
            ->where('orders.status', '=', '0')->get();

        $total = $this->total();

        return view('product.cart', compact('cart', 'total'));
    }

    /**
     * add products to cart
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request): \Illuminate\Http\RedirectResponse
    {
        $order = Order::all()->where('user_id', Auth::user()->id)->first();

        if ($order != null) {
            $product = Product::find($request->id);
            $product->quantity = 1;
            $cart[$product->slug] = $product;

            $detailproduct = Detail::all()->where('order_id', $order->id)->where('products_id', $product->id)->first();
            if ($detailproduct == null) {
                $detail = new Detail();
                $detail->quantity = 1;
                $detail->products_id = $product->id;
                $detail->order_id = $order->id;
                $detail->save();
                $this->updateTotal($order, $this->total());
            }
        } else {
            $product = Product::find($request->id);
            $product->quantity = 1;
            $cart[$product->slug] = $product;

            $order = new Order();
            $order->code = time();
            $order->total = $this->total();
            $order->status = 0;
            $order->user_id = Auth::user()->id;
            $order->name_receive = Auth::user()->name;
            $order->surname = Auth::user()->surname;
            $order->address = Auth::user()->address;
            $order->phone = Auth::user()->phone;
            $order->save();

            foreach ($cart as $r) {
                $detail = new Detail();
                $detail->quantity = $r->quantity;
                $detail->products_id = $r->id;
                $detail->order_id = $order->id;
                $detail->save();
                $this->updateTotal($order, $this->total());
            }
        }

        return redirect()->route('cart.show');
    }

    /**
     * delete the product  of cart
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request): \Illuminate\Http\RedirectResponse
    {
        $product = Product::find($request->id);
        $order = Order::all()->where('status', '0')->where('user_id', Auth::user()->id)->first();
        $detailproduct = Detail::all()->where('order_id', $order->id)->where('products_id', $product->id)->first();
        $detailproduct->delete();

        return redirect()->route('cart.show');
    }

    /**
     * empty cart
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function trash(): \Illuminate\Http\RedirectResponse
    {
        $order = Order::all()->where('status', '0')->where('user_id', Auth::user()->id)->first();
        Detail::where('order_id', $order->id)->delete();
        Order::where('status', '0')->where('user_id', Auth::user()->id)->delete();

        return redirect()->route('home');
    }

    /**
     * update cart
     *
     * @param string $slug
     * @param int $quantity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(string $slug, int $quantity): \Illuminate\Http\RedirectResponse
    {
        $product = Product::where('slug', $slug)->first();
        $order = Order::all()->where('status', '0')
                             ->where('user_id', Auth::user()->id)->first();
        $detailproduct = Detail::all()->where('order_id', $order->id)
                                      ->where('products_id', $product->id)->first();

        $detailproduct->quantity = $quantity;
        $detailproduct->save();
        $this->updateTotal($order, $this->total());

        return redirect()->route('cart.show');
    }

    /**
     * calculate total
     *
     * @return float
     */
    private function total(): float
    {
        $cart = Order::join('details', 'orders.id', '=', 'details.order_id')
            ->join('products', 'products.id', '=', 'details.products_id')
            ->select('products.price as price', 'details.quantity as quantity')
            ->where('orders.user_id', '=', Auth::user()->id)
            ->where('orders.status', '=', '0')
            ->get();
        $total = 0;
        foreach ($cart as $item) {
            $total += $item->price * $item->quantity;
        }

        return $total;
    }

    /**
     * modify the shipping data
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function Datesreceive(Request $request): \Illuminate\View\View
    {
        $order = Order::all()->where('status', '0')->where('user_id', Auth::user()->id)->first();
        $order->name_receive = $request->name_receive;
        $order->surname = $request->surname;
        $order->address = $request->address;
        $order->phone = $request->phone;
        $order->save();

        return view('product.pay', compact('order'));
    }

    /**
     * update total
     *
     * @param Order $order
     * @param float $total
     */
    private function updateTotal(Order $order, float $total)
    {
        $order->total = $total;
        $order->save();
    }

    /**
     * show the order detail
     *
     * @return \Illuminate\View\View
     */
    public function orderDetail(): \Illuminate\View\View
    {
        $cart = Order::join('details', 'orders.id', '=', 'details.order_id')
            ->join('products', 'products.id', '=', 'details.products_id')
            ->select(
                'products.id as id',
                'products.name as name',
                'products.price as price',
                'details.quantity as quantity'
            )
            ->where('orders.user_id', '=', Auth::user()->id)
            ->where('orders.status', '=', '0')->get();

        return view('product.order-detail', compact('cart'));
    }
}
