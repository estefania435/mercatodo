<?php

namespace App\Repositories\Detail;

use App\MercatodoModels\Detail;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Session;

class DetailRepository extends BaseRepository
{
    /**
     * @return Detail
     */
    public function getModel(): Detail
    {
        return new Detail();
    }

    /**
     * function for see details
     *
     * @return object
     */
    public function SeeDetail(): object
    {
        if (!empty(Session::get('order_id'))) {
            $details = Detail::whereOrder_id(Session::get('order_id'))->get();
        }

        return $details;
    }
}
