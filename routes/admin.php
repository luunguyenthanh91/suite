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

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'my-bank'], function () {
    Route::get('/',                  'MyBankController@list')->name('admin.myBank');
    Route::get('get-list',                  'MyBankController@getList')->name('admin.getMyBank');
    Route::get('get-list-all',                  'MyBankController@getListAll')->name('admin.getAllMyBank');
    Route::post('edit/{id}',                  'MyBankController@edit')->name('admin.editMyBank');
    Route::get('edit/{id}',                  'MyBankController@edit')->name('admin.editMyBank');
    Route::get('delete/{id}',                  'MyBankController@delete')->name('admin.deleteMyBank');
    Route::post('add',                  'MyBankController@add')->name('admin.addMyBank');
    Route::get('add',                  'MyBankController@add')->name('admin.addMyBank');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'mails'], function () {
    Route::get('/',                  'MailTemplateController@list')->name('admin.myMails');
    Route::get('get-list',                  'MailTemplateController@getList')->name('admin.getMails');
    Route::get('get-list-all',                  'MailTemplateController@getListAll')->name('admin.getAllMails');
    Route::post('edit/{id}',                  'MailTemplateController@edit')->name('admin.editMails');
    Route::get('edit/{id}',                  'MailTemplateController@edit')->name('admin.editMails');
    Route::get('delete/{id}',                  'MailTemplateController@delete')->name('admin.deleteMails');
    Route::post('add',                  'MailTemplateController@add')->name('admin.addMails');
    Route::get('add',                  'MailTemplateController@add')->name('admin.addMails');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'collaborators'], function () {
    Route::get('/',                  'CollaboratorsController@list')->name('admin.Collaborators');
    Route::get('get-list',                  'CollaboratorsController@getList')->name('admin.getCollaborators');
    Route::get('get-list-all',                  'CollaboratorsController@getListAll')->name('admin.getAllCollaborators');
    Route::post('edit/{id}',                  'CollaboratorsController@edit')->name('admin.editCollaborators');
    Route::get('edit/{id}',                  'CollaboratorsController@edit')->name('admin.editCollaborators');
    Route::get('get-detail-id/{id}',                  'CollaboratorsController@getDetailId')->name('admin.editCollaborators');
    Route::get('delete/{id}',                  'CollaboratorsController@delete')->name('admin.deleteCollaborators');
    Route::post('add',                  'CollaboratorsController@add')->name('admin.addCollaborators');
    Route::get('add',                  'CollaboratorsController@add')->name('admin.addCollaborators');
    Route::get('list-bank/{id}',                  'CollaboratorsController@getListBankOfCollaborators');
    Route::get('list-collaborators-address',                  'CollaboratorsController@getListByAddress');
    Route::get('list-collaborators-address-condition',                  'CollaboratorsController@getListByAddressAndCondition');
    Route::get('report-day',                  'CollaboratorsController@day');
    Route::get('report-district',                  'CollaboratorsController@district');
    
});


Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'ctvjobs'], function () {
    Route::get('/',                  'CtvJobsController@list')->name('admin.CtvJobs');
    Route::get('get-list',                  'CtvJobsController@getList')->name('admin.getCtvJobs');
    Route::get('get-list-all',                  'CtvJobsController@getListAll')->name('admin.getAllCtvJobs');
    Route::post('edit/{id}',                  'CtvJobsController@edit')->name('admin.editCtvJobs');
    Route::get('edit/{id}',                  'CtvJobsController@edit')->name('admin.editCtvJobs');
    Route::get('get-detail-id/{id}',                  'CtvJobsController@getDetailId')->name('admin.editCtvJobs');
    Route::get('delete/{id}',                  'CtvJobsController@delete')->name('admin.deleteCtvJobs');
    Route::post('add',                  'CtvJobsController@add')->name('admin.addCtvJobs');
    Route::get('add',                  'CtvJobsController@add')->name('admin.addCtvJobs');
    Route::get('list-bank/{id}',                  'CtvJobsController@getListBankOfCtvJobs');
    
});
Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'chi'], function () {
    Route::get('list',                  'ChitienController@list')->name('admin.listChi');
    Route::get('get-list',                  'ChitienController@getList')->name('admin.getChi');
    Route::get('get-list-all',                  'ChitienController@getListAll')->name('admin.getAllChi');
    Route::post('edit/{id}',                  'ChitienController@edit')->name('admin.editChi');
    Route::get('edit/{id}',                  'ChitienController@edit')->name('admin.editChi');
    Route::get('delete/{id}',                  'ChitienController@delete')->name('admin.deleteChi');
    Route::post('add',                  'ChitienController@add')->name('admin.addChi');
    Route::get('add',                  'ChitienController@add')->name('admin.addChi');
    Route::get('thong-ke',                  'ChitienController@report');
    Route::get('thong-ke-api',                  'ChitienController@reportAPI');
});
Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'cusjobs'], function () {
    Route::get('/',                  'CusJobsController@list')->name('admin.CusJobs');
    Route::get('get-list',                  'CusJobsController@getList')->name('admin.getCusJobs');
    Route::get('get-list-all',                  'CusJobsController@getListAll')->name('admin.getAllCusJobs');
    Route::post('edit/{id}',                  'CusJobsController@edit')->name('admin.editCusJobs');
    Route::get('edit/{id}',                  'CusJobsController@edit')->name('admin.editCusJobs');
    Route::get('get-detail-id/{id}',                  'CusJobsController@getDetailId')->name('admin.editCusJobs');
    Route::get('delete/{id}',                  'CusJobsController@delete')->name('admin.deleteCusJobs');
    Route::post('add',                  'CusJobsController@add')->name('admin.addCusJobs');
    Route::get('add',                  'CusJobsController@add')->name('admin.addCusJobs');
    Route::get('list-bank/{id}',                  'CusJobsController@getListBankOfCusJobs');
    Route::get('/import',                  'CusJobsController@import');
    
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth']], function () {
    
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

    Route::get('get-project',                  'ProjectController@getListProject')->name('admin.getListProject');
    Route::get('project',                  'ProjectController@getViewProject');

    Route::post('projectnew',                  'ProjectController@addProject')->name('admin.addProject');
    Route::get('projectnew',                  'ProjectController@addProject')->name('admin.addProject');

    Route::post('projectview/{id}',                  'ProjectController@viewProject')->name('admin.viewProject');
    Route::get('projectview/{id}',                  'ProjectController@viewProject')->name('admin.viewProject');

    // Route::post('projectedit/{id}',                  'CompanyController@edit')->name('admin.edit');
    // Route::get('projectedit/{id}',                  'CompanyController@edit')->name('admin.edit');

    
    Route::post('projectupdate/{id}',                  'ProjectController@updateProject')->name('admin.updateProject');
    Route::get('projectupdate/{id}',                  'ProjectController@updateProject')->name('admin.updateProject');

  
    Route::get('get-partner-interpreter',                  'CompanyController@getListPD')->name('admin.getListPD');
    Route::get('partner-interpreter',                  'CompanyController@listPD');
    Route::get('partner-interpreter-pdf', 'CompanyController@pdfListPD');

    Route::get('partner-sale-pdf', 'CompanyController@pdfListSale');
    Route::get('get-list-sale',                  'CompanyController@getListSale')->name('admin.getAllCompanySale');
    Route::get('partner-sale',                  'CompanyController@listSale');
    Route::get('partner-sale-receipt-pdf/{id}', 'CompanyController@pdfSaleReceipt');   
    Route::get('partner-interpreter-receipt-pdf/{id}', 'CompanyController@pdfInterpreterReceipt');   

    Route::get('get-move-fee',                  'CompanyController@getListMoveFee')->name('admin.getListMoveFee');
    Route::get('move-fee',                  'CompanyController@listMoveFee');
    Route::get('move-fee-pdf', 'CompanyController@pdfMoveFee');
    Route::get('move-fee-receipt-pdf/{id}', 'CompanyController@pdfMoveFeeReceipt');

    Route::get('get-bank-fee',                  'CompanyController@getListBankFee')->name('admin.getListBankFee');
    Route::get('bank-fee',                  'CompanyController@listBankFee');
    Route::get('bank-fee-pdf', 'CompanyController@pdfBankFee');

    Route::get('get-earnings',                  'CompanyController@getListEarnings')->name('admin.getListEarnings');
    Route::get('earnings',                  'CompanyController@listEarnings');

    Route::get('get-cost',                  'CompanyController@getListCost')->name('admin.getListCost');
    Route::get('cost',                  'CompanyController@listCost');
    
    Route::get('get-benefit',                  'CompanyController@getListBenefit')->name('admin.getListBenefit');
    Route::get('benefit',                  'CompanyController@listBenefit');

    Route::get('calendar',                  'ReportController@calendar');

    
    Route::get('get-dashboard',                  'CompanyController@getListDashboard')->name('admin.getListDashboard');
    Route::get('/',                  'CompanyController@listDashboard');

    

    Route::get('get-taxpd',                  'CompanyController@getListTaxPD')->name('admin.getListTaxPD');
    Route::get('taxpd',                  'CompanyController@listTaxPD');
    Route::get('pdf-taxpd', 'CompanyController@pdfTaxPD');
});


Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'company'], function () {
    // Route::get('/',                  'CompanyController@list')->name('admin.Company');
    // Route::get('get-list',                  'CompanyController@getList')->name('admin.getCompany');
    // Route::get('get-list-all',                  'CompanyController@getListAll')->name('admin.getAllCompany');


    Route::get('get-partner-interpreter',                  'CompanyController@getListPD')->name('admin.getListPD');
    Route::get('partner-interpreter',                  'CompanyController@listPD');

	Route::get('get-list-pay',                  'CompanyController@getListPay')->name('admin.getAllCompanyPay');
    Route::get('list-pay',                  'CompanyController@listPay');
	
    
    Route::get('delete/{id}',                  'CompanyController@delete')->name('admin.deleteCompany');
   
    Route::get('send-mail',                  'CompanyController@sendMail');
    Route::post('send-mail-template',                  'CompanyController@SendEmailTemplateJobs');


    Route::get('pdf/{id}', 'CompanyController@pdf');
    Route::get('pdf-type/{id}', 'CompanyController@pdfType');
    Route::get('pdf-type-new/{id}', 'CompanyController@pdfTypeNew');
    Route::get('pdf-pay', 'CompanyController@pdfPay');
    Route::get('pdf-earnings', 'CompanyController@pdfEarnings');

});
Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'report'], function () {
    Route::get('/',                  'ReportController@index');
});
Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'chart-report-jobs'], function () {
    Route::get('/',                  'ReportController@chart');
});
Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'chart-report-price'], function () {
    Route::get('/',                  'ReportController@chartPrice');
    Route::get('/news',                  'ReportController@chartPriceNew');
});

/* Dashboard */
Route::group(['namespace' => 'Admin',   'prefix' => 'district'], function () {
    Route::get('list-by-province/{id}',                  'DistrictController@getDistrictByProvinces');
});
Route::group(['namespace' => 'Admin',   'prefix' => 'ward'], function () {
    Route::get('list-by-district/{id}',                  'WardsController@getWardsByDistrict');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'jlpt'], function () {
    Route::get('/',                  'JlptController@list');
    Route::get('get-list',                  'JlptController@getList');
    Route::get('get-list-all',                  'JlptController@getListAll');
    Route::post('edit/{id}',                  'JlptController@edit');
    Route::get('edit/{id}',                  'JlptController@edit');
    Route::get('delete/{id}',                  'JlptController@delete');
    Route::post('add',                  'JlptController@add');
    Route::get('add',                  'JlptController@add');
});

Route::group(['namespace' => 'Admin',  'prefix' => 'api'], function () {
    Route::get('/user/{slug}',                  'UserController@checkCode');
    Route::get('/user-out/{slug}',                  'UserController@checkOut');
    Route::get('/user-in/{slug}',                  'UserController@checkIn');
});
