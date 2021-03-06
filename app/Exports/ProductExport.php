<?php

namespace App\Exports;

use App\MercatodoModels\Category;
use App\MercatodoModels\Product;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;

class ProductExport implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{
    use Exportable;

    /**
     * bring the products with your images
     *
     * @return \Illuminate\Support\Collection
     */

    public function collection(): Collection
    {
        return Product::with('images')->get();
    }

    /**
     * map product data
     *
     * @param mixed $product
     * @return array
     */
    public function map($product): array
    {
        $category = Category::where('id', $product->category_id)->first();
        $imagenes = '';
        foreach ($product->images as $pro) {
            $imagenes .= $pro->url . ', ';
        }
        $imagenes = str_replace('/images/products/', '', $imagenes);
        $products = [
            $product->id,
            $product->name,
            $product->slug,
            $category->name,
            $product->quantity,
            $product->price,
            $product->description,
            $product->specifications,
            $product->data_of_interest,
            $product->status,
            $imagenes
        ];

        return $products;
    }

    /**
     * export a document with headings
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'id',
            'name',
            'slug',
            'category',
            'quantity',
            'price',
            'description',
            'specifications',
            'data',
            'status',
            'image'
        ] ;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
