<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/* Route::get('/', function () {
    return view('index.index');    
});*/
// new 1 router
// 'middleware' => ['adminAuth'] => có cái này thì phải login mới sài được cái link đó
// 'namespace' => 'Admin' có cái này có nghĩa là nó nằm trong controller Admin ... mình có 2 loại controller là admin và Fe

//'prefix' => 'group-permission' => cái này có nghĩa là domain/admin/group-permission +  với cái router bên trong (/list)
// trỏ nó vào cái controller mình muốn DashboardController@index index chính là function
// muốn tạo 1 link ko cần login cũng xem được thì bỏ middleware ra ngoài là được

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'] , 'prefix' => 'new-link'], function () {
    Route::get('/list',                                     'NewTestController@list');
    Route::post('/list',                                     'NewTestController@list');
    // co 2 dang link la post hay get (method)
    // post dung de nhan du lieu
    // để như cái link trên kia là có thể mở link và tạo form nhận data từ form => ok

    // như thế này thì link của mình là /admin/new-link/list
});

// end router
Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth']], function () {
    Route::get('/',                                     'CompanyController@listDashboard')->name('dashboard.index');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'group-permission'], function () {
    Route::get('list',                  'GroupPermissionsController@list')->name('admin.listGroupPermissions');
    Route::get('get-list',                  'GroupPermissionsController@getList')->name('admin.getGroupPermissions');
    Route::get('get-list-all',                  'GroupPermissionsController@getListAll')->name('admin.getAllGroupPermissions');
    Route::post('edit/{id}',                  'GroupPermissionsController@edit')->name('admin.editGroupPermissions');
    Route::get('delete/{id}',                  'GroupPermissionsController@delete')->name('admin.deleteGroupPermissions');
    Route::post('add',                  'GroupPermissionsController@addData')->name('admin.addGroupPermissions');
});
Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'permission'], function () {
    Route::get('list',                  'PermissionsController@list')->name('admin.listPermissions');
    Route::get('get-list',                  'PermissionsController@getList')->name('admin.getPermissions');
    Route::get('get-list-all',                  'PermissionsController@getListAll')->name('admin.getAllPermissions');
    Route::post('edit/{id}',                  'PermissionsController@edit')->name('admin.editPermissions');
    Route::get('delete/{id}',                  'PermissionsController@delete')->name('admin.deletePermissions');
    Route::post('add',                  'PermissionsController@addData')->name('admin.addPermissions');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'roles'], function () {
    Route::get('list',                  'RolesController@list')->name('admin.listRoles');
    Route::get('get-list',                  'RolesController@getList')->name('admin.getRoles');
    Route::get('get-list-all',                  'RolesController@getListAll')->name('admin.getAllRoles');
    Route::post('edit/{id}',                  'RolesController@edit')->name('admin.editRoles');
    Route::get('delete/{id}',                  'RolesController@delete')->name('admin.deleteRoles');
    Route::post('add',                  'RolesController@addData')->name('admin.addRoles');
    Route::get('check-permission-role/{id}',                  'RolesController@checkListPermission')->name('admin.checkPermissionRoles');
    Route::post('update-permission-role/{id}',                  'RolesController@addListPermission');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'user'], function () {
    Route::get('list-checkin',                  'UserController@listCheckIn');
    Route::get('get-list-check-in',                  'UserController@getListCheckin')->name('admin.getListCheckIn');
    Route::get('list',                  'UserController@list')->name('admin.listUser');
    Route::get('get-list',                  'UserController@getList')->name('admin.getListUser');
    Route::get('add',                  'UserController@add')->name('admin.addUser');
    Route::post('add',                  'UserController@add')->name('admin.addUser');
    Route::get('edit/{id}',                  'UserController@edit')->name('admin.editUser');
    Route::post('edit/{id}',                  'UserController@edit')->name('admin.editUser');
    Route::get('delete/{id}',                  'UserController@delete')->name('admin.deleteUser');
    Route::get('active-status/{id}',                  'UserController@active')->name('admin.activeUser');
    Route::get('deactive-status/{id}',                  'UserController@deactive')->name('admin.deactiveUser');
    Route::get('check-permission-role/{id}',                  'UserController@checkListPermission');
    Route::post('update-permission-role/{id}',                  'UserController@addListPermission');
});


Route::group(['namespace' => 'Admin',  'prefix' => 'authentication'], function () {
        Route::get('logout',                  'AuthenticationController@logout')->name('admin-logout');
        Route::get('login',                  'AuthenticationController@login')->name('login');
        Route::post('login',                  'AuthenticationController@postLogin')->name('post-login');
        Route::get('register',               'AuthenticationController@register')->name('authentication.register');
        Route::get('forgotpassword',         'AuthenticationController@forgotpassword')->name('authentication.forgotpassword');
        Route::get('error404',               'AuthenticationController@error404')->name('authentication.error404');
});


// product
Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'product-types'], function () {
    Route::get('list',                  'ProductTypesController@list')->name('admin.listProductTypes');
    Route::get('get-list',                  'ProductTypesController@getList')->name('admin.getProductTypes');
    Route::get('get-list-all',                  'ProductTypesController@getListAll')->name('admin.getAllProductTypes');
    Route::post('edit/{id}',                  'ProductTypesController@edit')->name('admin.editProductTypes');
    Route::get('delete/{id}',                  'ProductTypesController@delete')->name('admin.deleteProductTypes');
    Route::post('add',                  'ProductTypesController@addData')->name('admin.addProductTypes');
});

