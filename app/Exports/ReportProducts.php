<?php

namespace App\Exports;

use App\MercatodoModels\Category;
use App\MercatodoModels\Product;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportProducts implements FromCollection, WithHeadings, WithMapping, ShouldQueue, ShouldAutoSize, WithStyles
{
    use Exportable;
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function Collection()
    {
        if (empty($this->request))
        {
            return Product::withTrashed('images', 'category')->get();
        }

        else {
            if (!empty($this->request['searchbyisInactive']) & !empty($this->request['searchbycategory'])) {
                return Product::withTrashed('images', 'category')
                    ->isinactive($this->request['searchbyisInactive'])
                    ->category($this->request['searchbycategory'])->get();
            }
            else if(!empty($this->request['searchbyisInactive']))
            {
                return Product::withTrashed('images', 'category')->isinactive($this->request['searchbyisInactive'])->get();
            }
            else
            {
                return Product::withTrashed('images', 'category')->category($this->request['searchbycategory'])->get();
            }
        }
    }

    public function map($product) : array
    {
        $category = Category::where('id', $product->category_id)->first();
        return [
           $product->name,
           $product->slug,
           $category->name,
           $product->price,
           $product->description,
           $product->specifications,
           $product->data_of_interest,
           $product->status,
           $product->quantity,
           $product->created_at,
           $product->updated_at,

        ];
    }

   public function headings() : array
    {
        return [
            'name',
            'slug',
            'category',
            'price',
            'description',
            'specifications',
            'data',
            'status',
            'quantity',
            'created',
            'updated',

        ] ;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }

}
