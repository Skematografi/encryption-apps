<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Storages;
use App\User;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $total_encrypted = Storages::where('status', '=', 1)->count();
        $total_not_encrypted = Storages::where('status', '=', 0)->count();
        $total_file =  $total_encrypted +  $total_not_encrypted;
        $total_user = User::count();

        $data = [
            'access_controls' => AppHelper::getRoleAndPermission(),
            'data' => [
                'files' => [
                    'total' => $total_file,
                    'label' => 'Total Files',
                    'icon' => 'fas fa-folder-open'
                ],
                'encrypted' => [
                    'total' => $total_encrypted,
                    'label' => 'Total File Encryption',
                    'icon' => 'fas fa-file-code'
                ],
                'not_encrypted' => [
                    'total' => $total_not_encrypted,
                    'label' => 'Total File Not Encryption',
                    'icon' => 'fas fa-file'
                ],
                'users' => [
                    'total' => $total_user,
                    'label' => 'Total Users',
                    'icon' => 'fas fa-users'
                ]
            ]
        ];

        return view('home', $data);
    }
}
