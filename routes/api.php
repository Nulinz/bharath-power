<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiLoginController; // <-- Import your controller


Route::match(['get','post'], 'login', [ApiLoginController::class,'login']);
