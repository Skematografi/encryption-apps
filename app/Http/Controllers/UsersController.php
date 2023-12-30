<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Mail\ResetPasswordEmail;
use App\Roles;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\URL;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $hasAccess = AppHelper::checkAuthorization(Auth::user()->role_id, 'User');
            if (!$hasAccess) {
                throw new AuthorizationException('Access Denied You don’t have permission to access');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $data = [
            'users' => User::get(),
            'roles' => Roles::get(),
            'access_controls' => AppHelper::getRoleAndPermission(),
            'access' => AppHelper::getRoleAndPermission('User', true)
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
        $user->forceDelete($user->id);
        Alert::success('Berhasil', 'Data user berhasil dihapus');
        return redirect('users');
    }

    public function reset($id)
    {
        $user = User::firstWhere('id', $id);
        if (!$user) {
            Alert::error('Gagal', 'User tidak ditemukan');
            return redirect('users');
        }

        $new_password = AppHelper::generateRandomString(8);
        $user->password = bcrypt($new_password);
        $user->save();

        $details = [
            'name' => $user->name,
            'username' => $user->username,
            'password' => $new_password,
            'message' => "Permintaan reset password anda telah disetujui.",
            'sub_message' => "Anda dapat login kembali dengan akses dibawah ini.",
            'url' => URL::to("/login"),
            'label_url' => 'Klik link untuk login kembali',
            'type' => 1
        ];

        $subject = 'New Access';

        Mail::to($user->email)->send(new ResetPasswordEmail($details, $subject));

        Alert::success('Berhasil', 'Password user berhasil direset');
        return redirect('users');
    }

    public function show()
    {
        return redirect('users');
    }
}
