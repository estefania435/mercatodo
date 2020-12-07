<?php

namespace App\Exports;

use App\MercatodoModels\Category;
use App\MercatodoModels\Order;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportSales implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles, ShouldQueue
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

        if (empty($this->request['searchbydate'])) {
            return Order::join('details', 'orders.id', '=', 'details.order_id')
                ->join('products', 'products.id', '=', 'details.products_id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->select(
                    'orders.code as code',
                    'products.name as name',
                    'categories.name as category',
                    'products.price as price',
                    'products.description as description',
                    'orders.status as status',
                    'details.quantity as quantity',
                    'orders.created_at as created'
                )
                ->where('orders.status', '=', 'APPROVED')
                ->get();
        } else {
            return Order::join('details', 'orders.id', '=', 'details.order_id')
                ->join('products', 'products.id', '=', 'details.products_id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->select(
                    'orders.code as code',
                    'products.name as name',
                    'categories.name as category',
                    'products.price as price',
                    'products.description as description',
                    'orders.status as status',
                    'details.quantity as quantity',
                    'orders.created_at as created'
                )
                ->
                where('orders.status', '=', 'APPROVED')
                ->dateorder($this->request['searchbydate'])
                ->get();
        }
    }

    public function map($order): array
    {
        return [
            $order->code,
            $order->name,
            $order->category,
            $order->price,
            $order->description,
            $order->status,
            $order->quantity,
            number_format($order->price * $order->quantity, 2),
            $order->created
        ];
    }

    public function headings(): array
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
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
