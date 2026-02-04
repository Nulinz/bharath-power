<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class ApiLoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'contact_number' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('contact_number', $request->contact_number)->first();

        
        if (!$user || $request->password !== $user->password) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
            ], 401);
        }

        

        // if (!$user || !Hash::check($request->password, $user->password)) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Invalid credentials',
        //     ], 401);
        // }

        // ✅ This now WORKS
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'token' => $token,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
            ]
        ], 200);
    }

    public function sales_dashboard(Request $request)
    {
        $userId = Auth::id();
       // dd($userId);
       $user = User::where('id', $userId)
    //    ->where('designation', 'Employee')
       ->first();

       if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'Access denied: Not an employee',
        ], 403);
    }

        $enquiry_received_count = DB::table('enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Enquiry Received')
        ->count();

        $inital_contact_count = DB::table('enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Initial Contact')
        ->count();

        $requirement_gathering_count = DB::table('enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Requirement Gathering')
        ->count();

       

        $product_selection_count = DB::table('enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Product Selection')
        ->count();

        $qutation_preparation_count = DB::table('enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Quotation Preparation')
        ->count();

        $qutation_submission_count = DB::table('enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Quotation')
        ->count();

        $follow_up_count = DB::table('enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Follow-up')
        ->count();

        $order_confirmed_count = DB::table('enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Order confimred')
        ->count();

        $supplied_partial_count = DB::table('enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Material supplied partially')
        ->count();

        $supplied_final_count = DB::table('enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Material supplied final-full')
        ->count();

        $payment_received_partial_count = DB::table('enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Payment received partial')
        ->count();

        $payment_received_final_count = DB::table('enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Payment received final-full')
        ->count();

        $final_decision_count = DB::table('enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Final Decision')
        ->count();

    

        $cancel_count = DB::table('enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Cancelled')
        ->count();

       

        return response()->json([ 
            'status' => 'success',
            'message' => 'Sales Dashboard',
            'enquiry_received_count' => $enquiry_received_count,
            'inital_contact_count' => $inital_contact_count,
            'requirement_gathering_count' => $requirement_gathering_count,
            'product_selection_count' => $product_selection_count,
            'qutation_preparation_count' => $qutation_preparation_count,
            'qutation_submission_count' => $qutation_submission_count,
            'follow_up_count' => $follow_up_count,
            'order_confirmed_count' => $order_confirmed_count,
            

            'supplied_partial_count' => $supplied_partial_count,
            'supplied_final_count' => $supplied_final_count,
            'payment_received_partial_count' => $payment_received_partial_count,
            'payment_received_final_count' => $payment_received_final_count,
            'final_decision_count' => $final_decision_count,
            'cancel_count' => $cancel_count,

           
            // 'data' => [
            //     'id' => $user->id,
                
            // ]
        ], 200);
        // //contractor
        // $contractor_total=UserDetail::where('as_a','=','Contractor')->where('ref_id','=',$user->code)->count();
        // $today_contractor_count = UserDetail::where('as_a', 'Contractor')
        //                 ->where('ref_id', $user->code)
        //                 ->whereDate('created_at', Carbon::today()) // only today’s date
        //                 ->count();

    }

    //

    public function service_dashboard(Request $request)
    {
        $userId = Auth::id();
       // dd($userId);
       $user = User::where('id', $userId)
    //    ->where('designation', 'Employee')
       ->first();

       if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'Access denied: Not an employee',
        ], 403);
    }

        $enquiry_received_count = DB::table('service_enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Enquiry Received')
        ->count();

        $inital_contact_count = DB::table('service_enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Initial Contact')
        ->count();

        $requirement_gathering_count = DB::table('service_enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Requirement Gathering')
        ->count();

       

        $product_selection_count = DB::table('service_enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Product Selection')
        ->count();

        $qutation_preparation_count = DB::table('service_enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Quotation Preparation')
        ->count();

        $qutation_submission_count = DB::table('service_enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Quotation')
        ->count();

        $follow_up_count = DB::table('service_enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Follow-up')
        ->count();

        $service_entry_count = DB::table('service_enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Service Entry')
        ->count();


        $order_confirmed_count = DB::table('service_enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Order confimred')
        ->count();

        $supplied_partial_count = DB::table('service_enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Material supplied partially')
        ->count();

        $supplied_final_count = DB::table('service_enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Material supplied final-full')
        ->count();

        $payment_received_partial_count = DB::table('service_enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Payment received partial')
        ->count();

        $payment_received_final_count = DB::table('service_enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Payment received final-full')
        ->count();

        $final_decision_count = DB::table('service_enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Final Decision')
        ->count();

    

        // $cancel_count = DB::table('enquiry')
        // ->where('assign_to', $user->id)
        // ->where('lead_cycle', 'Cancelled')
        // ->count();

       

        return response()->json([ 
            'status' => 'success',
            'message' => 'Service Dashboard',
            'enquiry_received_count' => $enquiry_received_count,
            'inital_contact_count' => $inital_contact_count,
            'requirement_gathering_count' => $requirement_gathering_count,
            'product_selection_count' => $product_selection_count,
            'qutation_preparation_count' => $qutation_preparation_count,
            'qutation_submission_count' => $qutation_submission_count,
            'follow_up_count' => $follow_up_count,
            'service_entry_count' => $service_entry_count,
            'order_confirmed_count' => $order_confirmed_count,
            

            'supplied_partial_count' => $supplied_partial_count,
            'supplied_final_count' => $supplied_final_count,
            'payment_received_partial_count' => $payment_received_partial_count,
            'payment_received_final_count' => $payment_received_final_count,
            'final_decision_count' => $final_decision_count
            // 'cancel_count' => $cancel_count,

           
            // 'data' => [
            //     'id' => $user->id,
                
            // ]
        ], 200);
        // //contractor
        // $contractor_total=UserDetail::where('as_a','=','Contractor')->where('ref_id','=',$user->code)->count();
        // $today_contractor_count = UserDetail::where('as_a', 'Contractor')
        //                 ->where('ref_id', $user->code)
        //                 ->whereDate('created_at', Carbon::today()) // only today’s date
        //                 ->count();

    }

  
    
}




   


