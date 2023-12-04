<?php

namespace App\Http\Controllers;

use App\Roles;
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
            'users' => User::get(),
            'roles' => Roles::get(),
            'access' => auth()->user()->getRoleAndPermission('User')['User']
        ];

        return view('users', $data);
    }

    public function store(Request $request)
    {
        $id = $request->user_id;
        $check_username = User::where([
                                ['username',  '=', $request->username],
                                ['id', '<>', $id],
                            ])->exists();
        if ($check_username) {
            Alert::error('Gagal', 'Username sudah terdaftar');
            return redirect('users');
        }

        $check_phone = User::where([
                            ['phone',  '=', $request->phone],
                            ['id', '<>', $id],
                        ])->exists();

        if($check_phone){
            Alert::error('Gagal', 'Nomor telepon user sudah terdaftar');
            return redirect('users');
        }

        $check_email = User::where([
                            ['email',  '=', $request->email],
                            ['id', '<>', $id],
                        ])->exists();

        if($check_email){
            Alert::error('Gagal', 'Email user sudah terdaftar');
            return redirect('users');
        }

        $password = [];
        if ($request->password) {
            $password = ['password' => bcrypt($request->password)];
        }

        $data = [
            'username' => $request->username,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'role_id' => $request->role_id
        ];
        $data = array_merge($data, $password);

        $user = User::updateOrCreate([
            'id' => $id
        ], $data);

        if (!$user) {
            Alert::error('Gagal', 'Data user gagal disimpan');
            return redirect('users');
        }

        Alert::success('Berhasil', 'Data user berhasil disimpan');
        return redirect('users');
    }

    public function destroy(User $user)
    {
        $user->destroy($user->id);
        Alert::success('Berhasil', 'Data user berhasil dihapus');
        return redirect('users');
    }
}
