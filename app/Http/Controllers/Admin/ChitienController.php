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
use NumberFormatter;
use PDF;

class ChitienController extends Controller
{
    private $limit = 20;

    function report(Request $request) {
        return view(
            'admin.chi.list',
            compact([])
        );

    }
    function reportAPI(Request $request) {
        return view(
            'admin.chi.list',
            compact([])
        );

    }
    
    function getViewListExpensesItem(Request $request) {
        return view(
            'admin.expenseslist',
            compact([])
        );
    }

    function getListExpensesItem(Request $request) {
        $page = $request->page - 1;
        $sortName = "chitien.date";
        $sortType = "DESC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }
        $data = Chitien::orderBy($sortName , $sortType);
        
        if(@$request->ngay_bat_dau != '' ){
            $data = $data->where('date','LIKE' , '%'.$request->ngay_bat_dau.'%' );
        }
        
        if(@$request->ngay_bat_dau_from != '' ){
            $data = $data->where('date','>=' , @$request->ngay_bat_dau_from);
        }
        if(@$request->ngay_bat_dau_to != '' ){
            $data = $data->where('date','<=' , @$request->ngay_bat_dau_to );
        }
        if(@$request->typelog_multi != '' ){
            $data = $data->whereIn('typelog', explode(',', $request->typelog_multi) );
        }

        $count = $data->count();
        $showCount = $request->showcount;
        if ($showCount == 0) {
            $showCount = $count;
        }
        $data = $data->offset($page * $showCount)->limit($showCount)->get();
        $countPage = $count === 0 ? 1 : $count;
        $pageTotal = ceil($countPage/$showCount);

        $totalPrice = 0;
        foreach ($data as &$item) {
            $totalPrice += $item->price;
        }
        unset($item);
        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal , 'totalPrice' => $totalPrice]);
    }

    function pdfViewExpensesList(Request $request) {
        $page = $request->page - 1;
        $sortName = "chitien.date";
        $sortType = "DESC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }
        $data = Chitien::orderBy($sortName , $sortType);
        
        if(@$request->ngay_bat_dau != '' ){
            $data = $data->where('date','LIKE' , '%'.$request->ngay_bat_dau.'%' );
        }
        
        if(@$request->ngay_bat_dau_from != '' ){
            $data = $data->where('date','>=' , @$request->ngay_bat_dau_from);
        }
        if(@$request->ngay_bat_dau_to != '' ){
            $data = $data->where('date','<=' , @$request->ngay_bat_dau_to );
        }
        if(@$request->typelog_multi != '' ){
            $data = $data->whereIn('typelog', explode(',', $request->typelog_multi) );
        }

        $count = $data->count();
        $showCount = $request->showcount;
        if ($showCount == 0) {
            $showCount = $count;
        }
        $data = $data->offset($page * $showCount)->limit($showCount)->get();
        $countPage = $count === 0 ? 1 : $count;
        $pageTotal = ceil($countPage/$showCount);

        $totalPrice = 0;
        foreach ($data as &$item) {
            $totalPrice += $item->price;
        }
        unset($item);

        $selectedMonth = '';
        if(@$request->ngay_bat_dau != '' ){
            $selectedMonth = $request->ngay_bat_dau;
        }
        
        if(@$request->ngay_bat_dau_from != '' ){
            $selectedMonth = $selectedMonth . $request->ngay_bat_dau_from . '～';
        }

        if(@$request->ngay_bat_dau_to != '' ){
            if(@$request->ngay_bat_dau_from != '' ){
                $selectedMonth = $selectedMonth . $request->ngay_bat_dau_to;
            } else {
                $selectedMonth = $selectedMonth . $request->ngay_bat_dau_to . 'まで';
            }
        }

        $count = $data->count();
        $data->sumPay = $totalPrice;
        $data->sumData = $count;
        $data->selectedMonth = $selectedMonth;
        $pdf = PDF::loadView('admin.expenseslistpdf', compact('data'));

        return $pdf->download('経費科目一覧表('.$selectedMonth.').pdf');
    }
    
    function getViewExpenses(Request $request) {
        return view(
            'admin.expenses',
            compact([])
        );
    }

    function getListExpenses(Request $request) {
        $page = $request->page - 1;
        $sortName = "parent_chitien.date";
        $sortType = "DESC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }
        $data = ParentChitien::orderBy($sortName , $sortType);
        
        
        if(@$request->ngay_bat_dau != '' ){
            $date = date_create( $request->ngay_bat_dau);
            $dateCondition = date_format($date,"Y-m");
            $data = $data->where('date','=' , $dateCondition );
        }
        
        if(@$request->ngay_bat_dau_from != '' ){
            $date = date_create( $request->ngay_bat_dau_from);
            $dateCondition = date_format($date,"Y-m");
            $data = $data->where('date','>=' , $dateCondition );
        }
        if(@$request->ngay_bat_dau_to != '' ){
            $date = date_create( $request->ngay_bat_dau_to);
            $dateCondition = date_format($date,"Y-m");
            $data = $data->where('date','<=' , $dateCondition );
        }

        $count = $data->count();
        $pageTotal = ceil($count/$this->limit);
        $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        $totalPrice = 0;
        foreach ($data as &$item) {
            $monthDate = $item->date;
            $item->date = date('m/Y', strtotime($item->date));

            $item->typeLog1 = 0;
            $item->typeLog2 = 0;
            $item->typeLog3 = 0;
            $item->typeLog4 = 0;
            $item->typeLog5 = 0;
            $item->typeLog6 = 0;
            $item->typeLog7 = 0;
            $item->typeLog8 = 0;
            $item->typeLog9 = 0;
            $item->typeLog10 = 0;
            $item->typeLog11 = 0;
            $item->typeLog12 = 0;
            $item->typeLog13 = 0;
            $item->typeLog14 = 0;
            $item->typeLog15 = 0;
            $item->price = 0;

            
            $chitieudetail = Chitien::where('date', 'like', '%'.$monthDate.'%')->get();


            foreach ($chitieudetail as &$chitieudetailItem) {
                $typeLog = $chitieudetailItem->typeLog;
                $item->price += $chitieudetailItem->price;

                if ($typeLog == 1) {
                    $item->typeLog1 += $chitieudetailItem->price;
                } else if ($typeLog == 2) {
                    $item->typeLog2 += $chitieudetailItem->price;
                } else if ($typeLog == 3) {
                    $item->typeLog3 += $chitieudetailItem->price;
                } else if ($typeLog == 4) {
                    $item->typeLog4 += $chitieudetailItem->price;
                } else if ($typeLog == 5) {
                    $item->typeLog5 += $chitieudetailItem->price;
                } else if ($typeLog == 6) {
                    $item->typeLog6 += $chitieudetailItem->price;
                } else if ($typeLog == 7) {
                    $item->typeLog7 += $chitieudetailItem->price;
                } else if ($typeLog == 8) {
                    $item->typeLog8 += $chitieudetailItem->price;
                } else if ($typeLog == 9) {
                    $item->typeLog9 += $chitieudetailItem->price;
                } else if ($typeLog == 10) {
                    $item->typeLog10 += $chitieudetailItem->price;
                } else if ($typeLog == 11) {
                    $item->typeLog11 += $chitieudetailItem->price;
                } else if ($typeLog == 12) {
                    $item->typeLog12 += $chitieudetailItem->price;
                } else if ($typeLog == 13) {
                    $item->typeLog13 += $chitieudetailItem->price;
                } else if ($typeLog == 14) {
                    $item->typeLog14 += $chitieudetailItem->price;
                } else if ($typeLog == 15) {
                    $item->typeLog15 += $chitieudetailItem->price;
                }
            } 

            $totalPrice += $item->price;

        }
        unset($item);
        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal , 'totalPrice' => $totalPrice]);
    }

    function getViewExpensesDetail(Request $request,$id) {
        $page = $request->page - 1;
        $sortName = "chitien.date";
        $sortType = "ASC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }

        $data = ParentChitien::find($id);
        $monthDate = $data->date;
        $selectedMonth = $monthDate;

        
        $dataChild = Chitien::where('date', 'like', '%'.$monthDate.'%')->orderBy($sortName , $sortType)->get();
        if(@$request->typelog_multi != '' ){
            $dataChild = $dataChild->whereIn('typelog', explode(',', $request->typelog_multi) );
        }

        $sumPay = 0;
        foreach ($dataChild as &$chitieudetailItem) {
            $sumPay += $chitieudetailItem->price;
        }

        $count = $dataChild->count();
        $pageTotal = ceil($count/$this->limit);

        return view(
            'admin.expensesdetail',
            compact(['data' , 'dataChild', 'count','pageTotal', 'id', 'sumPay', 'selectedMonth'])
        );
    }

    function getListExpensesDetail(Request $request) {
        $page = $request->page - 1;
        $sortName = "chitien.date";
        $sortType = "ASC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }
        // echo "<pre>";print_r($sortType);die;
        $id = $request->id;
        $data = ParentChitien::find($id);
        $monthDate = $data->date;
        $selectedMonth = $monthDate;

        $dataChild = Chitien::where('date', 'like', '%'.$monthDate.'%')->orderBy($sortName , $sortType)->get();

        $sumPay = 0;
        foreach ($dataChild as &$chitieudetailItem) {
            $sumPay += $chitieudetailItem->price;
        }

        $count = $dataChild->count();
        $pageTotal = ceil($count/$this->limit);
        // $dataChild = $dataChild->offset($page * $this->limit)->limit($this->limit)->get();

        return response()->json(['data'=>$dataChild,'dataChild'=>$dataChild,'count'=>$count,'pageTotal' => $pageTotal , 'sumPay' => $sumPay, 'selectedMonth' => $selectedMonth]);
    }

    function pdfExpensesDetailReceipt(Request $request , $id) {
        $data = Chitien::find($request->id);
        
        $data->receipt_type = "経費";

        $name = $data->date . '-' . $id;

        $pdf = PDF::loadView('admin.expensesdetailreceiptpdf', compact('data'));
        return $pdf->download('出金伝票('.$name.').pdf');
    }
    
    function getListAll(Request $request) {
        $data = Phep::orderBy("name" , "ASC");
        $data = $data->all();
        return response()->json(['data'=>$data]);
    }

    

    function viewExpenses(Request $request,$id) {
        $data = Chitien::find($request->id);
        
        return view(
            'admin.expensesview',
            compact(['id' ,'data'])
        );
    }

    function pdfViewExpenses(Request $request) {
        $page = $request->page - 1;
        $sortName = "parent_chitien.date";
        $sortType = "DESC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }
        $data = ParentChitien::orderBy($sortName , $sortType);
        
        
        if(@$request->ngay_bat_dau != '' ){
            $date = date_create( $request->ngay_bat_dau);
            $dateCondition = date_format($date,"Y-m");
            $data = $data->where('date','=' , $dateCondition );
        }
        
        if(@$request->ngay_bat_dau_from != '' ){
            $date = date_create( $request->ngay_bat_dau_from);
            $dateCondition = date_format($date,"Y-m");
            $data = $data->where('date','>=' , $dateCondition );
        }
        if(@$request->ngay_bat_dau_to != '' ){
            $date = date_create( $request->ngay_bat_dau_to);
            $dateCondition = date_format($date,"Y-m");
            $data = $data->where('date','<=' , $dateCondition );
        }

        $count = $data->count();
        $pageTotal = ceil($count/$this->limit);
        $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        $totalPrice = 0;
        foreach ($data as &$item) {
            $monthDate = $item->date;
            $item->date = date('m/Y', strtotime($item->date));

            $item->typeLog1 = 0;
            $item->typeLog2 = 0;
            $item->typeLog3 = 0;
            $item->typeLog4 = 0;
            $item->typeLog5 = 0;
            $item->typeLog6 = 0;
            $item->typeLog7 = 0;
            $item->typeLog8 = 0;
            $item->typeLog9 = 0;
            $item->typeLog10 = 0;
            $item->typeLog11 = 0;
            $item->typeLog12 = 0;
            $item->typeLog13 = 0;
            $item->typeLog14 = 0;
            $item->typeLog15 = 0;
            $item->price = 0;

            
            $chitieudetail = Chitien::where('date', 'like', '%'.$monthDate.'%')->get();


            foreach ($chitieudetail as &$chitieudetailItem) {
                $typeLog = $chitieudetailItem->typeLog;
                $item->price += $chitieudetailItem->price;

                if ($typeLog == 1) {
                    $item->typeLog1 += $chitieudetailItem->price;
                } else if ($typeLog == 2) {
                    $item->typeLog2 += $chitieudetailItem->price;
                } else if ($typeLog == 3) {
                    $item->typeLog3 += $chitieudetailItem->price;
                } else if ($typeLog == 4) {
                    $item->typeLog4 += $chitieudetailItem->price;
                } else if ($typeLog == 5) {
                    $item->typeLog5 += $chitieudetailItem->price;
                } else if ($typeLog == 6) {
                    $item->typeLog6 += $chitieudetailItem->price;
                } else if ($typeLog == 7) {
                    $item->typeLog7 += $chitieudetailItem->price;
                } else if ($typeLog == 8) {
                    $item->typeLog8 += $chitieudetailItem->price;
                } else if ($typeLog == 9) {
                    $item->typeLog9 += $chitieudetailItem->price;
                } else if ($typeLog == 10) {
                    $item->typeLog10 += $chitieudetailItem->price;
                } else if ($typeLog == 11) {
                    $item->typeLog11 += $chitieudetailItem->price;
                } else if ($typeLog == 12) {
                    $item->typeLog12 += $chitieudetailItem->price;
                } else if ($typeLog == 13) {
                    $item->typeLog13 += $chitieudetailItem->price;
                } else if ($typeLog == 14) {
                    $item->typeLog14 += $chitieudetailItem->price;
                } else if ($typeLog == 15) {
                    $item->typeLog15 += $chitieudetailItem->price;
                }
            } 

            $totalPrice += $item->price;

        }
        unset($item);

        $selectedMonth = '';
        if(@$request->ngay_bat_dau != '' ){
            $selectedMonth = $request->ngay_bat_dau;
        }
        
        if(@$request->ngay_bat_dau_from != '' ){
            $selectedMonth = $selectedMonth . $request->ngay_bat_dau_from . '～';
        }

        if(@$request->ngay_bat_dau_to != '' ){
            if(@$request->ngay_bat_dau_from != '' ){
                $selectedMonth = $selectedMonth . $request->ngay_bat_dau_to;
            } else {
                $selectedMonth = $selectedMonth . $request->ngay_bat_dau_to . 'まで';
            }
        }

        $count = $data->count();
        $data->sumPay = $totalPrice;
        $data->sumData = $count;
        $data->selectedMonth = $selectedMonth;
        $pdf = PDF::loadView('admin.expensespdf', compact('data'));

        

        return $pdf->download('経費一覧表('.$selectedMonth.').pdf');
    }

    function pdfViewExpensesDetail(Request $request) {
        $page = $request->page - 1;
        $sortName = "chitien.date";
        $sortType = "ASC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }
        $id = $request->id;
        $data = ParentChitien::find($id);
        $monthDate = $data->date;

        $dataChild = Chitien::where('date', 'like', '%'.$monthDate.'%')->orderBy($sortName , $sortType)->get();

        $sumPay = 0;
        $selectedMonth = $data->date;
        foreach ($dataChild as &$chitieudetailItem) {
            $sumPay += $chitieudetailItem->price;
        }

        $count = $dataChild->count();
        $data->sumPay = $sumPay;
        $data->sumData = $count;
        $data->selectedMonth = $data->date;

        unset($item);

        $pdf = PDF::loadView('admin.expensesdetailpdf', compact('data','dataChild'));

        return $pdf->download('経費支払月報('.$data->selectedMonth.').pdf');
    }

    function editPass(Request $request,$id) {
        
        $data = Phep::find($request->id);
        $data->name = $request->name;
        $data->image = $request->image;
        $data->description = $request->description;
        $data->save();
        return response()->json(['data'=>$data]);
    }

    function addData(Request $request) {
        
        $data = new Phep();
        $data->name = $request->name;
        $data->image = $request->image;
        $data->description = $request->description;
        $data->save();
        return response()->json(['data'=>$data]);
    }
    function add(Request $request) {
        $message = [
            "message" => "",
            "status" => 0
        ];
        if ($request->isMethod('post')) {
            try {
                // print_r($request->date);die;
                $data = new ParentChitien();
                $data->date = $request->date;
                $data->save();
                $totalPrice = 0;
                if ($request->jobsConnect && count($request->jobsConnect)  > 0  ) {
                    foreach ($request->jobsConnect as $item) {
                        if ($item['id'] === 'new') {
                            if ($item['type'] !== 'delete') {
                                $dataChildren = new Chitien();
                                $dataChildren->parent_id = $data->id;
                                $dataChildren->name = $item['name'];
                                $dataChildren->price = $item['price'];
                                $dataChildren->date = $item['date'];
                                $dataChildren->file = $item['file'];
                                $dataChildren->note = $item['note'];
                                $dataChildren->typeLog = $item['typeLog'];
                                $dataChildren->created_at = now();
                                $totalPrice += $item['price'];
                                $dataChildren->save();
                            }
                        } 
                        
                    }
                }
                $data->price = $totalPrice;
                $data->save();
                $message = [
                    "message" => "Đã thêm dữ liệu thành công.",
                    "status" => 1
                ];
                return redirect('/admin/chi/edit/'.$data->id)->with('message','Đã thêm dữ liệu thành công.');
            } catch (Exception $e) {
                print_r($e->getMessage());die;
                $message = [
                    "message" => "Có lỗi xảy ra khi thêm vào dữ liệu.",
                    "status" => 2
                ];
            }
        }

        return view(
            'admin.chi.add',
            compact(['message'])
        );

    }
    function edit(Request $request , $id) {
        $message = [
            "message" => "",
            "status" => 0
        ];
        if ($request->isMethod('post')) {
            try {
                $data = ParentChitien::find($id);
                $data->date = $request->date;
                $data->save();
                $totalPrice = 0;
                if ($request->jobsConnect && count($request->jobsConnect)  > 0  ) {
                    foreach ($request->jobsConnect as $item) {
                        if ($item['id'] === 'new') {
                            if ($item['type'] !== 'delete') {
                                $dataChildren = new Chitien();
                                $dataChildren->parent_id = $id;
                                $dataChildren->name = $item['name'];
                                $dataChildren->price = $item['price'];
                                $dataChildren->date = $item['date'];
                                $dataChildren->file = $item['file'];
                                $dataChildren->note = $item['note'];
                                $dataChildren->typeLog = $item['typeLog'];
                                $dataChildren->created_at = now();
                                $totalPrice += $item['price'];
                                $dataChildren->save();
                            }
                        } else {
                            if ($item['type'] !== 'delete') {
                                $dataChildren = Chitien::find($item['id']);
                                $dataChildren->name = $item['name'];
                                $dataChildren->price = $item['price'];
                                $dataChildren->date = $item['date'];
                                $dataChildren->file = $item['file'];
                                $dataChildren->note = $item['note'];
                                $dataChildren->typeLog = $item['typeLog'];
                                $dataChildren->updated_at = now();
                                $totalPrice += $item['price'];
                                $dataChildren->save();
                            } else {
                                Chitien::where('id',$item['id'])->delete();
                            }
                        }
                        
                    }
                } else {
                    Chitien::where('parent_id',$id)->delete();
                }
                $data->price = $totalPrice;
                $data->save();
                $message = [
                    "message" => "Đã thêm dữ liệu thành công.",
                    "status" => 1
                ];
                return redirect('/admin/chi/edit/'.$data->id)->with('message','Đã thêm dữ liệu thành công.');
            } catch (Exception $e) {
                print_r($e->getMessage());die;
                $message = [
                    "message" => "Có lỗi xảy ra khi thêm vào dữ liệu.",
                    "status" => 2
                ];
            }
        }
        $data = ParentChitien::find($id);
        $dataChild = Chitien::where('parent_id',$id)->get();
        return view(
            'admin.chi.edit',
            compact(['message','data' , 'dataChild', 'id'])
        );

    }
    function delete(Request $request,$id) {
        $data = ParentChitien::find($id);
        $data->delete();
        Chitien::where('parent_id',$id)->delete();
        return response()->json(['message'=>'Đã xoá dữ liệu thành công.']);
    }

    function deleteExpenses(Request $request,$id) {
        Chitien::where('id',$id)->delete();
        return response()->json(['message'=>'Đã xoá dữ liệu thành công.']);
    }

    function deleteExpensesDetail(Request $request,$id) {
        ParentChitien::where('id',$id)->delete();
        return response()->json(['message'=>'Đã xoá dữ liệu thành công.']);
    }

    
    function updateExpenses(Request $request , $id) {
        if ($request->isMethod('post')) {
            try {
                $data = Chitien::find($id);
                $data->name = $request->name;
                $data->price = $request->price;
                $data->date = $request->date;
                $data->file = $request->file;
                $data->note = $request->note;
                $data->typeLog = $request->typeLog;
                $data->updated_at = now();
                $data->save();

                return redirect('/admin/expensesview/'.$id)->with('message','Đã thêm dữ liệu thành công.');
            } catch (Exception $e) {
                print_r($e->getMessage());die;
                $message = [
                    "message" => "Có lỗi xảy ra khi thêm vào dữ liệu.",
                    "status" => 2
                ];
            }
        }

        $data = Chitien::where('id',$id)->get()[0];
        return view(
            'admin.expensesupdate',
            compact(['id','data'])
        );
    }

    
    function newExpenses(Request $request) {
        if ($request->isMethod('post')) {
            try {
                // print_r($request->date);die;
                $data = new ParentChitien();
                $data->date = $request->date;
                $data->save();
                return redirect('/admin/expenses-detail/'.$data->id)->with('message','Đã thêm dữ liệu thành công.');
            } catch (Exception $e) {
                print_r($e->getMessage());die;
                $message = [
                    "message" => "Có lỗi xảy ra khi thêm vào dữ liệu.",
                    "status" => 2
                ];
            }
        }

        return view(
            'admin.expensesnew',
            compact([])
        );

    }

    
    
    function newExpensesItem(Request $request) {
        if ($request->isMethod('post')) {
            try {
                // print_r($request->date);die;
                $data = new Chitien();
                $data->date = $request->date;
                $data->typelog = $request->typelog;
                $data->type = $request->type;
                $data->name = $request->name;
                $data->price = $request->price;
                $data->file = $request->file;
                $data->note = $request->note;
                $data->save();
                return redirect('/admin/expensesview/'.$data->id)->with('message','Đã thêm dữ liệu thành công.');
            } catch (Exception $e) {
                print_r($e->getMessage());die;
                $message = [
                    "message" => "Có lỗi xảy ra khi thêm vào dữ liệu.",
                    "status" => 2
                ];
            }
        }

        return view(
            'admin.expensesitemnew',
            compact([])
        );

    }
}
