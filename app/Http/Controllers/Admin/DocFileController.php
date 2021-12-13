<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\CostTransport;
use App\Models\CostDoc;
use App\Models\BoPhan;
use App\Models\DocFile;
use Illuminate\Support\Facades\Auth;

class DocFileController extends Controller
{
    private $limit = 20;
    private $defSortName = "id";
    private $defSortType = "DESC";

    
    function getListDocFile(Request $request) {
        $page = $request->page - 1;
        
        $data = new DocFile();

        $item_id = $request->item_id;
        if(isset($item_id)){
            $data = $data->where('item_id', $item_id);
        }
        
        $table_name = $request->table_name;
        if(isset($table_name)){
			$data = $data->where('table_name', $table_name);
        }

        $count = $data->count();
        $showCount = $request->showcount;
        if ($showCount == 0) {
            $showCount = $count;
        }
        if ($showCount == 0) {
            $showCount = 1;
        }
        $data = $data->offset($page * $showCount)->limit($showCount)->get();
        $countPage = $count === 0 ? 1 : $count;
        $pageTotal = ceil($countPage/$showCount);

        return response()->json([
            'data'=>$data,
            'count'=>$count,
            'pageTotal' => $pageTotal
        ]);
    }
}
