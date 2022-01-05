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

// end router
Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth']], function () {
    // Route::get('/', 'CompanyController@listDashboard')->name('dashboard.index');
    Route::get('/', 'ProjectController@dashboard');
    // Route::get('/', 'ProjectController@getListProject')->name('admin.getListProject');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'group-permission'], function () {
    Route::get('list', 'GroupPermissionsController@list')->name('admin.listGroupPermissions');
    Route::get('get-list', 'GroupPermissionsController@getList')->name('admin.getGroupPermissions');
    Route::get('get-list-all', 'GroupPermissionsController@getListAll')->name('admin.getAllGroupPermissions');
    Route::post('edit/{id}', 'GroupPermissionsController@edit')->name('admin.editGroupPermissions');
    Route::get('delete/{id}', 'GroupPermissionsController@delete')->name('admin.deleteGroupPermissions');
    Route::post('add', 'GroupPermissionsController@addData')->name('admin.addGroupPermissions');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'permission'], function () {
    Route::get('list', 'PermissionsController@list')->name('admin.listPermissions');
    Route::get('get-list', 'PermissionsController@getList')->name('admin.getPermissions');
    Route::get('get-list-all', 'PermissionsController@getListAll')->name('admin.getAllPermissions');
    Route::post('edit/{id}', 'PermissionsController@edit')->name('admin.editPermissions');
    Route::get('delete/{id}', 'PermissionsController@delete')->name('admin.deletePermissions');
    Route::post('add', 'PermissionsController@addData')->name('admin.addPermissions');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'roles'], function () {
    Route::get('list', 'RolesController@list')->name('admin.listRoles');
    Route::get('get-list', 'RolesController@getList')->name('admin.getRoles');
    Route::get('get-list-all', 'RolesController@getListAll')->name('admin.getAllRoles');
    Route::post('edit/{id}', 'RolesController@edit')->name('admin.editRoles');
    Route::get('delete/{id}', 'RolesController@delete')->name('admin.deleteRoles');
    Route::post('add', 'RolesController@addData')->name('admin.addRoles');
    Route::get('check-permission-role/{id}', 'RolesController@checkListPermission')->name('admin.checkPermissionRoles');
    Route::post('update-permission-role/{id}', 'RolesController@addListPermission');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'user'], function () {
    Route::get('list-checkin', 'UserController@listCheckIn');
    Route::get('get-list-check-in', 'UserController@getListCheckin')->name('admin.getListCheckIn');
    Route::get('list', 'UserController@list')->name('admin.listUser');
    Route::get('get-list', 'UserController@getList')->name('admin.getListUser');
    Route::get('add', 'UserController@add')->name('admin.addUser');
    Route::post('add', 'UserController@add')->name('admin.addUser');
    Route::get('edit/{id}', 'UserController@edit')->name('admin.editUser');
    Route::post('edit/{id}', 'UserController@edit')->name('admin.editUser');
    Route::get('delete/{id}', 'UserController@delete')->name('admin.deleteUser');
    Route::get('active-status/{id}', 'UserController@active')->name('admin.activeUser');
    Route::get('deactive-status/{id}', 'UserController@deactive')->name('admin.deactiveUser');
    Route::get('check-permission-role/{id}', 'UserController@checkListPermission');
    Route::post('update-permission-role/{id}', 'UserController@addListPermission');
});

