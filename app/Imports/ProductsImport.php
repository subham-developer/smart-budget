<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class ProductsImport implements ToCollection, WithValidation, WithHeadingRow, WithBatchInserts, WithChunkReading, SkipsOnError  //WithUpserts
{
    use Importable, SkipsErrors, SkipsFailures, RegistersEventListeners;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        // dd($rows[1][1]);
        foreach ($rows as $key=>$row) 
        {
            Product::create([
                'title' => $row['title'],
                'slug'  => $row['slug'], 
                'summary' => $row['summary'],
                'description' => $row['description'],
                'photo' => $row['photo'],
                'stock' => $row['stock'],
                'size' => $row['size'],
                'condition' => $row['condition'],
                'status' => $row['status'],
                'price' => $row['price'],
                'discount' => $row['discount'],
                'is_featured' => $row['is_featured'],
                'is_affiliate' => $row['is_affiliate'],
                'affiliate_url' => $row['affiliate_url'],
                'cat_id' => $row['cat_id'],
                'child_cat_id' => $row['child_cat_id'],
                'brand_id' => $row['brand_id'],
            ]);
        }
        // return new Product([
        //     'title' => $row[0],
        //    'slug'  => $row[1], 
        //    'summary' => $row[3],
        //    'description' => $row[4],
        //    'photo' => $row[5],
        //    'stock' => $row[6],
        //    'size' => $row[7],
        //    'condition' => $row[8],
        //    'status' => $row[9],
        //    'price' => $row[10],
        //    'discount' => $row[11],
        //    'is_featured' => $row[12],
        //    'cat_id' => $row[13],
        //    'child_cat_id' => $row[14],
        //    'brand_id' => $row[15],
        // ]);
    }
    // public function uniqueBy()
    // {
    //     return 'title';
    // }
    
    public function batchSize(): int
    {
        return 1000;
    }
    public function chunkSize(): int
    {
        return 1000;
    }
    public function rules(): array
    {
        return [
            'title'=>'string|required|unique:products',
            'summary'=>'string|required|max:30000',
            'description'=>'string|nullable',
            'photo'=>'string|required',
            'size'=>'nullable',
            'stock'=>"required|numeric",
            'cat_id'=>'required|exists:categories,id',
            'child_cat_id'=>'nullable|exists:categories,id',
            'is_featured'=>'sometimes|in:1',
            'is_affiliate'=>'sometimes|in:1',
            'affiliate_url'=>'nullable',
            'brand_id'=>'nullable|exists:brands,id',
            'status'=>'required|in:active,inactive',
            'condition'=>'required|in:default,new,hot',
            // 'price'=>'required|numeric',
            // 'discount'=>'nullable|numeric'
        ];
    }

    public static function afterImport(AfterImport $event)
    {
        
    }

    public function onFailure(Failure ...$failure)
    {
    }

    
    
}
