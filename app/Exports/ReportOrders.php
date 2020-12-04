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
use App\MercatodoModels\User;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportOrders implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles, ShouldQueue
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
        if (empty($this->request)) {
            return Order::with('details', 'details.products')->get();
        } else {
            if (!empty($this->request['searchbystate']) & !empty($this->request['searchbydate'])) {
                return Order::with('details', 'details.products')->statusorder($this->request['searchbystate'])
                    ->dateorder($this->request['searchbydate'])->get();
            } elseif (!empty($this->request['searchbystate'])) {
                return Order::with('details', 'details.products')->statusorder($this->request['searchbystate'])->get();
            } else {
                return Order::with('details', 'details.products')->dateorder($this->request['searchbydate'])->get();
            }
        }
    }

    public function map($order): array
    {
        $user = User::where('id', $order->user_id)->first();

             return [
                      $order->code,
                      $order->total,
                      $order->status,
                      $user->name,
                      $user->surname,
                      $order->name_receive,
                      $order->surname,
                      $order->address,
                      $order->phone,
                      $order->created_at,
                      $order->updated_at,

             ];
    }

    public function headings(): array
    {
        return [
            'code',
            'total',
            'status',
            'name',
            'surname',
            'namereceive',
            'surname',
            'address',
            'phone',
            'created',
            'updated_at'
        ] ;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
