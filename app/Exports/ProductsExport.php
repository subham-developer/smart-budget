<?php

namespace App\Exports;

use App\Models\Product;
use DateTime;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Maatwebsite\Excel\Concerns\WithEvents;
// use Maatwebsite\Excel\AfterSheet;

class ProductsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;
    private $products;

    public function headings(): array
    {

        $data = Schema::getColumnListing('products');
        return [
            $data
        ];
    }
    // public function collection()
    // {
    //     return Product::all();
    // }
    

    public function query()
    {
        // $this->products = Product::query();
        return Product::query();
    }

    /**
    * @var Invoice $invoice
    */
    public function map($invoice): array
    {
        return [
            $invoice->id,
            $invoice->title,
            $invoice->slug,
            $invoice->summary,
            $invoice->description,
            $invoice->photo,
            $invoice->stock,
            $invoice->size,
            $invoice->condition,
            $invoice->status,
            $invoice->price,
            $invoice->discount,
            $invoice->is_featured,
            $invoice->cat_info->title,
            // $invoice->cat_id,
            $invoice->sub_cat_info['title'],
            // $invoice->child_cat_id,
            $invoice->brand_info->title,
            // $invoice->brand_id,
            $invoice->created_at,
            $invoice->updated_at
            // Date::dateTimeToExcel($invoice->created_at),
        ];
    }
    
}
