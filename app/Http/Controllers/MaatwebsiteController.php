<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Input;
use App\Models\Product;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use Illuminate\Support\Facades\Schema;
use DB;
use Session;
use Excel;

class MaatwebsiteController extends Controller
{
    public function importExport()
    {
        return view('importExport');
    }
    public function downloadExcel($type)
    {
        return Excel::download(new ProductsExport, 'products.xlsx',\Maatwebsite\Excel\Excel::XLSX);
    }
    public function importExcel(Request $request)
    {
        // dd($request->all());
        // $fileName = $request->file('import_file')->getRealPath();
        $fileName = $request->file('import_file')->store('import');
        // dd($fileName);
        // if($request->hasFile('import_file')){
           
            $import = new ProductsImport;
            
            // Excel::import(new ProductsImport, $fileName);
            try {
                $import->import($fileName);
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                 $failures = $e->failures();
                // dd($failures);
                 foreach ($failures as $failure) {
                    //  dd($failure->values());
                     $failure->row(); // row that went wrong
                     $failure->attribute(); // either heading key (if using heading row concern) or column index
                     $failure->errors(); // Actual error messages from Laravel validator
                     $failure->values(); // The values of the row that has failed.
                    // Session::flash('message', "There is a error"); 
                 }
                 return back()->withFailures($failures);
            }

            //  Session::flash('success', 'Youe file successfully import in database!!!');
            
        // }

        return back()->withSuccess('Products uploaded Successfully....!!');
    }
}