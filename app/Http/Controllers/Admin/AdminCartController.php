<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminCartController extends Controller
{
    protected $cartRepo;

    /**
     * AdminCategoryController constructor.
     * @param CartRepository $cartRepository
     */
    public function __construct(CartRepository $carRepository)
    {
        $this->cartRepo = $carRepository;
    }
    /**
     * show cart
     *
     * @return \Illuminate\View\View
     */
    public function show(): View
    {
        $cart = $this->cartRepo->getProductsOfCart();
        $total = $this->cartRepo->total();

        return view('product.cart', compact('cart', 'total'));
    }

    /**
     * add products to cart
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request): RedirectResponse
    {
        $this->cartRepo->addToCart($request);

        return redirect()->route('cart.show');
    }

    /**
     * delete the product  of cart
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request): RedirectResponse
    {
        $this->cartRepo->deleteProductOfCart($request);

        return redirect()->route('cart.show');
    }

    /**
     * empty cart
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function trash(): RedirectResponse
    {
        $this->cartRepo->emptyCart();

        return redirect()->route('home');
    }

    /**
     * update cart
     *
     * @param string $slug
     * @param int $quantity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(string $slug, int $quantity): RedirectResponse
    {
        $this->cartRepo->updateQuantity($slug, $quantity);

        return redirect()->route('cart.show');
    }

    /**
     * modify the shipping data
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function Datesreceive(Request $request): View
    {
        $order = $this->cartRepo->DatesreceiveOrder($request);

        return view('product.pay', compact('order'));
    }

    /**
     * show the order detail
     *
     * @return \Illuminate\View\View
     */
    public function orderDetail(): View
    {
        $cart = $this->cartRepo->detail();

        return view('product.order-detail', compact('cart'));
    }
}
