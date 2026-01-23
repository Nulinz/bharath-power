<?php

use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ServiceDashboard;
use App\Http\Controllers\user\DashboardController as UserDasboardController;
use App\Http\Controllers\TaskController;



// login show
Route::get('/', [LoginController::class, 'loginshow'])->name('login');
// log validate
Route::post('/logval', [LoginController::class, 'login'])->name('logval');
// logout
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/get-products/{group_id}', function ($group_id) {
    return DB::table('products')
        ->where('group_id', $group_id)
        ->where('status', 'Active')
        ->select('id', 'name')
        ->get();
});

// admin group

Route::prefix('admin')->name('admin.')->namespace('App\Http\Controllers\admin')->middleware('auth')->group(function () {

    // dashboard
    Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard.dashboard');
    // dashboard lead cycle
    Route::get('/enquiries/lead-cycle/{cycle}', 'EnquiryController@showByLeadCycle')->name('enquiry.byCycle');

    // enquiry
    // Route::get('/show_not', 'DashboardController@dashboard_noti')->name('dashboard_noti');
    // Route::get('/dashboard_noti', 'DashboardController@dashboard_noti')->name('admin.dashboard.dashboard');
    // view task dash
    Route::get('/admin/enquiry/view/{id}', 'EnquiryController@enquiry_view')->name('admin.enquiry.enquiry_view');
    // enquiry_list
    Route::get('/enquiry_list', 'EnquiryController@enquiry_list')->name('enquiry.enquiry_list');
    // add enquiry
    Route::get('/add_enquiry', 'EnquiryController@add_enquiry')->name('enquiry.add_enquiry');

    Route::get('/show_taks', 'EnquiryController@show_task')->name('enquiry.show_taks');
    // store enquiry
    Route::post('/store_enquirey', 'EnquiryController@enquiry_store')->name('enquiry.store');
    // view enquiry
    Route::get('{id}/view_enquiry', 'EnquiryController@view_enquiry')->name('enquiry.enquiry_view');
    // add task
    Route::post('/submit_task', 'EnquiryController@store_quote')->name('enquiry.submit_task');
    // update enquiry
    Route::post('/enquiry/update/{id}', 'EnquiryController@update')->name('enquiry.update');
    // enquiry delete
    // Route::post('/del_enquiry/{id}', 'EnquiryController@del_enquiry')->name('del_enquiry');
    Route::post('/del_enquiry/{id}', 'EnquiryController@del_enquiry')->name('del_enquiry');


    // settings
    // Route::get('/settings/{tab?}','SettingsController@settings')->name('settings.settings');
    Route::get('/settings', 'SettingsController@settings')->name('settings.settings');

    // Route::get('/settings','SettingsController@product_view')->name('settings.settings');
    // add product
    Route::get('/add_product', 'SettingsController@add_product')->name('settings.add_product');
    // store product
    Route::post('/add_product', 'SettingsController@product_store')->name('pro_store');
    // edit product
    Route::get('/{id}/edit_prodcut', 'SettingsController@edit_product')->name('settings.edit_product');
    // update product
    Route::post('/update', 'SettingsController@update_product')->name('settings.update_product');
    // add product group
    Route::get('/add_product_group', 'SettingsController@add_group')->name('settings.add_pro_group');
    // group_store
    Route::post('/store_group', 'SettingsController@store_group')->name('store_product_group');
    // group edit
    Route::get('/edit_group/{id}', 'SettingsController@group_edit')->name('settings.edit_group');
    // group_update
    Route::post('/group_update', 'SettingsController@group_update')->name('settings.group_update');
    // add user
    Route::get('/add_user', 'SettingsController@add_user')->name('settings.add_users');
    // edit user
    Route::get('{id}/user_edit', 'SettingsController@users_edit')->name('settings.user_edit');
    // update user
    Route::post('/update_user', 'SettingsController@users_update')->name('settings.update_users');
    // user store
    Route::post('/add_user', 'SettingsController@store_user')->name('settings.user_store');
    // user_view

     // add category
     Route::get('/add_category', 'SettingsController@add_category')->name('settings.add_category');
     //add product store
     Route::post('/category_store', 'SettingsController@category_store')->name('category_store');

      // edit product
    Route::get('/{id}/edit_category', 'SettingsController@edit_category')->name('settings.edit_category');

     // update user
     Route::post('/update_category', 'SettingsController@category_update')->name('settings.update_category');

    // reports
    Route::get('/reports', 'ReportsController@view_report')->name('reports.index');

    // services dashboard
    Route::get('/service-dashboard', 'ServiceDashboard@index')->name('service-dashboard');
    // dashboard lead cycle
    Route::get('/service_enquiries/lead-cycle/{cycle}', 'ServiceEnquiryController@showByLeadCycle')->name('service.enquiry.byCycle');
    // services enquiry/
    Route::get('/service_enquiry_list', 'ServiceEnquiryController@enquiry_list')->name('service.enquiry.enquiry_list');
    // services add enquiry
    Route::get('/service_add_enquiry', 'ServiceEnquiryController@add_enquiry')->name('service.enquiry.add_enquiry');
    // store enquiry
    Route::post('/service_store_enquirey', 'ServiceEnquiryController@enquiry_store')->name('service.enquiry.store');
    // view enquiry
    Route::get('{id}/service_view_enquiry', 'ServiceEnquiryController@view_enquiry')->name('service.enquiry.enquiry_view');
    // update enquiry
    Route::post('/service_enquiry/update/{id}', 'ServiceEnquiryController@update')->name('service.enquiry.update');
    // add task
    Route::post('/service_submit_task', 'ServiceEnquiryController@store_quote')->name('service.enquiry.submit_task');
    // del enquiry
    Route::post('/service_del_enquiry/{id}', 'ServiceEnquiryController@del_enquiry')->name('service.del_enquiry');

    // reports
    Route::get('/service_reports', 'ServiceReportsController@view_report')->name('service.reports.index');
    //
     Route::get('/task_list', 'DashboardController@task_list')->name('admin.task.task_list');

       // add category
    Route::get('/add_task', 'DashboardController@add_task')->name('dash.add_task');

        //add product store
     Route::post('/task_store', 'DashboardController@task_store')->name('task_store');
    //  Route::get('/service_task_list', 'ServiceController@task_list')->name('admin.ser_task.task_list');
     Route::get('service_task_list', [ServiceDashboard::class,'service_task_list'])->name('service.service_task-list');
     Route::get('/add_service_task', [ServiceDashboard::class,'add_service_task'])->name('service.add_service_task');
     Route::get('/service_task_profile', [ServiceDashboard::class,'service_task_profile'])->name('service.service_task_profile');
     Route::get('/sales_task_profile', [AdminDashboardController::class,'sales_task_profile'])->name('admin.sales_task_profile');
     Route::post('/task_sale_store', [AdminDashboardController::class,'task_sale_store'])->name('admin.task_sale_store');
     Route::post('/task_service_store', [AdminDashboardController::class,'task_service_store'])->name('admin.task_service_store');
     Route::post('/sales_task_close', [AdminDashboardController::class, 'sales_task_close'])->name('sales_task_close');
     Route::post('/service_task_close', [AdminDashboardController::class, 'service_task_close'])->name('service_task_close');










       

// Route::get('/', [AdminDashboardController::class, 'Task'])->name('task_list');

 });

