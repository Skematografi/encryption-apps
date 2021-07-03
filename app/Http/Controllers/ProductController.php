<?php

namespace App\Http\Controllers;

use App\Product;
use App\DetailProduct;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $detail = DetailProduct::get();
        $product = [];
        foreach($detail as $item){
            $product[] = [
                'id' =>$item['id'],
                'products_id' =>$item['products_id'],
                'code' => Product::find($item['products_id'])->code,
                'name' => Product::find($item['products_id'])->name,
                'code_item' =>$item['code_item'],
                'item' =>$item['item'],
                'unit' =>$item['unit'],
                'description' =>$item['description']
            ];
        }

        $data = [
            'products' => $product
        ];

        return view('product', $data);
    }

    public function store(Request $request)
    {
        $id = $request->detail_id;

        if(is_null($id)){

            $check = DetailProduct::where('code_item',  $request->code_item)->exists();

            if($check){
                Alert::error('Gagal', 'Data barang gagal disimpan, kode barang sudah terdaftar');
            } else {
                DetailProduct::create([
                    'products_id' => $request->products_id,
                    'code_item' => $request->code_item,
                    'item' => $request->item,
                    'unit' => $request->unit,
                    'description' => $request->description
                ]);
        
                Alert::success('Berhasil', 'Data barang berhasil disimpan');
            }

        } else {
            DetailProduct::where('id', $id)
                    ->update([
                        'products_id' => $request->products_id,
                        'item' => $request->item,
                        'unit' => $request->unit,
                        'description' => $request->description
                    ]);

            Alert::success('Berhasil', 'Data barang berhasil diupdate');
            
        }

        return redirect('product');
    }

    public function storeDetail(Request $request)
    {
        $check = Product::where('code',  $request->code)->exists();

        if($check){
            Alert::error('Gagal', 'Data produk gagal disimpan, kode barang sudah terdaftar');
        } else {
            Product::create([
                'code' => $request->code,
                'name' => $request->name
            ]);
    
            Alert::success('Berhasil', 'Data produk berhasil disimpan');
        }

        return redirect('product');
    }

    public function destroy(Product $product)
    {
        $product->destroy($product->id);
        Alert::success('Berhasil', 'Data produk berhasil dihapus');
        return redirect('product');
    }

    public function dataProduct(){
        $product = Product::get();
        $data = [];

        foreach($product as $item){
            $data[] = [
                'id' => $item['id'],
                'code' => $item['code'],
                'name' => $item['name']
            ];
        }

        return response()->json($data);
    }

    public function dataItems(Request $request){
        $product = DetailProduct::where('products_id', $request->products_id)->get();
        $data = [];

        foreach($product as $item){
            $data[] = [
                'id' => $item['id'],
                'code_item' => $item['code_item'],
                'item' => $item['item']
            ];
        }

        return response()->json($data);
    }
}