Route::group(['namespace' => 'Admin',  'prefix' => 'authentication'], function () {
        Route::get('logout', 'AuthenticationController@logout')->name('admin-logout');
        Route::get('login', 'AuthenticationController@login')->name('login');
        Route::post('login', 'AuthenticationController@postLogin')->name('post-login');
        Route::get('register', 'AuthenticationController@register')->name('authentication.register');
        Route::get('forgotpassword', 'AuthenticationController@forgotpassword')->name('authentication.forgotpassword');
        Route::get('error404', 'AuthenticationController@error404')->name('authentication.error404');

        //AlphaCep
        Route::post('create-po', 'POController@addPO');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth']], function () {
    Route::get('/', 'ProjectController@dashboard');
    Route::get('get-dashboard', 'ProjectController@dashboard')->name('admin.dashboard');
    // Route::get('/', 'ProjectController@getViewProject');
    
    Route::get('costprepay', 'CostDocController@listCostPrePay'); 
    Route::get('billprepay-view/{id}', 'CostDocController@viewcosttransport')->name('admin.viewcosttransport');
    Route::get('billprepay-update/{id}', 'CostDocController@updatecosttransport')->name('admin.updatecosttransport');
    Route::post('billprepay-update/{id}', 'CostDocController@updatecosttransport')->name('admin.updatecosttransport');


    Route::get('costtransport', 'CostDocController@listCostTransport'); 
    Route::get('get-costtransport', 'CostDocController@getListCostTransport')->name('admin.getListCostTransport');
    Route::post('new-costtransport', 'CostDocController@addcosttransport')->name('admin.addcosttransport');
    Route::get('costtransport-view/{id}', 'CostDocController@viewcosttransport')->name('admin.viewcosttransport');
    Route::post('costtransport-update/{id}', 'CostDocController@updatecosttransport')->name('admin.updatecosttransport');
    Route::get('costtransport-update/{id}', 'CostDocController@updatecosttransport')->name('admin.updatecosttransport');
    Route::get('costtransportsubmit/{id}', 'CostDocController@costtransportsubmit')->name('admin.costtransportsubmit');
    Route::post('costtransportsubmit/{id}', 'CostDocController@costtransportsubmit')->name('admin.costtransportsubmit');
    Route::get('costtransportcheck/{id}', 'CostDocController@costtransportcheck')->name('admin.costtransportcheck');
    Route::post('costtransportcheck/{id}', 'CostDocController@costtransportcheck')->name('admin.costtransportcheck');
    Route::get('costtransportapprove/{id}', 'CostDocController@costtransportapprove')->name('admin.costtransportapprove');
    Route::post('costtransportapprove/{id}', 'CostDocController@costtransportapprove')->name('admin.costtransportapprove');
    Route::post('costtransport-delete/{id}', 'CostDocController@deletecosttransport')->name('admin.deletecosttransport');
    Route::get('costtransport-delete/{id}', 'CostDocController@deletecosttransport')->name('admin.deletecosttransport');
    Route::get('costtransport-pdf/{id}', 'CostDocController@costtransportpdf');

    // Doc File API
    Route::get('list-doc/{id}', 'DocFileController@getListDocFile');
    Route::get('getListDocFile', 'DocFileController@getListDocFile')->name('admin.getListDocFile');
    
    
    // End API Doc File
    Route::get('getListCostTransportDetail', 'CostDocController@getListCostTransportDetail')->name('admin.getListCostTransportDetail');
    
    Route::get('bookname', 'BooknameController@listBookname'); 
    Route::get('get-bookname', 'BooknameController@getListBookname')->name('admin.getListBookname');
    Route::post('new-bookname', 'BooknameController@addBookname')->name('admin.addBookname');
    Route::get('bookname-view/{id}', 'BooknameController@viewBookname')->name('admin.viewBookname');
    Route::post('bookname-update/{id}', 'BooknameController@updateBookname')->name('admin.updateBookname');
    Route::get('bookname-update/{id}', 'BooknameController@updateBookname')->name('admin.updateBookname');
    Route::get('booknamecheck/{id}', 'BooknameController@booknamecheck')->name('admin.booknamecheck');
    Route::post('booknamecheck/{id}', 'BooknameController@booknamecheck')->name('admin.booknamecheck');
    Route::get('booknameapprove/{id}', 'BooknameController@booknameapprove')->name('admin.booknameapprove');
    Route::post('booknameapprove/{id}', 'BooknameController@booknameapprove')->name('admin.booknameapprove');
    Route::post('bookname-delete/{id}', 'BooknameController@deleteBookname')->name('admin.deleteBookname');
    Route::get('bookname-delete/{id}', 'BooknameController@deleteBookname')->name('admin.deleteBookname');
    Route::get('bookname-pdf/{id}', 'BooknameController@booknamepdf');

    Route::get('employee', 'UserController@listEmployee'); 
    Route::post('new-employee', 'UserController@addEmployee')->name('admin.addEmployee');
    Route::get('get-employee', 'UserController@getListEmployee')->name('admin.getListEmployee');
    Route::get('employee-view/{id}', 'UserController@viewEmployee')->name('admin.viewEmployee');
    Route::post('employee-update/{id}', 'UserController@updateEmployee')->name('admin.updateEmployee');
    Route::get('employee-update/{id}', 'UserController@updateEmployee')->name('admin.updateEmployee');
    Route::post('employee-delete/{id}', 'UserController@deleteEmployee')->name('admin.deleteEmployee');
    Route::get('employee-delete/{id}', 'UserController@deleteEmployee')->name('admin.deleteEmployee');
    Route::get('employeecheck/{id}', 'UserController@employeecheck')->name('admin.employeecheck');
    Route::post('employeecheck/{id}', 'UserController@employeecheck')->name('admin.employeecheck');
    Route::get('employeeapprove/{id}', 'UserController@employeeapprove')->name('admin.employeeapprove');
    Route::post('employeeapprove/{id}', 'UserController@employeeapprove')->name('admin.employeeapprove');
    Route::get('getAcademic', 'UserController@getAcademic')->name('admin.getAcademic');

    Route::get('get-worksheet', 'WSController@getListWorkSheet')->name('admin.getListWorkSheet');
    Route::get('worksheet', 'WSController@listWorkSheet'); 
    Route::get('worksheet-view/{id}', 'WSController@viewWorkSheet')->name('admin.viewWorkSheet');
    Route::post('worksheet-update/{id}', 'WSController@updateWorkSheet')->name('admin.updateWorkSheet');
    Route::get('worksheet-update/{id}', 'WSController@updateWorkSheet')->name('admin.updateWorkSheet');

    Route::get('get-payslip', 'WSController@getListPayslip')->name('admin.getListPayslip');
    Route::get('payslip', 'WSController@listPayslip'); 
    Route::get('payslip-view/{id}', 'WSController@viewPayslip')->name('admin.viewPayslip');
    Route::post('payslip-update/{id}', 'WSController@updatePayslip')->name('admin.updatePayslip');
    Route::get('payslip-update/{id}', 'WSController@updatePayslip')->name('admin.updatePayslip');
    
    Route::post('new-payslip', 'WSController@addPayslip')->name('admin.addPayslip');
    Route::post('payslip-delete/{id}', 'WSController@deletePayslip')->name('admin.deletePayslip');
    Route::get('payslip-delete/{id}', 'WSController@deletePayslip')->name('admin.deletePayslip');
    Route::get('payslipcheck/{id}', 'WSController@payslipcheck')->name('admin.payslipcheck');
    Route::post('payslipcheck/{id}', 'WSController@payslipcheck')->name('admin.payslipcheck');
    Route::get('payslipapprove/{id}', 'WSController@payslipapprove')->name('admin.payslipapprove');
    Route::post('payslipapprove/{id}', 'WSController@payslipapprove')->name('admin.payslipapprove');
    Route::get('payslipreceive/{id}', 'WSController@payslipreceive')->name('admin.payslipreceive');
    Route::post('payslipreceive/{id}', 'WSController@payslipreceive')->name('admin.payslipreceive');
    Route::get('payslip-pdf/{id}', 'WSController@payslippdf');
    Route::get('sendmail-payslip/{id}', 'WSController@sendmailpayslip');
    Route::get('sendmail-payslip-check/{id}', 'WSController@sendmailpayslipcheck');

    Route::get('worksheetsche', 'WSController@listWorkSheetSche'); 
    Route::get('worksheetsche-view/{id}', 'WSController@viewWorkSheet')->name('admin.viewWorkSheet');
    Route::post('worksheetsche-update/{id}', 'WSController@updateWorkSheet')->name('admin.updateWorkSheet');
    Route::get('worksheetsche-update/{id}', 'WSController@updateWorkSheet')->name('admin.updateWorkSheet');


    Route::get('worksheetday-view/{id}', 'WSController@viewWorkSheetDay')->name('admin.viewWorkSheetDay');
    Route::post('worksheetday-update/{id}', 'WSController@updateWorkSheetDay')->name('admin.updateWorkSheetDay');
    Route::get('worksheetday-update/{id}', 'WSController@updateWorkSheetDay')->name('admin.updateWorkSheetDay');
    
    Route::post('new-worksheet', 'WSController@addWorkSheet')->name('admin.addWorkSheet');
    Route::get('getListWorkDays', 'WSController@getListWorkDays')->name('admin.getListWorkDays');
    Route::get('worksheetsubmit/{id}', 'WSController@worksheetsubmit')->name('admin.worksheetsubmit');
    Route::post('worksheetsubmit/{id}', 'WSController@worksheetsubmit')->name('admin.worksheetsubmit');
    Route::get('worksheetcheck/{id}', 'WSController@worksheetcheck')->name('admin.worksheetcheck');
    Route::post('worksheetcheck/{id}', 'WSController@worksheetcheck')->name('admin.worksheetcheck');
    Route::get('worksheetapprove/{id}', 'WSController@worksheetapprove')->name('admin.worksheetapprove');
    Route::post('worksheetapprove/{id}', 'WSController@worksheetapprove')->name('admin.worksheetapprove');
    Route::get('worksheet-pdf/{id}', 'WSController@worksheetpdf');
    Route::post('worksheet-delete/{id}', 'WSController@deleteWorksheet')->name('admin.deleteWorksheet');
    Route::get('worksheet-delete/{id}', 'WSController@deleteWorksheet')->name('admin.deleteWorksheet');



    //AlphaCep
    Route::get('get-po', 'POController@getListPO')->name('admin.getListPO');
    Route::get('po', 'POController@listPO'); 
    Route::get('po-view/{id}', 'POController@viewPO')->name('admin.viewPO');
    Route::post('po-update/{id}', 'POController@updatePO')->name('admin.updatePO');
    Route::get('po-update/{id}', 'POController@updatePO')->name('admin.updatePO');

    Route::get('po-delete/{id}',  'POController@deletePO')->name('admin.deletePO');
    // Route::post('po-update/{id}', 'POController@updatePO')->name('admin.updatePO');

    Route::get('get-project', 'ProjectController@getListProject')->name('admin.getListProject');
    Route::get('project', 'ProjectController@getViewProject');
    Route::get('project-normal', 'ProjectController@getViewProjectNormal');
    Route::get('project-excel', 'ProjectController@exportProject');
    Route::get('project-normal-excel', 'ProjectController@exportProjectNormal');
    Route::get('project-onlyfee', 'ProjectController@getViewProjectOnlyFee');
    Route::get('project-onlyfee-excel', 'ProjectController@exportProjectOnlyFee');
    Route::post('projectnew', 'ProjectController@addProject')->name('admin.addProject');
    Route::get('projectnew', 'ProjectController@addProject')->name('admin.addProject');
    Route::post('project-add-bypo/{id}',      'ProjectController@addProjectByPO')->name('admin.addProjectByPO');
    Route::get('project-add-bypo/{id}',        'ProjectController@addProjectByPO')->name('admin.addProjectByPO');
    Route::post('projectview/{id}', 'ProjectController@viewProject')->name('admin.viewProject');
    Route::get('projectview/{id}', 'ProjectController@viewProject')->name('admin.viewProject');
    Route::get('projectcheck/{id}', 'ProjectController@checkProject')->name('admin.checkProject');
    Route::post('projectcheck/{id}', 'ProjectController@checkProject')->name('admin.checkProject');
    Route::get('projectapprove/{id}', 'ProjectController@approveProject')->name('admin.approveProject');
    Route::post('projectapprove/{id}', 'ProjectController@approveProject')->name('admin.approveProject');
    Route::get('project-report-pdf/{id}', 'ProjectController@pdfProjectReport');
    Route::get('project-report-person-pdf/{id}', 'ProjectController@pdfProjectReportPerson');
    Route::get('project-invoice-pdf/{id}', 'ProjectController@pdfProjectInvoice');
    Route::get('project-invoice-person-pdf/{id}', 'ProjectController@pdfProjectInvoicePerson');

    Route::post('projectupdate/{id}', 'ProjectController@updateProject')->name('admin.updateProject');
    Route::get('projectupdate/{id}', 'ProjectController@updateProject')->name('admin.updateProject');
    Route::post('projectdelete/{id}', 'ProjectController@deleteProject')->name('admin.deleteProject');
    Route::get('projectdelete/{id}', 'ProjectController@deleteProject')->name('admin.deleteProject');

    Route::get('partner-sale-pdf', 'CompanyController@pdfListSale');
    Route::get('get-list-sale', 'CompanyController@getListSale')->name('admin.getAllCompanySale');
    Route::get('partner-sale', 'CompanyController@listSale');
    Route::get('partner-sale-receipt-pdf/{id}', 'CompanyController@pdfSaleReceipt');   
    Route::get('partner-interpreter-receipt-pdf/{id}', 'CompanyController@pdfInterpreterReceipt');   

    Route::get('get-move-fee', 'CompanyController@getListMoveFee')->name('admin.getListMoveFee');
    Route::get('move-fee', 'CompanyController@listMoveFee');
    Route::get('move-fee-pdf', 'CompanyController@pdfMoveFee');
    Route::get('move-fee-receipt-pdf/{id}', 'CompanyController@pdfMoveFeeReceipt');

    Route::get('get-bank-fee', 'CompanyController@getListBankFee')->name('admin.getListBankFee');
    Route::get('bank-fee', 'CompanyController@listBankFee');
    Route::get('bank-fee-pdf', 'CompanyController@pdfBankFee');

    Route::get('get-earnings', 'CompanyController@getListEarnings')->name('admin.getListEarnings');
    Route::get('earnings', 'CompanyController@listEarnings');  
    Route::get('earnings-pdf', 'ProjectController@pdfEarnings');  

    Route::get('get-cost', 'CompanyController@getListCost')->name('admin.getListCost');
    Route::get('cost', 'ProjectController@listCost');    
    Route::get('cost-sale', 'ProjectController@listCostSale');    
    Route::get('cost-interpreter', 'ProjectController@listCostInterpreter'); 
    Route::get('cost-incometax', 'ProjectController@listCostIncomeTax'); 
    Route::get('cost-movefee', 'ProjectController@listCostMoveFee');  
    Route::get('cost-bankfee', 'ProjectController@listCostBankFee'); 
    Route::get('cost-pdf', 'ProjectController@pdfCost'); 
    Route::get('cost-sale-pdf', 'ProjectController@pdfCostSale');   
    Route::get('cost-interpreter-pdf', 'ProjectController@pdfCostInterpreter2');   
    Route::get('cost-interpreter-notpay-pdf', 'ProjectController@pdfCostInterpreter');   
    Route::get('cost-incometax-pdf', 'ProjectController@pdfCostIncomeTax');   
    Route::get('cost-movefee-pdf', 'ProjectController@pdfCostMoveFee');      
    Route::get('cost-bankfee-pdf', 'ProjectController@pdfCostBankFee');
    Route::get('getChartCost', 'ProjectController@getChartCost')->name('admin.chartCost');
    Route::get('getChartCostYear', 'ProjectController@getChartCostYear')->name('admin.chartCostYear');
    Route::get('getChartProjectDate', 'ProjectController@getChartProjectDate')->name('admin.getChartProjectDate');
    Route::get('getChartProjectMonth', 'ProjectController@getChartProjectMonth')->name('admin.getChartProjectMonth');
    Route::get('getChartProjectYear', 'ProjectController@getChartProjectYear')->name('admin.getChartProjectYear');
    Route::get('getChartChartArea', 'ProjectController@getChartChartArea')->name('admin.getChartChartArea');

    
    Route::get('deposit', 'ProjectController@listDeposit'); 
    Route::get('deposit-pdf', 'ProjectController@pdfDeposit');  

    Route::get('get-partner-sale', 'CtvJobsController@getListPartnerSale')->name('admin.getListPartnerSale');
    Route::get('partner-sale', 'CtvJobsController@getViewPartnerSale');    
    Route::post('new-partner-sale', 'CtvJobsController@addPartnerSale')->name('admin.addPartnerSale');
    Route::get('new-partner-sale', 'CtvJobsController@addPartnerSale')->name('admin.addPartnerSale');
    Route::post('partner-sale-view/{id}', 'CtvJobsController@viewPartnerSale')->name('admin.viewPartnerSale');
    Route::get('partner-sale-view/{id}', 'CtvJobsController@viewPartnerSale')->name('admin.viewPartnerSale');
    Route::post('partner-sale-update/{id}', 'CtvJobsController@updatePartnerSale')->name('admin.updatePartnerSale');
    Route::get('partner-sale-update/{id}', 'CtvJobsController@updatePartnerSale')->name('admin.updatePartnerSale');
    Route::get('partner-sale-delete/{id}',  'CtvJobsController@deletePartnerSale')->name('admin.deletePartnerSale');

    Route::get('get-partner-interpreter', 'CollaboratorsController@getListPartnerInterpreter')->name('admin.getListPartnerInterpreter');

    Route::get('partner-interpreter-vn', 'CollaboratorsController@getViewPartnerInterpreterVN')->name('admin.getViewPartnerInterpreterVN');
    Route::get('partner-interpreter-ph', 'CollaboratorsController@getViewPartnerInterpreterPH')->name('admin.getViewPartnerInterpreterPH');
    Route::get('partner-interpreter', 'CollaboratorsController@getViewPartnerInterpreter');  
    Route::post('new-partner-interpreter/{type_lang}', 'CollaboratorsController@addPartnerInterpreter')->name('admin.addPartnerInterpreter');
    Route::get('new-partner-interpreter/{type_lang}', 'CollaboratorsController@addPartnerInterpreter')->name('admin.addPartnerInterpreter');  
    Route::post('partner-interpreter-view/{id}', 'CollaboratorsController@viewPartnerInterpreter')->name('admin.viewPartnerInterpreter');
    Route::get('partner-interpreter-view/{id}', 'CollaboratorsController@viewPartnerInterpreter')->name('admin.viewPartnerInterpreter');
    Route::post('partner-interpreter-update/{id}', 'CollaboratorsController@updatePartnerInterpreter')->name('admin.updatePartnerInterpreter');
    Route::get('partner-interpreter-update/{id}', 'CollaboratorsController@updatePartnerInterpreter')->name('admin.updatePartnerInterpreter');
    Route::get('partner-interpreter-delete/{id}',  'CollaboratorsController@deletePartnerInterpreter')->name('admin.deletePartnerInterpreter');

    
    Route::get('interpreterapprove/{id}', 'CollaboratorsController@approvePartnerInterpreter')->name('admin.approvePartnerInterpreter');
    Route::post('interpreterapprove/{id}', 'CollaboratorsController@approvePartnerInterpreter')->name('admin.approvePartnerInterpreter');
    Route::get('interpretercheck/{id}', 'CollaboratorsController@checkPartnerInterpreter')->name('admin.checkPartnerInterpreter');
    Route::post('interpretercheck/{id}', 'CollaboratorsController@checkPartnerInterpreter')->name('admin.checkPartnerInterpreter');

    
    Route::get('saleapprove/{id}', 'CtvJobsController@approvePartnerSale')->name('admin.approvePartnerSale');
    Route::post('saleapprove/{id}', 'CtvJobsController@approvePartnerSale')->name('admin.approvePartnerSale');
    Route::get('salecheck/{id}', 'CtvJobsController@checkPartnerSale')->name('admin.checkPartnerSale');
    Route::post('salecheck/{id}', 'CtvJobsController@checkPartnerSale')->name('admin.checkPartnerSale');

    Route::get('getChartInterpreter', 'CollaboratorsController@getChartInterpreter')->name('admin.getChartInterpreter');
   
    Route::get('getChartInterpreterMonth', 'CollaboratorsController@getChartInterpreterMonth')->name('admin.getChartInterpreterMonth');
    


    Route::get('get-benefit', 'CompanyController@getListBenefit')->name('admin.getListBenefit');
    Route::get('benefit', 'CompanyController@listBenefit');

    Route::get('get-taxpd', 'CompanyController@getListTaxPD')->name('admin.getListTaxPD');
    Route::get('taxpd', 'CompanyController@listTaxPD');
    Route::get('pdf-taxpd', 'CompanyController@pdfTaxPD');

    Route::get('calendar', 'ReportController@calendar');

    Route::get('getListLog', 'TransactionLogController@getListLog')->name('admin.getListLog');
    Route::get('system_log', 'TransactionLogController@listLog');


    Route::get('customer', 'CusJobsController@list')->name('admin.CusJobs');
    Route::get('get-customer', 'CusJobsController@getList')->name('admin.getCusJobs');
    Route::get('customer-view/{id}', 'CusJobsController@viewCustomer')->name('admin.viewCustomer');
    Route::get('customer-update/{id}', 'CusJobsController@updateCustomer')->name('admin.updateCustomer');
    Route::post('customer-update/{id}', 'CusJobsController@updateCustomer')->name('admin.updateCustomer');
    Route::post('new-customer', 'CusJobsController@addCustomer')->name('admin.addCustomer');
    Route::get('customer-delete/{id}',  'CusJobsController@deleteCustomer')->name('admin.deleteCustomer');
    Route::get('getChartCustomer', 'CusJobsController@getChartCustomer')->name('admin.getChartCustomer');
    Route::get('getChartCustomerLang', 'CusJobsController@getChartCustomerLang')->name('admin.getChartCustomerLang');
    // Route::post('edit/{id}', 'CusJobsController@edit')->name('admin.editCusJobs');
    // Route::get('edit/{id}', 'CusJobsController@edit')->name('admin.editCusJobs');
    // Route::get('get-detail-id/{id}', 'CusJobsController@getDetailId')->name('admin.editCusJobs');
    // Route::get('delete/{id}', 'CusJobsController@delete')->name('admin.deleteCusJobs');
    // Route::post('add', 'CusJobsController@add')->name('admin.addCusJobs');
    // Route::get('add', 'CusJobsController@add')->name('admin.addCusJobs');
    // Route::get('list-bank/{id}', 'CusJobsController@getListBankOfCusJobs');
    // Route::get('/import', 'CusJobsController@import');

    
    Route::get('user-view/{id}', 'UserController@viewUser')->name('admin.viewUser');
    


    
    Route::get('mailtemplate', 'MailTemplateController@listMailTemplateTranslate')->name('admin.listMailTemplateTranslate');
    Route::get('get_sytem_mailtemplate', 'MailTemplateController@getList')->name('admin.getListMailTemplate');
    Route::get('mailtemplate-view/{id}', 'MailTemplateController@viewMailTemplate')->name('admin.viewMailTemplate');
    Route::get('mailtemplate-update/{id}', 'MailTemplateController@updateMailTemplate')->name('admin.updateMailTemplate');
    Route::post('mailtemplate-update/{id}', 'MailTemplateController@updateMailTemplate')->name('admin.updateMailTemplate');
    Route::get('mailtemplate-new', 'MailTemplateController@newMailTemplate')->name('admin.newMailTemplate');
    Route::post('mailtemplate-new', 'MailTemplateController@newMailTemplate')->name('admin.newMailTemplate');
    Route::get('mailtemplate-delete/{id}',  'MailTemplateController@deleteMailTemplate')->name('admin.deleteMailTemplate');
});


Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'company'], function () {
   
    Route::get('send-mail',                  'CompanyController@sendMail');
    Route::post('send-mail-template',                  'CompanyController@SendEmailTemplateJobs');
    Route::get('pdf/{id}', 'CompanyController@pdf');
    Route::get('pdf-type/{id}', 'CompanyController@pdfType');
    Route::get('pdf-type-new/{id}', 'CompanyController@pdfTypeNew');

});


// Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'mobile'], function () {
//     Route::get('/', 'CollaboratorsController@getViewPartnerInterpreterMobile');  
//     Route::get('partner-interpreter', 'CollaboratorsController@getViewPartnerInterpreterMobile');  
//     Route::get('project', 'ProjectController@getViewProjectMobile'); 
//     Route::get('calendar', 'ReportController@calendarMobile');
// });

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'product-types'], function () {
    Route::get('list', 'ProductTypesController@list')->name('admin.listProductTypes');
    Route::get('get-list', 'ProductTypesController@getList')->name('admin.getProductTypes');
    Route::get('get-list-all', 'ProductTypesController@getListAll')->name('admin.getAllProductTypes');
    Route::post('edit/{id}', 'ProductTypesController@edit')->name('admin.editProductTypes');
    Route::get('delete/{id}', 'ProductTypesController@delete')->name('admin.deleteProductTypes');
    Route::post('add', 'ProductTypesController@addData')->name('admin.addProductTypes');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'suppliers'], function () {
    Route::get('list', 'SuppliersController@list')->name('admin.listSuppliers');
    Route::get('get-list', 'SuppliersController@getList')->name('admin.getSuppliers');
    Route::get('get-list-all', 'SuppliersController@getListAll')->name('admin.getAllSuppliers');
    Route::get('edit/{id}', 'SuppliersController@edit')->name('admin.editSuppliers');
    Route::post('edit/{id}', 'SuppliersController@edit')->name('admin.editSuppliers');
    Route::get('delete/{id}', 'SuppliersController@delete')->name('admin.deleteSuppliers');
    Route::get('add', 'SuppliersController@addData')->name('admin.addSuppliers');
    Route::post('add', 'SuppliersController@addData')->name('admin.addSuppliers');
    Route::get('active-status/{id}', 'SuppliersController@active');
    Route::get('deactive-status/{id}', 'SuppliersController@deactive');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'phep'], function () {
    Route::get('list', 'PhepController@list')->name('admin.listPhep');
    Route::get('get-list', 'PhepController@getList')->name('admin.getPhep');
    Route::get('get-list-all', 'PhepController@getListAll')->name('admin.getAllPhep');
    Route::post('edit/{id}', 'PhepController@edit')->name('admin.editPhep');
    Route::get('delete/{id}', 'PhepController@delete')->name('admin.deletePhep');
    Route::post('add', 'PhepController@addData')->name('admin.addPhep');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'do'], function () {
    Route::get('list', 'DoController@list')->name('admin.listDo');
    Route::get('get-list', 'DoController@getList')->name('admin.getDo');
    Route::get('get-list-all', 'DoController@getListAll')->name('admin.getAllDo');
    Route::post('edit/{id}', 'DoController@edit')->name('admin.editDo');
    Route::get('delete/{id}', 'DoController@delete')->name('admin.deleteDo');
    Route::post('add', 'DoController@addData')->name('admin.addDo');
    Route::get('check-permission-role/{id}', 'DoController@checkListPermission');
    Route::post('update-permission-role/{id}', 'DoController@addListPermission');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'my-bank'], function () {
    Route::get('/', 'MyBankController@list')->name('admin.myBank');
    Route::get('get-list', 'MyBankController@getList')->name('admin.getMyBank');
    Route::get('get-list-all', 'MyBankController@getListAll')->name('admin.getAllMyBank');
    Route::post('edit/{id}', 'MyBankController@edit')->name('admin.editMyBank');
    Route::get('edit/{id}', 'MyBankController@edit')->name('admin.editMyBank');
    Route::get('delete/{id}', 'MyBankController@delete')->name('admin.deleteMyBank');
    Route::post('add', 'MyBankController@add')->name('admin.addMyBank');
    Route::get('add', 'MyBankController@add')->name('admin.addMyBank');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'mails'], function () {
    Route::get('/', 'MailTemplateController@list')->name('admin.myMails');
    Route::get('get-list', 'MailTemplateController@getList')->name('admin.getMails');
    Route::get('get-list-all', 'MailTemplateController@getListAll')->name('admin.getAllMails');
    Route::post('edit/{id}', 'MailTemplateController@edit')->name('admin.editMails');
    Route::get('edit/{id}', 'MailTemplateController@edit')->name('admin.editMails');
    Route::get('delete/{id}', 'MailTemplateController@delete')->name('admin.deleteMails');
    Route::post('add', 'MailTemplateController@add')->name('admin.addMails');
    Route::get('add', 'MailTemplateController@add')->name('admin.addMails');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'collaborators'], function () {
    Route::get('/', 'CollaboratorsController@list')->name('admin.Collaborators');
    Route::get('get-list', 'CollaboratorsController@getList')->name('admin.getCollaborators');
    Route::get('get-list-all', 'CollaboratorsController@getListAll')->name('admin.getAllCollaborators');
    Route::post('edit/{id}', 'CollaboratorsController@edit')->name('admin.editCollaborators');
    Route::get('edit/{id}', 'CollaboratorsController@edit')->name('admin.editCollaborators');
    Route::get('get-detail-id/{id}', 'CollaboratorsController@getDetailId')->name('admin.editCollaborators');
    Route::get('delete/{id}', 'CollaboratorsController@delete')->name('admin.deleteCollaborators');
    Route::post('add', 'CollaboratorsController@add')->name('admin.addCollaborators');
    Route::get('add', 'CollaboratorsController@add')->name('admin.addCollaborators');
    Route::get('list-bank/{id}', 'CollaboratorsController@getListBankOfCollaborators');
    Route::get('list-collaborators-address', 'CollaboratorsController@getListByAddress');
    Route::get('list-collaborators-address-condition', 'CollaboratorsController@getListByAddressAndCondition');
    Route::get('report-day', 'CollaboratorsController@day');
    Route::get('report-district', 'CollaboratorsController@district');
    Route::get('export', 'CollaboratorsController@exportCollaborators');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'ctvjobs'], function () {
    Route::get('/', 'CtvJobsController@list')->name('admin.CtvJobs');
    Route::get('get-list', 'CtvJobsController@getList')->name('admin.getCtvJobs');
    Route::get('get-list-all', 'CtvJobsController@getListAll')->name('admin.getAllCtvJobs');
    Route::post('edit/{id}', 'CtvJobsController@edit')->name('admin.editCtvJobs');
    Route::get('edit/{id}', 'CtvJobsController@edit')->name('admin.editCtvJobs');
    Route::get('get-detail-id/{id}', 'CtvJobsController@getDetailId')->name('admin.editCtvJobs');
    Route::get('delete/{id}', 'CtvJobsController@delete')->name('admin.deleteCtvJobs');
    Route::post('add', 'CtvJobsController@add')->name('admin.addCtvJobs');
    Route::get('add', 'CtvJobsController@add')->name('admin.addCtvJobs');
    Route::get('list-bank/{id}', 'CtvJobsController@getListBankOfCtvJobs');
    
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'cusjobs'], function () {
    Route::get('/', 'CusJobsController@list')->name('admin.CusJobs');
    Route::get('get-list', 'CusJobsController@getList')->name('admin.getCusJobs');
    Route::get('get-list-all', 'CusJobsController@getListAll')->name('admin.getAllCusJobs');
    Route::post('edit/{id}', 'CusJobsController@edit')->name('admin.editCusJobs');
    Route::get('edit/{id}', 'CusJobsController@edit')->name('admin.editCusJobs');
    Route::get('get-detail-id/{id}', 'CusJobsController@getDetailId')->name('admin.editCusJobs');
    Route::get('delete/{id}', 'CusJobsController@delete')->name('admin.deleteCusJobs');
    Route::post('add', 'CusJobsController@add')->name('admin.addCusJobs');
    Route::get('add', 'CusJobsController@add')->name('admin.addCusJobs');
    Route::get('list-bank/{id}', 'CusJobsController@getListBankOfCusJobs');
    Route::get('/import', 'CusJobsController@import');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'report'], function () {
    Route::get('/', 'ReportController@index');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'chart-report-jobs'], function () {
    Route::get('/', 'ReportController@chart');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['adminAuth'],  'prefix' => 'chart-report-price'], function () {
    Route::get('/', 'ReportController@chartPrice');
    Route::get('/news', 'ReportController@chartPriceNew');
});

Route::group(['namespace' => 'Admin',   'prefix' => 'district'], function () {
    Route::get('list-by-province/{id}', 'DistrictController@getDistrictByProvinces');
});

Route::group(['namespace' => 'Admin',   'prefix' => 'ward'], function () {
    Route::get('list-by-district/{id}', 'WardsController@getWardsByDistrict');
});

Route::group(['namespace' => 'Admin',  'prefix' => 'api'], function () {
    Route::get('/user/{slug}', 'UserController@checkCode');
    Route::get('/user-out/{slug}', 'UserController@checkOut');
    Route::get('/user-in/{slug}', 'UserController@checkIn');
});
