<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Phep;
use App\Models\Chitien;
use App\Models\ParentChitien;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// tên class phải trùng với tên file
class NewTestController extends Controller
{
    private $limit = 20;
    function list(Request $request) {
		// đây là nơi trỏ vào cái view admin.chi.list admin là thư mục resources/view/admin sau dấu . là 1 folder
        // Tên file nó lấy chữ đầu là list . Định dạng file phải là blade.php => nó là file view xử lý data
        // muỗn truyền biến ra file view thì dùng các này

        // muôn nhận data thì gõ như thế này
        if ($request->isMethod('post')) {
            // nhận dư liệu post ở đây 
            // cách lấy biến như hôm qua chỉ $request-> + name input
        }
        $variable = "xuan heo";
        return view(
            'admin.new-test.list',
            compact(['variable'])
        );

    }
    
}
