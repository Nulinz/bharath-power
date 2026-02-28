<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiLoginController;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\ApiSalesController;
use App\Http\Controllers\Api\ApiServiceController;
use App\Http\Controllers\Api\ApiSettingsController;

use App\Http\Controllers\user\UserDasboardController as user;



use App\Http\Controllers\user\EnquiryController as enqController;



Route::match(['get','post'], 'login', [ApiLoginController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
Route::post('sales_dashboard', [ApiLoginController::class, 'sales_dashboard']);
Route::post('sales_lead_enquiry_list', [ApiSalesController::class, 'sales_lead_enquiry_list']);
Route::post('sales_enquiry_profile', [ApiSalesController::class, 'sales_enquiry_profile']);
Route::post('users_list', [ApiLoginController::class, 'users_list']);
Route::post('add_product', [ApisettingsController::class, 'add_product']);
Route::post('edit_product', [ApisettingsController::class, 'edit_product']);
Route::post('update_product', [ApisettingsController::class, 'update_product']);
Route::post('add_group', [ApisettingsController::class, 'add_group']);
Route::post('edit_product', [ApisettingsController::class, 'edit_product']);
Route::post('edit_group', [ApisettingsController::class, 'edit_group']);
Route::post('update_group', [ApisettingsController::class, 'update_group']);
Route::post('add_user', [ApisettingsController::class, 'add_user']);
Route::post('edit_user', [ApisettingsController::class, 'edit_user']);
Route::post('update_user', [ApisettingsController::class, 'update_user']);
Route::post('add_category', [ApisettingsController::class, 'add_category']);
Route::post('edit_category', [ApisettingsController::class, 'edit_category']);
Route::post('update_category', [ApisettingsController::class, 'update_category']);





Route::post('setting_fetch_list', [ApisettingsController::class, 'setting_fetch_list']);
Route::post('product_filter_list', [ApiLoginController::class, 'product_filter_list']);

// Route::get('{id}/view_enquiry', 'EnquiryController@view_enquiry');
// Route::match(['get','post'], 'view_enquiry/{id?}', [enqController::class, 'view_enquiry']);
// Route::post('sales_task_store', [ApiSalesController::class, 'sales_task_store']);
Route::post('service_dashboard', [ApiLoginController::class, 'service_dashboard']);
Route::post('service_lead_enquiry_list', [ApiServiceController::class, 'service_lead_enquiry_list']);
Route::post('service_enquiry_profile', [ApiServiceController::class, 'service_enquiry_profile']);
Route::post('sales_task_store', [ApiSalesController::class, 'sales_task_store']);
Route::post('service_task_store', [ApiServiceController::class, 'service_task_store']);
Route::post('sales_edit_enquiry', [ApiSalesController::class, 'sales_edit_enquiry']);
Route::post('sales_update_enquiry', [ApiSalesController::class, 'sales_update_enquiry']);
Route::post('sales_today_remainder', [ApiSalesController::class, 'sales_today_remainder']);
Route::post('service_edit_enquiry', [ApiServiceController::class, 'service_edit_enquiry']);
Route::post('service_update_enquiry', [ApiServiceController::class, 'service_update_enquiry']);
Route::post('service_today_remainder', [ApiServiceController::class, 'service_today_remainder']);
Route::post('product_group_list', [ApiServiceController::class, 'product_group_list']);
Route::post('product_list', [ApiServiceController::class, 'product_list']);
Route::post('sales_enquiry_store', [ApiSalesController::class, 'sales_enquiry_store']);
Route::post('sales_report_filter', [ApiSalesController::class, 'sales_report_filter']);
Route::post('service_enquiry_store', [ApiServiceController::class, 'service_enquiry_store']);
Route::post('service_report_filter', [ApiServiceController::class, 'service_report_filter']);
Route::post('sale_enquiry_list', [ApiSalesController::class, 'sale_enquiry_list']);
Route::post('ser_enquiry_list', [ApiServiceController::class, 'ser_enquiry_list']);
Route::post('sales_task_index', [ApiSalesController::class, 'sales_task_index']);
Route::post('sale_task_status_update', [ApiSalesController::class, 'sale_task_status_update']);
Route::post('service_task_index', [ApiServiceController::class, 'service_task_index']);
Route::post('service_task_status_update', [ApiServiceController::class, 'service_task_status_update']);
Route::post('sales_task_ext', [ApiSalesController::class, 'sales_task_ext']);
Route::post('service_task_ext', [ApiServiceController::class, 'service_task_ext']);

//Route::post('/add_product', 'SettingsController@product_store');





















// Route::get('/add_task_dashboard', [UserDasboardController::class,'task_index'])->name('user.task_dashboard');








// Route::post('enquiry_receive_list', [ApiUserController::class, 'enquiry_receive_list']);
// Route::post('initial_contact_list', [ApiUserController::class, 'initial_contact_list']);
// Route::post('requirement_gathering_list', [ApiUserController::class, 'requirement_gathering_list']);
// Route::post('requirement_gathering_list', [ApiUserController::class, 'requirement_gathering_list']);
// Route::post('product_list', [ApiUserController::class, 'product_list']);
// Route::post('quotation_preparation_list', [ApiUserController::class, 'quotation_preparation_list']);
// Route::post('quotation_submission_list', [ApiUserController::class, 'quotation_submission_list']);
// Route::post('followup_list', [ApiUserController::class, 'followup_list']);
// Route::post('order_confirmed_list', [ApiUserController::class, 'order_confirmed_list']);
// Route::post('supplied_partial_list', [ApiUserController::class, 'supplied_partial_list']);
// Route::post('supplied_final_list', [ApiUserController::class, 'supplied_final_list']);




}
);
