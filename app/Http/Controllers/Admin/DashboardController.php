<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    private $limit = 20;

    function index(Request $request) {
        $menu_active = 'dashboard';
        return view(
            'admin.home.index',
            compact([
                'menu_active'
            ])
        );
    }

}