// user group

Route::prefix('user')->name('user.')->namespace('App\Http\Controllers\user')->middleware('auth')->group(function () {

    // dashboard
    Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard.dashboard');

    // view task dash
    Route::get('/user/enquiry/view/{id}', 'EnquiryController@enquiry_view')->name('user.enquiry.enquiry_view');
    // enquiry
    Route::get('/enquiry_list', 'EnquiryController@enquiry_list')->name('enquiry.enquiry_list');
    // add enquiry
    Route::get('/add_enquiry', 'EnquiryController@add_enquiry')->name('enquiry.add_enquiry');
    // store enquiry
    Route::post('/store_enquirey', 'EnquiryController@enquiry_store')->name('enquiry.store');
    // add task
    Route::post('/submit_task', 'EnquiryController@store_quote')->name('enquiry.submit_task');
    // view enquiry
    Route::get('{id}/view_enquiry', 'EnquiryController@view_enquiry')->name('enquiry.enquiry_view');
    // update enquiry
    Route::post('/enquiry/update/{id}', 'EnquiryController@update')->name('enquiry.update');

    // settings
    Route::get('/settings', 'SettingsController@settings')->name('settings.settings');
    // add product
    Route::get('/add_product', 'SettingsController@add_product')->name('settings.add_product');
    // edit product
    Route::get('/edit_prodcut', 'SettingsController@edit_product')->name('settings.edit_product');
    // add user
    Route::get('/add_user', 'SettingsController@add_user')->name('settings.add_users');

    // reports
    Route::get('/reports', 'ReportController@view_report')->name('reports.index');

    Route::get('/enquiries/lead-cycle/{cycle}', 'EnquiryController@showByLeadCycle')->name('enquiry.byCycle');


    // services dashboard
    Route::get('/service-dashboard', 'ServiceDashboard@index')->name('service-dashboard');
    // dashboard lead cycle
    Route::get('/service_enquiries/lead-cycle/{cycle}', 'ServiceEnquiryController@showByLeadCycle')->name('service.enquiry.byCycle');
    // services enquiry/
    Route::get('/service_enquiry_list', 'ServiceEnquiryController@enquiry_list')->name('service.enquiry.enquiry_list');
    // services add enquiry
    Route::get('/service_add_enquiry', 'ServiceEnquiryController@add_enquiry')->name('service.enquiry.add_enquiry');
    // store enquiry
    Route::post('/service_store_enquirey', 'ServiceEnquiryController@enquiry_store')->name('service.enquiry.store');
    // view enquiry
    Route::get('{id}/service_view_enquiry', 'ServiceEnquiryController@view_enquiry')->name('service.enquiry.enquiry_view');
    // update enquiry
    Route::post('/service_enquiry/update/{id}', 'ServiceEnquiryController@update')->name('service.enquiry.update');
    // add task
    Route::post('/service_submit_task', 'ServiceEnquiryController@store_quote')->name('service.enquiry.submit_task');
    // reports
    Route::get('/service_reports', 'ServiceReportsController@view_report')->name('service.reports.index');

    Route::get('/add_task_dashboard', [UserDasboardController::class,'task_index'])->name('user.task_dashboard');
    Route::get('/update_task', [UserDasboardController::class,'updateTaskStatus'])->name('update.task');
    Route::get('/add_service_task_dashboard', [UserDasboardController::class,'service_task_index'])->name('service_task_index');
    Route::get('/update_service_status', [UserDasboardController::class,'update_service_status'])->name('update_service_status');
    Route::match(['get','post'], '/task-ext', [UserDasboardController::class,'task_ext'])->name('task.ext');
    Route::match(['get','post'], '/service_task_ext', [UserDasboardController::class,'service_task_ext'])->name('service_task_ext');









});
