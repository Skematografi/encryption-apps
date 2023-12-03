<?php

namespace App\Http\Controllers;

use App\ReturnPmr;
use App\DetailProduct;
use App\OutStandingPO;
use App\Supplier;


class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $suppliers = 0;
        $products = 0;
        $standing = 0;
        $return = 0;

        $data = [
            'suppliers' => $suppliers,
            'products' => $products,
            'standing' => $standing,
            'return' => $return
        ];

        return view('home', $data);
    }
}
