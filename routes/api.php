<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiLoginController;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\ApiSalesController;
use App\Http\Controllers\Api\ApiServiceController;
use App\Http\Controllers\UserDasboardController;



use App\Http\Controllers\user\EnquiryController as enqController;



Route::match(['get','post'], 'login', [ApiLoginController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
Route::post('sales_dashboard', [ApiLoginController::class, 'sales_dashboard']);
Route::post('sales_enquiry_list', [ApiSalesController::class, 'sales_enquiry_list']);
Route::post('sales_enquiry_profile', [ApiSalesController::class, 'sales_enquiry_profile']);
// Route::get('{id}/view_enquiry', 'EnquiryController@view_enquiry');
// Route::match(['get','post'], 'view_enquiry/{id?}', [enqController::class, 'view_enquiry']);
Route::post('sales_task_store', [ApiSalesController::class, 'sales_task_store']);
Route::post('service_dashboard', [ApiLoginController::class, 'service_dashboard']);
Route::post('service_enquiry_list', [ApiServiceController::class, 'service_enquiry_list']);
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
