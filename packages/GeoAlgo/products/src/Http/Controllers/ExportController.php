<?php

namespace GeoAlgo\Products\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GeoAlgo\Products\Exports\ExportProductSheet;
use Maatwebsite\Excel\Facades\Excel;
use Log;

class ExportController extends Controller
{
    public function exportBulkProductFormat(Request $request){
        try{
            return Excel::download(new ExportProductSheet, 'beauty.xlsx');
        }catch(\Exception $e){
            Log::error($e->getMessage());
            abort(500);
        }
    }
}
