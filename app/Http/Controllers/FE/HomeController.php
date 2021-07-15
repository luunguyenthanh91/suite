<?php

namespace App\Http\Controllers\FE;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\User;
use App\Models\Products;
use App\Models\Posts;


use DateTime;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    

    

    function index(Request $request)                        {
        $menu_active = 'home';
        $menu_parent_active = 'home';
        return view(
            'fe.home.index',
            compact([
                'menu_active',
                'menu_parent_active'
            ])
        );
    }
    function convertCondition( $str ) {
        if($str == 0){
            return "Tuần Này";
        } else if($str == 1){
            return "Tuần Trước";
        } else if($str == 2){
            return "Tháng Này";
        } else if($str == 3){
            return "Tháng Trước";
        } else if($str == 4){
            return "Năm Nay";
        } else if($str == 5){
            return "Năm Trước";
        }

    }
    function cryptocurrency()               {return view('admin.dashboard.cryptocurrency');}
    function campaign()                     {return view('admin.dashboard.campaign');}
    function ecommerce()                    {return view('admin.dashboard.ecommerce');}
}
