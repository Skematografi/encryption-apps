<?php

namespace App\Http\Controllers;

use App\OutStandingPO;
use App\DetailProduct;
use App\Supplier;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

class OutStandingPOController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        // $standing = OutStandingPO::whereDate('created_at', Carbon::today())->get();
        $standing = OutStandingPO::get();

        $standing_today = [];
        foreach($standing as $item){
            $standing_today[] = [
                'id' =>$item['id'],
                'no_po' =>$item['no_po'],
                'date_po' =>$item['date_po'],
                'products_id' => DetailProduct::find($item['detail_products_id'])->code_item,
                'products_name' => DetailProduct::find($item['detail_products_id'])->item,
                'suppliers_id' => Supplier::find($item['suppliers_id'])->code,
                'suppliers_name' => Supplier::find($item['suppliers_id'])->name,
                'stock' =>$item['stock']
            ];
        }

        $data = [
            'standings' => $standing_today
        ];

        return view('standing', $data);
    }

    public function store(Request $request)
    {   
        $id = $request->standing_id;
        $date = Carbon::parse($request->date_po)->format('Y-m-d');

        if(is_null($id)){

            OutStandingPO::create([
                "date_po" => $date,
                "no_po" => $request->no_po,
                "detail_products_id" => $request->detail_id,
                "suppliers_id" => $request->suppliers_id,
                "stock" => $request->stock
            ]);
    
            Alert::success('Berhasil', 'Data Out Standing PO berhasil disimpan');

        } else {
            OutStandingPO::where('id', $id)
                    ->update([
                        "date_po" => $date,
                        "no_po" => $request->no_po,
                        "detail_products_id" => $request->detail_products_id,
                        "suppliers_id" => $request->suppliers_id,
                        "stock" => $request->stock
                    ]);

            Alert::success('Berhasil', 'Data Out Standing PO berhasil diupdate');
            
        }

        return redirect('out_standing_po');
    }

    public function dataStanding(){
        
        $standing = OutStandingPO::groupBy('no_po')->get();
        $data = [];

        foreach($standing as $item){
            $data[] = [
                'id' => $item['id'],
                'no_po' => $item['no_po']
            ];
        }

        return response()->json($data);
    }

    public function dataPoStanding(Request $request){
        $standing = OutStandingPO::where('no_po', $request->po)->get();
        $data = [];

        foreach($standing as $item){
            $data[] = [
                'id' => $item['id'],
                'code_item' => DetailProduct::find($item['detail_products_id'])->code_item,
                'item' => DetailProduct::find($item['detail_products_id'])->item,
                'unit' => DetailProduct::find($item['detail_products_id'])->unit,
                'supplier' => Supplier::find($item['suppliers_id'])->name
            ];
        }

        return response()->json($data);
    }

    public function destroy(OutStandingPO $outStandingPO)
    {
        $id = explode('/', URL::current());

        $outStandingPO->destroy($id[4]);
        Alert::success('Berhasil', 'Data out standing po berhasil dihapus');
        return redirect('out_standing_po');
    }
}
