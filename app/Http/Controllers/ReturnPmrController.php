<?php

namespace App\Http\Controllers;

use App\ReturnPmr;
use App\DetailProduct;
use App\OutStandingPO;
use App\Supplier;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Double;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Carbon;


class ReturnPmrController extends Controller
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
                'description' =>$item['description']
            ];
        }

        $data = [
            'returns' => $return
        ];

        return view('return', $data);
    }

    public function store(Request $request)
    {
        $id = $request->return_id;

        if(is_null($id)){
            $date = Carbon::parse($request->date_return)->format('Y-m-d');
            
            ReturnPmr::create([
                "date_return" => $date,
                "out_standing_po_id" => $request->out_standing_po_id,
                "reception_qty" => $request->reception_qty,
                "reception_unit" => $request->reception_unit,
                "rejection_qty" => $request->rejection_qty,
                "rejection_unit" => $request->rejection_unit,
                "example_qty" => $request->example_qty,
                "example_unit" => $request->example_unit,
                "aql" => (double) $request->aql,
                "ac_rc" => $request->ac_rc1.'/'.$request->ac_rc2,
                "description" => $request->description
            ]);
    
            Alert::success('Berhasil', 'Data Return PM R1 berhasil disimpan');

        } else {
            ReturnPmr::where('id', $id)
                    ->update([
                        "date_return" => $request->date_return,
                        "out_standing_po_id" => $request->out_standing_po_id,
                        "reception_qty" => $request->reception_qty,
                        "reception_unit" => $request->reception_unit,
                        "rejection_qty" => $request->rejection_qty,
                        "rejection_unit" => $request->rejection_unit,
                        "example_qty" => $request->example_qty,
                        "example_unit" => $request->example_unit,
                        "aql" => (double) $request->aql,
                        "ac_rc" => $request->ac_rc1.'/'.$request->ac_rc2,
                        "description" => $request->description
                    ]);

            Alert::success('Berhasil', 'Data Return PM R1 berhasil diupdate');
            
        }

        return redirect('return_pmr');
    }

    public function destroy(ReturnPmr $returnPmr)
    {
        $returnPmr->destroy($returnPmr->id);
        Alert::success('Berhasil', 'Data return pm r1 berhasil dihapus');
        return redirect('return_pmr');
    }
}