// suppliers

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'suppliers'], function () {
    Route::get('list',                  'SuppliersController@list')->name('admin.listSuppliers');
    Route::get('get-list',                  'SuppliersController@getList')->name('admin.getSuppliers');
    Route::get('get-list-all',                  'SuppliersController@getListAll')->name('admin.getAllSuppliers');
    Route::get('edit/{id}',                  'SuppliersController@edit')->name('admin.editSuppliers');
    Route::post('edit/{id}',                  'SuppliersController@edit')->name('admin.editSuppliers');
    Route::get('delete/{id}',                  'SuppliersController@delete')->name('admin.deleteSuppliers');
    Route::get('add',                  'SuppliersController@addData')->name('admin.addSuppliers');
    Route::post('add',                  'SuppliersController@addData')->name('admin.addSuppliers');
    Route::get('active-status/{id}',                  'SuppliersController@active');
    Route::get('deactive-status/{id}',                  'SuppliersController@deactive');
});


Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'phep'], function () {
    Route::get('list',                  'PhepController@list')->name('admin.listPhep');
    Route::get('get-list',                  'PhepController@getList')->name('admin.getPhep');
    Route::get('get-list-all',                  'PhepController@getListAll')->name('admin.getAllPhep');
    Route::post('edit/{id}',                  'PhepController@edit')->name('admin.editPhep');
    Route::get('delete/{id}',                  'PhepController@delete')->name('admin.deletePhep');
    Route::post('add',                  'PhepController@addData')->name('admin.addPhep');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'bophan'], function () {
    Route::get('list',                  'BoPhanController@view');
    Route::get('get-list',                  'BoPhanController@getList')->name('admin.getListBoPhan');
    Route::post('edit/{id}',                  'BoPhanController@edit');
    Route::get('edit/{id}',                  'BoPhanController@edit');
    Route::get('delete/{id}',                  'BoPhanController@delete');
    Route::post('add',                  'BoPhanController@add');
    Route::get('add',                  'BoPhanController@add');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'do'], function () {
    Route::get('list',                  'DoController@list')->name('admin.listDo');
    Route::get('get-list',                  'DoController@getList')->name('admin.getDo');
    Route::get('get-list-all',                  'DoController@getListAll')->name('admin.getAllDo');
    Route::post('edit/{id}',                  'DoController@edit')->name('admin.editDo');
    Route::get('delete/{id}',                  'DoController@delete')->name('admin.deleteDo');
    Route::post('add',                  'DoController@addData')->name('admin.addDo');
    Route::get('check-permission-role/{id}',                  'DoController@checkListPermission');
    Route::post('update-permission-role/{id}',                  'DoController@addListPermission');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth']], function () {
    //経費支払月
    Route::get('get-expenses',                  'ChitienController@getListExpenses')->name('admin.getListExpenses');
    Route::get('expenses',                  'ChitienController@getViewExpenses');
    Route::get('expenses-pdf',                  'ChitienController@pdfViewExpenses');

    Route::get('get-expenses-detail',                  'ChitienController@getListExpensesDetail')->name('admin.getListExpensesDetail');
    Route::get('expenses-detail/{id}',                  'ChitienController@getViewExpensesDetail');
    Route::get('expenses-detail-pdf/{id}',                  'ChitienController@pdfViewExpensesDetail');
    Route::get('expenses-detail-receipt-pdf/{id}', 'ChitienController@pdfExpensesDetailReceipt');
    
    Route::get('expensesview/{id}',                  'ChitienController@viewExpenses')->name('admin.viewExpenses');
    Route::get('expensesdetaildelete/{id}',                  'ChitienController@deleteExpensesDetail')->name('admin.deleteExpensesDetail');
    Route::post('expensesupdate/{id}',                  'ChitienController@updateExpenses')->name('admin.updateExpenses');
    Route::get('expensesupdate/{id}',                  'ChitienController@updateExpenses')->name('admin.updateExpenses');
    Route::get('expensesdelete/{id}',                  'ChitienController@deleteExpenses')->name('admin.deleteExpenses');
    Route::post('expensesnew',                  'ChitienController@newExpenses')->name('admin.newExpenses');
    Route::get('expensesnew',                  'ChitienController@newExpenses')->name('admin.newExpenses');

    //経費一覧
    Route::get('get-expenseslist',                  'ChitienController@getListExpensesItem')->name('admin.getListExpensesItem');
    Route::get('expenseslist',                  'ChitienController@getViewListExpensesItem');
    Route::post('expensesitemnew',                  'ChitienController@newExpensesItem')->name('admin.newExpensesItem');
    Route::get('expensesitemnew',                  'ChitienController@newExpensesItem')->name('admin.newExpensesItem');
    Route::get('expenseslist-pdf',                  'ChitienController@pdfViewExpensesList');

    Route::get('get-dashboard', 'CompanyController@getListDashboard')->name('admin.getListDashboard');
    Route::get('/', 'CompanyController@listDashboard');
});

Route::group(['namespace' => 'Admin',  'prefix' => 'api'], function () {
    Route::get('/user/{slug}',                  'UserController@checkCode');
    Route::get('/user-out/{slug}',                  'UserController@checkOut');
    Route::get('/user-in/{slug}',                  'UserController@checkIn');
});
