<?php

namespace App\Exports;

use App\MercatodoModels\Category;
use App\MercatodoModels\Order;
use App\MercatodoModels\Product;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportOrders implements FromCollection, ShouldQueue//, WithMapping, WithHeadings
{
    use Exportable;
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if (empty($this->request))
        {
            return Order::with('details', 'details.products')->get();
        }
        else {
            if (!empty($this->request['searchbystate']) & !empty($this->request['searchbydate']))
            {
                return Order::with('details', 'details.products')->statusorder($this->request['searchbystate'])
                    ->dateorder($this->request['searchbydate'])->get();
            }
            else if(!empty($this->request['searchbystate']))
            {
                return Order::with('details', 'details.products')->statusorder($this->request['searchbystate'])->get();
            }
            else
            {
                return Order::with('details', 'details.products')->dateorder($this->request['searchbydate'])->get();
            }
        }
    }

   /* public function map($order) : array
    {
            foreach ($order->details as $detail)
            {
                //dd($detail->products);
                $category = Category::where('id', $detail->products->category_id)->get();
                        return [
                            $order->code,
                            $detail->product->name,
                            $category->name,
                            $detail->product->price,
                            $detail->product->description,
                            $detail->product->status,
                            $detail->quantity,
                            $order->total,
                            $order->updated_at,

                        ];
                }

    }

    public function headings() : array
    {
        return [
            'code',
            'product',
            'category',
            'priceproduct',
            'description',
            'status',
            'quantitysold',
            'total',
            'date'
        ] ;
    }*/

}
