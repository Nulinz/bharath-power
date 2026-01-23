<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ApiLoginController
{
    //
     //
     public function login(Request $request)
     {
         //dd($request->all());
     $request->validate([
         'contact_number' => 'required',
         'password' => 'required',
     ]);
     $user = DB::table('users')->where('contact_number', $request->contact_number)->first();
     
     if (!$user) {
         return response()->json([
             'status'  => 'success',
             'message' => 'Customer not registered.',
         ], 200);
     }
     return response()->json([
         'status' => 'success',
         'message' => 'Customer status successfully',
         'data' => [
 
             'id' => $user->id,
             'name' => $user->name,
             // 'location' => $customer->c_location,
             // 'permission_type' => $customer->permission_type,
             // 'from_date' =>Carbon::parse($customer->joindate)->format('d-m-Y'),
             // 'permission_date' => Carbon::parse($customer->permission_time)->format('d-m-Y'),
         ]
     ], 200);
 }
}


   


