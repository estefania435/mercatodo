<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MercatodoModels\Detail;
use Illuminate\Support\Facades\Session;

class AdminDetailController extends Controller
{
    /**
     * list all details of orders
     *
     * @return \Illuminate\View\View
     */
    public function index(): \Illuminate\View\View
    {
        if (!empty(Session::get('order_id'))) {
            $details = Detail::whereOrder_id(Session::get('order_id'))->get();

            return view('admin.detail.index', compact('details'));
        }
    }
}
