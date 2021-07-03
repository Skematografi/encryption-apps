<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use App\ReturnPmr;
use App\DetailProduct;
use App\OutStandingPO;
use App\Product;
use App\Supplier;


class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $suppliers = Supplier::count();
        $products = DetailProduct::count();
        $standing = OutStandingPO::count();
        $return = ReturnPmr::count();
        
        $data = [
            'suppliers' => $suppliers,
            'products' => $products,
            'standing' => $standing,
            'return' => $return
        ];

        return view('home', $data);
    }
}
