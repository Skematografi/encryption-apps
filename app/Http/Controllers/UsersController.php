<?php

namespace App\Http\Controllers;

use App\Supplier;
use App\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = [
            'users' => User::get()
        ];

        return view('users', $data);
    }

    public function store(Request $request)
    {
        $id = $request->supplier_id;

        $check_phone = Supplier::where([
                                    ['phone',  '=', $request->phone],
                                    ['id', '<>', $id],
                                ])->exists();

        $check_email = Supplier::where([
                                    ['email',  '=', $request->email],
                                    ['id', '<>', $id],
                                ])->exists();

        if($check_phone){
            Alert::error('Gagal', 'Data supplier gagal disimpan, nomor telepon supplier sudah terdaftar');
            return redirect('supplier');
        }

        if($check_email){
            Alert::error('Gagal', 'Data supplier gagal disimpan, email supplier sudah terdaftar');
            return redirect('supplier');
        }

        if(is_null($id)){

            $check = Supplier::where('code',  $request->code)->exists();

            if($check){
                Alert::error('Gagal', 'Data supplier gagal disimpan, kode supplier sudah terdaftar');
            } else {
                Supplier::create([
                    'code' => $request->code,
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'address' => $request->address
                ]);

                Alert::success('Berhasil', 'Data supplier berhasil disimpan');
            }

        } else {
            Supplier::where('id', $id)
                    ->update([
                        'name' => $request->name,
                        'phone' => $request->phone,
                        'email' => $request->email,
                        'address' => $request->address
                    ]);

            Alert::success('Berhasil', 'Data supplier berhasil diupdate');

        }

        return redirect('supplier');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->destroy($supplier->id);
        Alert::success('Berhasil', 'Data supplier berhasil dihapus');
        return redirect('supplier');
    }

    public function dataSupplier(){
        $supplier = Supplier::get();
        $data = [];

        foreach($supplier as $item){
            $data[] = [
                'id' => $item['id'],
                'code' => $item['code'],
                'name' => $item['name']
            ];
        }

        return response()->json($data);
    }
}
