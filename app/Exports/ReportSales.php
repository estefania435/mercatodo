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
            return Order::with('details', 'details.products')->where('status', '=', 'APPROVED')->get();
        } else {
            return Order::with('details', 'details.products')->where('status', '=', 'APPROVED')
            ->dateorder($this->request['searchbydate'])->get();
        }
    }

    public function map($order): array
    {

        foreach ($order->details as $detail) {
            $category = Category::where('id', $detail->products->category_id)->first();
            return [
                $order->code,
                $detail->products->name,
                $category->name,
                $detail->products->price,
                $detail->products->description,
                $detail->products->status,
                $detail->quantity,
                $order->total,
                $order->updated_at,
            ];
        }
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
            1    => ['font' => ['bold' => true]],
        ];
    }
}
