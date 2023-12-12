<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Roles;
use App\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = [
            'roles' => Roles::get(),
            'users' => auth()->user(),
            'access_controls' => AppHelper::getRoleAndPermission()
        ];

        return view('profile', $data);
    }

    public function store(Request $request)
    {
        $id = $request->user_id;
        $check_phone = User::where([
                            ['phone',  '=', $request->phone],
                            ['id', '<>', $id],
                        ])->exists();

        if ($check_phone){
            Alert::error('Gagal', 'Nomor telepon sudah terdaftar');
            return redirect('users');
        }

        $check_email = User::where([
                            ['email',  '=', $request->email],
                            ['id', '<>', $id],
                        ])->exists();

        if ($check_email){
            Alert::error('Gagal', 'Email sudah terdaftar');
            return redirect('users');
        }

        $password = [];
        if ($request->password) {
            $password = ['password' => bcrypt($request->password)];
        }

        $data = [
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
            Alert::error('Gagal', 'Profile gagal diperbarui');
            return redirect('profile');
        }

        Alert::success('Berhasil', 'Profile berhasil diperbarui');
        return redirect('profile');
    }
}
