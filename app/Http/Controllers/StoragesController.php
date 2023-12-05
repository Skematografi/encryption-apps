<?php

namespace App\Http\Controllers;

use App\AccessControl;
use App\Roles;
use App\Storages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class StoragesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = [
            'storages' => Storages::fetchData(),
            'access' => auth()->user()->getRoleAndPermission('Storages')['Storages']
        ];

        return view('storages', $data);
    }

    public function create()
    {
        $model = new Roles();
        $data = [
            'roles' => $model,
            'modules' => $model->getPermissions()
        ];

        return view('permissions', $data);
    }

    public function edit($id)
    {
        $model = Roles::firstWhere('id', $id);
        $data = [
            'roles' => $model,
            'modules' => $model->getPermissions()
        ];

        return view('permissions', $data);
    }

    public function store(Request $request)
    {
        $image = $request->file('file');

        $imageName = time() . '.' . $image->extension();
        $image->move('storage', $imageName);

        return response()->json(['success' => $imageName]);
    }

    public function destroy(Storages $storages)
    {
        $storages->destroy($storages->id);
        Alert::success('Berhasil', 'Data storage berhasil dihapus');
        return redirect('storages');
    }
}
