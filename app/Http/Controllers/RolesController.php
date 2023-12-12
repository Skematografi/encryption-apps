<?php

namespace App\Http\Controllers;

use App\AccessControl;
use App\AppHelper;
use App\Roles;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $hasAccess = AppHelper::checkAuthorization(Auth::user()->role_id, 'Roles');
            if (!$hasAccess) {
                throw new AuthorizationException('Access Denied You don’t have permission to access');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $data = [
            'roles' => Roles::get(),
            'access_controls' => AppHelper::getRoleAndPermission(),
            'access' => AppHelper::getRoleAndPermission('Roles', true)
        ];

        return view('roles', $data);
    }

    public function create()
    {
        $model = new Roles();
        $data = [
            'roles' => $model,
            'access_controls' => AppHelper::getRoleAndPermission(),
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
        $id = $request->role_id;

        $roleExists = Roles::where('id', '<>', $id)->where('name', trim($request->name))->first();
        if ($roleExists) {
            Alert::error('Gagal', 'Nama role sudah terdaftar');
            return redirect('roles');
        }

        $role = Roles::updateOrCreate([
            'id' => $id
        ], ['name' => trim($request->name)]);

        foreach ($request->modules as $attr) {
            AccessControl::updateOrCreate([
                'id' => $attr['access_control_id']
            ], [
                'role_id' => $role->id,
                'permission_id' => $attr['permission_id'],
                'is_view' => isset($attr['is_view']) ? 1 : 0,
                'is_insert' => isset($attr['is_insert']) ? 1 : 0,
                'is_edit' => isset($attr['is_edit']) ? 1 : 0,
                'is_delete' => isset($attr['is_delete']) ? 1 : 0,
            ]);
        }

        Alert::success('Berhasil', 'Data role berhasil disimpan');
        return redirect('roles');
    }

    public function destroy(Roles $role)
    {
        $role->destroy($role->id);
        Alert::success('Berhasil', 'Data role berhasil dihapus');
        return redirect('roles');
    }
}
