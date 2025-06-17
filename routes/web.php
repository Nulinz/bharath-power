<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

    // reports
    Route::get('/reports', 'ReportsController@view_report')->name('reports.index');


    Route::get('/enquiries/lead-cycle/{cycle}', 'EnquiryController@showByLeadCycle')->name('enquiry.byCycle');
});

// user group

Route::prefix('user')->name('user.')->namespace('App\Http\Controllers\user')->group(function () {

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
});
