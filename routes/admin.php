<?php
Route::get('/', 'web\PageController@getIndex')->name('home.index');

Route::group(['prefix'=>'admin'],function (){
    Config::set('auth.defines','admin');

//    login
    Route::get('/','Admin\AdminAuth@login')->name('admin.login');
    Route::post('adminlogin','Admin\AdminAuth@dologin');
    Route::get('forgetPassword','Admin\AdminAuth@forgetPassword');
    Route::post('forgetPassword','Admin\AdminAuth@forgetPasswordPost');
    Route::get('reset/password/{token}','Admin\AdminAuth@reset_password');
    Route::post('reset/password/{token}','Admin\AdminAuth@reset_password_post');




    Route::get('lang/{lang}',function ($lang){
        session()->has('lang')?session()->forget('lang'):'';
        $lang == 'ar' ? session()->put('lang','ar') : session()->put('lang','en');
        return back();
    });
//    admin panal
    Route::group(['middleware'=>'auth:admin'], function(){
//        laguage
//        dashboard
        Route::get('/dashboard','DashboardController@home')->name('admin.home');
        Route::post('/sendmail','DashboardController@sendmail')->name('admin.sendmail');
        Route::any('logout','Admin\AdminAuth@a_logout');

//        admins
        Route::resource('admins','Admin\AdminController');
        Route::delete('admins/{id}','Admin\AdminController@destroy');


//        permission & role
        Route::resource('permissions','Admin\roles\PermissionController');
        Route::resource('roles','Admin\roles\RoleController');
        Route::resource('admins/permission_role','Admin\roles\permission_roles');

//        setting
        Route::get('setting','SettingController@index')->name('setting');
        Route::post('setting','SettingController@setting_save')->name('setting.save');
        Route::resource('companies', 'Admin\Companies\CompaniesController');


//        activities
        Route::resource('activities','Admin\activities\ActivitiesController');

//        expulsion
        Route::resource('expulsion','Admin\expulsion\expulsionController');
        Route::resource('expulsioncc','Admin\expulsion\expulsionccController');





//        country && city
        Route::resource('countries','Admin\Country\CountryController');
        Route::resource('cities','Admin\City\CitiesController');
        Route::resource('state','Admin\State\StateController');

//        departments
        Route::resource('departments','Admin\Department\DepartmentsController');
        Route::get('departments/department/print','Admin\Department\DepartmentsController@print');
        Route::get('departments/reports/report','Admin\Department\DepartmentsController@reports')->name('departments.reports');
        Route::get('departments/reports/details','Admin\Department\DepartmentsController@details')->name('departments.details');
        Route::post('departments/reports/pdf','Admin\Department\DepartmentsController@pdf');
        Route::post('departments/getEditBlade','Admin\Department\DepartmentsController@getEditBlade')->name('getEditBlade');
        Route::post('departments/createNewAcc','Admin\Department\DepartmentsController@createNewAcc')->name('createNewAcc');
        Route::post('departments/getTree','Admin\Department\DepartmentsController@getTree')->name('getTree');
        Route::post('departments/initChartAcc','Admin\Department\DepartmentsController@initChartAcc')->name('initChartAcc');
        Route::post('departments/getParentName','Admin\Department\DepartmentsController@getParentName')->name('getParentName');


        Route::get('departments/department/Review','Admin\Department\DepartmentsController@Review');
        Route::get('departments/department/reviewdepartment','Admin\Department\DepartmentsController@reviewdepartment')->name('reviewdepartment');

//        cc

        Route::resource('cc','Admin\Cc\CcController');
        Route::get('cc/department/print','Admin\Cc\CcController@print');
        Route::get('cc/reports/report','Admin\Cc\CcController@reports')->name('cc.reports');
        Route::get('cc/reports/details','Admin\Cc\CcController@details')->name('cc.details');
        Route::post('cc/reports/pdf','Admin\Cc\CcController@pdf');
        Route::post('cc/getEditBlade','Admin\Cc\CcController@getEditBlade')->name('getCcEditBlade');
        Route::post('cc/getCc','Admin\Cc\CcController@getCc')->name('getCc');

        Route::post('cc/createNewAcc','Admin\Cc\CcController@createNewAcc')->name('createCcNewAcc');
        Route::post('cc/initChartAcc','Admin\Cc\CcController@initChartAcc')->name('initCcChartAcc');


        Route::get('cc/department/Review','Admin\Cc\CcController@Review');
        Route::get('cc/department/reviewdepartment','Admin\Cc\CcController@reviewdepartment')->name('reviewdeCcpartment');

//        projects
        Route::resource('projects','Admin\Project\ProjectController');
        Route::get('projects/department/print','Admin\Project\ProjectController@print');
        Route::get('projects/reports/report','Admin\Project\ProjectController@reports')->name('projects.reports');
        Route::get('projects/reports/details','Admin\Project\ProjectController@details')->name('projects.details');
        Route::post('projects/reports/pdf','Admin\Project\ProjectController@pdf');
        Route::post('projects/getTreePrj','Admin\Project\ProjectController@getTree')->name('getTreePrj');
        Route::post('projects/getproj','Admin\Project\ProjectController@getproj')->name('getproj');
        Route::post('projects/getEditBladePrj','Admin\Project\ProjectController@getEditBlade')->name('getEditBladePrj');
        Route::post('projects/createNewAccPrj','Admin\Project\ProjectController@createNewPrj')->name('createNewAccPrj');
        Route::post('projects/initChartAccPrj','Admin\Project\ProjectController@initChartPrj')->name('initChartAccPrj');

        Route::get('getCity','Admin\Project\ProjectController@getCities')->name('getCity');


        Route::get('projects/department/Review','Admin\Project\ProjectController@Review');
        Route::get('projects/department/reviewdepartment','Admin\Project\ProjectController@reviewdepartment')->name('reviewdepartment');




//        users
        Route::resource('users','Admin\UserController');


//        subcriber
        Route::resource('subscribers','Admin\subscriber\SubscribeController');
        Route::post('createCstmNo','Admin\subscriber\SubscribeController@createCstmNo')->name('createCstmNo');
        Route::put('subscribers/status/{id}','Admin\subscriber\SubStatusController@status')->name('subscribers.status');

        // Route::resource('relatedness','Admin\RelatednessController');

        Route::resource('systems','Admin\SystemController');
//        Premium reports
        Route::get('premium','Admin\report\PremiumController@index')->name('premium');






//        employees
        Route::resource('employees','Admin\employees\EmployeeController');


//        supplier
        Route::resource('suppliers','Admin\supplier\MtsSuplirController');
        Route::post('createSupNo','Admin\supplier\MtsSuplirController@createSupNo')->name('createSupNo');



        //Projcontractmfs
        Route::resource('project_contract','Admin\Projcontractmfs\ProjcontractmfsController');
        Route::post('project_contract/getComp','Admin\Projcontractmfs\ProjcontractmfsController@getComp')->name('getComp');
        Route::post('getproj','Admin\Projcontractmfs\ProjcontractmfsController@getproj')->name('getproj');



//        astsupctg
        Route::resource('astsupctg','Admin\Astsupctg\AstsupctgController');


//        activities
        Route::resource('activities','Admin\activities\ActivitiesController');

        Route::resource('subscribers','Admin\subscriber\SubscribeController');
        Route::put('subscribers/status/{id}','Admin\subscriber\SubStatusController@status')->name('subscribers.status');

        Route::get('subscribers/{id}/deActive','SubscribeController@deActive');
        Route::get('subscribers/{id}/active','SubscribeController@active');
        // Route::resource('relatedness','Admin\RelatednessController');


        Route::resource('delegates', 'Admin\Delegates\DelegatesController');



        Route::resource('supervisors', 'Admin\Supervisors\supervisorsController');


        Route::get('/country','Admin\SubscribeController@getCountries');
        Route::get('city','Admin\subscriber\SubscribeController@getCities')->name('getCities');
        Route::get('getBranch','Admin\subscriber\SubscribeController@getBranches')->name('getBranch');


//        report
        Route::resource('reports','Admin\report\ReportController');
        Route::resource('reportsbus','Admin\report\ReportBusController');
//        Route::resource('reportdriver','Admin\report\ReportDriverController');
        Route::resource('reportbranche','Admin\report\ReportBrancheController');
        Route::get('reportbushome','Admin\report\RBusController@index');
//        Route::get('reportdriver','Admin\report\RDriverController@index');

//        Route::get('reportpdf/pdf/{id}',[ 'as' => 'report.pdf', 'uses' =>'Admin\report\ReportDriverController@pdf']);

//        blog
        Route::resource('blog','Admin\blog\BlogController');

//        branches
        Route::resource('branches','Admin\Branches\BranchesController');
        Route::post('branches/getBranchesAndStores','Admin\Branches\BranchesController@getBranchesAndStores')->name('getBranchesAndStores');


//        funds and banks
        Route::get('banks/Receipt/create','Admin\banks\ReceiptController@create')->name('receipt.create');
        Route::get('banks/Receipt/show','Admin\banks\ReceiptController@show')->name('receipt.show');
        Route::get('banks/Receipt/detailsSelect','Admin\banks\ReceiptController@detailsSelect')->name('receipt.detailsSelect');
        Route::get('banks/Receipt/cc','Admin\banks\ReceiptController@cc')->name('receipt.cc');
        Route::get('banks/Receipt/invoice','Admin\banks\ReceiptController@index')->name('receipts.invoice');
        Route::get('receiptsData/create','Admin\banks\ReceiptController@receiptsData')->name('receiptsData.create');
//        Route::delete('receiptsData/{id}','Admin\banks\ReceiptController@receiptsDataDelete')->name('receiptsData.destroy');
        Route::get('banks/Receipt/invoice/invoice','Admin\banks\ReceiptController@invoice');
        Route::get('banks/Receipt/receipts/{id}/edit','Admin\banks\ReceiptController@edit');
        Route::put('banks/Receipt/receipts/{id}','Admin\banks\ReceiptController@update')->name('receipts.update');
//        edit by Ibrahim El Monier
        Route::post('banks/Receipt/receipts/pdf/{id}','Admin\banks\ReceiptController@pdf');
//        end edit by Ibrahim El Monier
        // Route::post('banks/Receipt/receipts/print/{id}','Admin\banks\ReceiptController@print');
        // Route::get('banks/Receipt/receipts/print/{id}','Admin\banks\ReceiptController@print')->name('receipts.print');
        Route::get('banks/Receipt/receipts','Admin\banks\ReceiptController@receipts')->name('receipts');
        Route::post('receiptsData/editdatatable','Admin\banks\ReceiptController@editdatatable');
        Route::post('receiptsData/select','Admin\banks\ReceiptController@select');
        Route::get('banks/Receipt/receipts/{id}','Admin\banks\ReceiptController@receiptsShow')->name('receiptsShow');
        Route::delete('banks/Receipt/invoice/{id}','Admin\banks\ReceiptController@destroy')->name('receipts.destroy');
        Route::post('banks/Receipt','Admin\banks\ReceiptController@store')->name('receipt.store');
        Route::post('receiptsData/delete','Admin\banks\ReceiptController@delete');
        Route::post('receiptsData/singledelete','Admin\banks\ReceiptController@singledelete');

        Route::resource('rcatchs', 'Admin\banks\ReceiptCatchController');
        Route::get('hijri', 'Admin\banks\ReceiptCatchController@convertToDateToHijri')->name('hijri');
        Route::post('getSalesMan', 'Admin\banks\ReceiptCatchController@getSalesMan')->name('getSalesMan');
        Route::post('createTrNo', 'Admin\banks\ReceiptCatchController@createTrNo')->name('createTrNo');
        Route::post('getSubAcc', 'Admin\banks\ReceiptCatchController@getSubAcc')->name('getSubAcc');
        Route::post('getMainAccNo', 'Admin\banks\ReceiptCatchController@getMainAccNo')->name('getMainAccNo');
        Route::post('getTaxValue', 'Admin\banks\ReceiptCatchController@getTaxValue')->name('getTaxValue');
        Route::post('validateCache', 'Admin\banks\ReceiptCatchController@validateCache')->name('validateCache');
        Route::post('getCatchRecpt', 'Admin\banks\ReceiptCatchController@getCatchRecpt')->name('getCatchRecpt');
        Route::get('printCatchRecpt/{id}','Admin\banks\ReceiptCatchController@print')->name('printCatchRecpt');
        Route::post('branchForEdit','Admin\banks\ReceiptCatchController@branchForEdit')->name('branchForEdit');
        Route::post('getRcptDetails','Admin\banks\ReceiptCatchController@getRcptDetails')->name('getRcptDetails');


        Route::get('banks/Receipt/receipts/catch/catch','Admin\banks\ReceiptController@catchindex')->name('receipts.catch');
        Route::get('banks/Receipt/receipts/caching/caching','Admin\banks\ReceiptController@cachingindex')->name('receipts.caching');
        Route::get('banks/Receipt/receipts/catch/all','Admin\banks\ReceiptController@catch')->name('receipts.catch');
        Route::get('banks/Receipt/receipts/caching/all','Admin\banks\ReceiptController@caching')->name('receipts.caching');
        Route::get('limitations/notice/noticedebt','Admin\limitations\LimitationsController@noticedebt');
        Route::get('limitations/dept/create','Admin\limitations\LimitationsController@debt');

        Route::resource('accbanks', 'Admin\setting\GLaccBnkCintroller');
        Route::post('accbanks/getAcc', 'Admin\setting\GLaccBnkCintroller@getAcc')->name('getAcc');
        Route::post('accbanks/getCharts', 'Admin\setting\GLaccBnkCintroller@getCharts')->name('getCharts');



        //Notices
        Route::resource('notice', 'Admin\Notice\NoticeController');
        Route::get('hijri', 'Admin\Notice\NoticeController@convertToDateToHijri')->name('hijri');
        Route::post('getSalesMan', 'Admin\Notice\NoticeController@getSalesMan')->name('getSalesMan');
        Route::post('createTrNo', 'Admin\Notice\NoticeController@createTrNo')->name('createTrNo');
        Route::post('getSubAcc', 'Admin\Notice\NoticeController@getSubAcc')->name('getSubAcc');
        Route::post('getMainAccNo', 'Admin\Notice\NoticeController@getMainAccNo')->name('getMainAccNo');
        Route::post('getTaxValue', 'Admin\Notice\NoticeController@getTaxValue')->name('getTaxValue');
        Route::post('validateCache', 'Admin\Notice\NoticeController@validateCache')->name('validateCache');
        Route::post('getCatchRecpt', 'Admin\Notice\NoticeController@getCatchRecpt')->name('getCatchRecpt');
        Route::get('printCatchRecpt/{id}','Admin\Notice\NoticeController@print')->name('printCatchRecpt');
        Route::post('branchForEdit','Admin\Notice\NoticeController@branchForEdit')->name('branchForEdit');
        Route::post('getRcptDetails','Admin\Notice\NoticeController@getRcptDetails')->name('getRcptDetails');



//        limitations
        Route::resource('limitations','Admin\limitations\LimitationsController');
        Route::get('limitations/show/{id}','Admin\limitations\limitationsData@show')->name('limitations.show');
        Route::post('limitationsData/create','Admin\limitations\limitationsData@create');
        Route::post('limitationsData/editdatatable','Admin\limitations\limitationsData@editdatatable');
        Route::post('limitationsData','Admin\limitations\limitationsData@store')->name('limitations.store');
        Route::get('limitationsData/invoice','Admin\limitations\limitationsData@index')->name('limitations.invoice');
        Route::get('limitationsData/invoice/invoice','Admin\limitations\limitationsData@invoice');
        Route::post('limitationsData/invoice/print/{id}','Admin\limitations\limitationsData@print');
        Route::get('limitationsData/invoice/print/{id}','Admin\limitations\limitationsData@print')->name('limitation.print');
        Route::post('limitationsData/invoice/pdf/{id}','Admin\limitations\limitationsData@pdf');
        Route::post('limitationsData/select','Admin\limitations\limitationsData@select');
        Route::post('limitationsData/delete','Admin\limitations\limitationsData@destroy');
        Route::post('limitationsData/softdelete','Admin\limitations\limitationsData@softdelete');

//        openingentry
        Route::resource('openingentry','Admin\limitations\OpeningEntryController');
        Route::post('openingentrydata','Admin\limitations\OpeningEntryData@store')->name('openingentrydata.store');
        Route::post('openingentrydata/create','Admin\limitations\OpeningEntryData@create');
        Route::post('openingentrydata/select','Admin\limitations\OpeningEntryData@select');
        Route::get('openingentrydata/invoice','Admin\limitations\OpeningEntryData@index')->name('openingentrydata.invoice');
        Route::get('openingentrydata/show/{id}','Admin\limitations\OpeningEntryData@show')->name('openingentrydata.show');
        Route::post('openingentrydata/invoice/print/{id}','Admin\limitations\OpeningEntryData@print');
        Route::get('openingentrydata/invoice/print/{id}','Admin\limitations\OpeningEntryData@print')->name('openingentry.print');
        Route::post('openingentrydata/invoice/pdf/{id}','Admin\limitations\OpeningEntryData@pdf');
        Route::get('openingentrydata/invoice/invoice','Admin\limitations\OpeningEntryData@invoice');


//        accountingReports
//        dailyReport
        Route::get('dailyReport','Admin\accountingReports\dailyReportController@index');
        Route::get('dailyReport/show','Admin\accountingReports\dailyReportController@show');
        Route::get('dailyReport/details','Admin\accountingReports\dailyReportController@details');
        Route::post('dailyReport/pdf','Admin\accountingReports\dailyReportController@pdf');



//        accountStatement
        Route::get('accountStatement','Admin\accountingReports\accountStatementController@index');
        Route::get('accountStatement/show','Admin\accountingReports\accountStatementController@show');
        Route::get('accountStatement/details','Admin\accountingReports\accountStatementController@details');
        Route::Post('accountStatement/pdf','Admin\accountingReports\accountStatementController@pdf');
//        trialBalanceController
        Route::get('trialbalance','Admin\accountingReports\trialBalanceController@index');
        Route::get('trialbalance/show','Admin\accountingReports\trialBalanceController@show');
        Route::get('trialbalance/details','Admin\accountingReports\trialBalanceController@details');
        Route::get('trialbalance/details2','Admin\accountingReports\trialBalanceController@details2');
        Route::post('trialbalance/pdf','Admin\accountingReports\trialBalanceController@pdf');
        Route::post('trialbalance/pdf2','Admin\accountingReports\trialBalanceController@pdf2');


//        publicbalance
        Route::get('publicbalance','Admin\accountingReports\publicBalanceController@index');
        Route::get('publicbalance/show','Admin\accountingReports\publicBalanceController@show');
        Route::post('publicbalance/pdf','Admin\accountingReports\publicBalanceController@pdf');
        Route::get('publicbalance/level','Admin\accountingReports\publicBalanceController@level');


        // Projects data for projects
//        Route::resource('projects', 'Admin\Project\ProjectController');
//        Route::resource('project_contract', 'Admin\Project_contract\projectcontractcontroller');
//        Route::resource('projects', 'Admin\Project\ProjectController');
//        Route::resource('projects', 'Admin\Project\ProjectController1');
//        Route::resource('project_contract', 'Admin\Project_contract\projectcontractcontroller');

        route::get('/admin/contracttype','Admin\Contract\ContractController@contracttype')->name('contract.type');
        route::post('/admin/contracttype','Admin\Contract\ContractController@contracttypeadd')->name('contract.add');
        route::get('/contracts/deleteperson/{id}','Admin\Contract\ContractController@resposible')->name('resposibleperson.delete');

        route::get('/contractortype','Admin\Contractors\ContractorsController@contractortype')->name('contractor.type');
        route::post('/contractortype','Admin\Contractors\ContractorsController@contractortypeadd')->name('contractor.add');
        route::get('/contracts/deleteperson/{id}','Admin\Contractors\ContractorsController@resposible')->name('resposibleperson.delete');

        Route::resource('contractors', 'Admin\Contractors\ContractorsController');
        Route::resource('contracts', 'Admin\Contracts\ContractsController');
        Route::resource('ProjectsSites', 'Admin\ProjectsSites\ProjectsSitesController');
    });

});
