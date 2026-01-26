<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiLoginController;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\user\EnquiryController as enqController;



Route::match(['get','post'], 'login', [ApiLoginController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
Route::post('employee_dashboard', [ApiLoginController::class, 'employee_dashboard']);
Route::post('sales_enquiry_list', [ApiUserController::class, 'sales_enquiry_list']);
Route::post('sales_enquiry_profile', [ApiUserController::class, 'sales_enquiry_profile']);
// Route::get('{id}/view_enquiry', 'EnquiryController@view_enquiry');
Route::match(['get','post'], 'view_enquiry/{id?}', [enqController::class, 'view_enquiry']);
Route::post('sales_enquiry_store', [ApiUserController::class, 'sales_enquiry_store']);







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
