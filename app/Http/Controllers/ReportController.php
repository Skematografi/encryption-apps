<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReturnPmr;
use App\DetailProduct;
use App\OutStandingPO;
use App\Supplier;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;
use Illuminate\Support\Carbon;


class ReportController extends Controller
{
    public function index()
    {
        $get_return = ReturnPmr::get();
        $return = [];

        foreach($get_return as $item){

            $standing = OutStandingPO::find($item['out_standing_po_id']);

            $return[] = [
                'id' =>$item['id'],
                'date_return' =>$item['date_return'],
                'code_item' => DetailProduct::find($standing->detail_products_id)->code_item,
                'item' => DetailProduct::find($standing->detail_products_id)->item,
                'supplier' => Supplier::find($standing->suppliers_id)->name,
                'no_po' => $standing->no_po,
                'reception_qty' =>$item['reception_qty'],
                'reception_unit' =>$item['reception_unit'],
                'rejection_qty' =>$item['rejection_qty'],
                'rejection_unit' =>$item['rejection_unit'],
                'example_qty' =>$item['example_qty'],
                'example_unit' =>$item['example_unit'],
                'aql' =>$item['aql'],
                'ac_rc' =>$item['ac_rc'],
                'description' =>$item['description'],
                'print' =>$item['print']
            ];
        }

        $data = [
            'returns' => $return
        ];

        return view('report', $data);
    }

    public function printReport(Request $request){

        $standing = OutStandingPO::where('no_po', $request->no_po)->first();
        
        if(is_null($standing)){
            Alert::error('Gagal', 'Nomor PO tidak ditemukan!');
            return redirect('report');
        } else {
            $date = Carbon::parse($request->date)->format('Y-m-d');
            $get_return = ReturnPmr::where([
                                ['out_standing_po_id', $standing->id],
                                ['date_return', $date]
                            ])->get();

            if($get_return->count() == 0){
                Alert::error('Gagal', 'Data tidak ditemukan!');
                return redirect('report');
            } else {

                foreach($get_return as $item){
        
                    $return[] = [
                        'id' =>$item['id'],
                        'date_return' =>$item['date_return'],
                        'code_item' => DetailProduct::find($standing->detail_products_id)->code_item,
                        'item' => DetailProduct::find($standing->detail_products_id)->item,
                        'supplier' => Supplier::find($standing->suppliers_id)->name,
                        'no_po' => $standing->no_po,
                        'reception_qty' =>$item['reception_qty'],
                        'reception_unit' =>$item['reception_unit'],
                        'rejection_qty' =>$item['rejection_qty'],
                        'rejection_unit' =>$item['rejection_unit'],
                        'example_qty' =>$item['example_qty'],
                        'example_unit' =>$item['example_unit'],
                        'aql' =>$item['aql'],
                        'ac_rc' =>$item['ac_rc'],
                        'description' =>$item['description'],
                        'print' =>$item['print']
                    ];
                    
                    ReturnPmr::where('id', $item['id'])->update(['print' => 1]);
                }

                $data = [
                    'returns' => $return
                ]; 

                $pdf = PDF::loadView('form_return', $data);


                // return $pdf->download('form_return.pdf');
                return $pdf->stream('form_return.pdf');
            }
        }
    }
}
