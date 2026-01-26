<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Enquiry;
use App\Models\Category;
use App\Models\Products;




class ApiUserController extends Controller
{
    //
    public function sales_enquiry_list(Request $request)
    {
        $userId = Auth::id();
       // dd($userId);
       $user = User::where('id', $userId)
       ->where('designation', 'Employee')
       ->first();

       if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'Access denied: Not an employee',
        ], 403);
    }


        $enquiry_list = Enquiry::with([
            'products_group:id,group_name',
            'products:id,name'
        ])
        ->where('assign_to', $user->id)
        ->where('lead_cycle', $request->lead_cycle)
        ->get();
        

        return response()->json([
            'status' => 'success',
            'enquiry_list' => $enquiry_list,
            
        ], 200);
       
    }

    public function sales_enquiry_profile(Request $request)
    {
        $userId = Auth::id();
       // dd($userId);
       $user = User::where('id', $userId)
       ->first();

       if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'Access denied: Not an employee',
        ], 403);
    }


        $enquiry_details = Enquiry::with([
            'products_group:id,group_name',
            'products:id,name'
        ])
        ->where('id', $request->enquiry_id)
        ->get();

        $task = DB::table('task as t')
        ->leftJoin('users as u', 't.created_by', '=', 'u.id')
        ->where('t.enq_id', $request->enquiry_id)
        ->select('t.*', 'u.name as created_by_name')
        ->orderBy('created_at', 'DESC')
        ->get();


         
        if (!$enquiry_details) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied: Not an employee',
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'enquiry_details' => $enquiry_details,
            'task'=>$task
            
        ], 200);
       
    }

    public function sales_enquiry_store(Request $req)
    {
        //dd($req->all());

            // Stop if task already completed
            $alreadyCompleted = DB::table('task')
                    ->where('enq_id', $req->enqid)
                    ->whereIn('status', ['completed', 'cancelled'])
                    ->exists();
                    
            if ($alreadyCompleted) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Task already completed',
                ], 403);
            }

            $filenames = [];
            if ($req->hasFile('file')) {
                    foreach ($req->file('file') as $file) {
                            $filename = time() . '_' . $file->getClientOriginalName();
                            $file->move(public_path('assets/quote_files'), $filename);
                            $filenames[] = $filename;
                    }
            } else {
                    $filename = null; // no file uploaded
            }

            if ($req->hasFile('cancel_upload')) {
                    $can_file = $req->file('cancel_upload');
                    $can_filename = time() . '_' . $can_file->getClientOriginalName();
                    $can_file->move(public_path('assets/quote_files'), $can_filename);
            } else {
                    $can_filename = null;
            }

            // Set task status
            if ($req->lead_cycle === 'Final Decision') {
                    $status = 'completed';
            } elseif ($req->lead_cycle === 'Cancelled') {
                    $status = 'cancelled';
            } else {
                    $status = 'pending';
            }

            $newAssignee = $req->filled('assign_to') ? $req->assign_to : $req->user_id;

            DB::table('task')->insert([
                    'enq_id' => $req->enqid,
                    'enq_no' => $req->enqno,
                    'product_id' => $req->pro_id,
                    'user_id' =>  $newAssignee,
                    'remarks' => $req->remarks,
                    'lead_cycle' => $req->lead_cycle,
                    'quote' => implode(',', $filenames),
                    'cancel_reason' => $req->cancel,
                    'cancel_upload' => $can_filename,
                    'purchase_group' => $req->Purchase_group,
                    'callback' => $req->callback,
                    'value' => $req->quote_value,
                    'status' => $status,
                    'created_by' => Auth::id(),
                    'created_at' => now(),
                    'updated_at' => now(),
            ]);

            DB::table('enquiry')
                    ->where('id', $req->enqid)
                    ->update([
                            'assign_to' => $newAssignee,
                            'lead_cycle' => $req->lead_cycle,
                            'status' => $status,
                            'updated_at' => now()
                    ]);

            // return redirect()->route('user.enquiry.enquiry_view', ['id' => $req->enqid])->with([
            //         'status' => 'Success',
            //         'message' => 'Task updated successfully'
            // ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Task updated successfully'
                
            ], 200);
           
    }


    // public function initial_contact_list(Request $request)
    // {
    //     $userId = Auth::id();
    //    // dd($userId);
    //    $user = User::where('id', $userId)
    //    ->where('designation', 'Employee')
    //    ->first();

    //    if (!$user) {
    //     return response()->json([
    //         'status' => 'error',
    //         'message' => 'Access denied: Not an employee',
    //     ], 403);
    // }

    //     $intial_contact_list = Enquiry::with([
    //         'products_group:id,group_name',
    //         // 'category:id,cat_name'
    //          'products:id,name'
    //     ])
    //     ->where('assign_to', $user->id)
    //     ->where('lead_cycle', 'Initial Contact')
    //     ->get();

        

    //     return response()->json([
    //         'status' => 'success',
    //         'intial_contact_list' => $intial_contact_list,
    //     ], 200);
       
    // }

    // public function requirement_gathering_list(Request $request)
    // {
    //     $userId = Auth::id();
    //    // dd($userId);
    //    $user = User::where('id', $userId)
    //    ->where('designation', 'Employee')
    //    ->first();

    //    if (!$user) {
    //     return response()->json([
    //         'status' => 'error',
    //         'message' => 'Access denied: Not an employee',
    //     ], 403);
    // }


    //     $requirement_gathering_list = Enquiry::with([
    //         'products_group:id,group_name',
    //         // 'category:id,cat_name'
    //          'products:id,name'
    //     ])
    //     ->where('assign_to', $user->id)
    //     ->where('lead_cycle', 'Requirement Gathering')
    //     ->get();

    //     return response()->json([
    //         'status' => 'success',
    //         'requirement_gathering_list' => $requirement_gathering_list,
            
    //     ], 200);
       
    // }
    // public function product_list(Request $request)
    // {
    //     $userId = Auth::id();
    //    // dd($userId);
    //    $user = User::where('id', $userId)
    //    ->where('designation', 'Employee')
    //    ->first();

    //    if (!$user) {
    //     return response()->json([
    //         'status' => 'error',
    //         'message' => 'Access denied: Not an employee',
    //     ], 403);
    // }

    // $product_list = Enquiry::with([
    //         'products_group:id,group_name',
    //         // 'category:id,cat_name'
    //          'products:id,name'
    //     ])
    //     ->where('assign_to', $user->id)
    //     ->where('lead_cycle', 'Product Selection')
    //     ->get();

    //     return response()->json([
    //         'status' => 'success',
           
           
    //             'id' => $user->id,
    //             'product_list' => $product_list,
            
    //     ], 200);
       
    // }
    // public function quotation_preparation_list(Request $request)
    // {
    //    $userId = Auth::id();
    //    $user = User::where('id', $userId)
    //    ->where('designation', 'Employee')
    //    ->first();

    //    if (!$user) {
    //     return response()->json([
    //         'status' => 'error',
    //         'message' => 'Access denied: Not an employee',
    //     ], 403);
    // }

    //     $quotation_preparation_list = Enquiry::with([
    //         'products_group:id,group_name',
    //         // 'category:id,cat_name'
    //          'products:id,name'
    //     ])
    //     ->where('assign_to', $user->id)
    //     ->where('lead_cycle', 'Quotation Preparation')
    //     ->get();


    //     return response()->json([
    //         'status' => 'success',
                
    //             'id' => $user->id,
    //             'quotation_preparation_list' => $quotation_preparation_list,
            
    //     ], 200);
       
    // }

    // //quotation submission list
    // public function quotation_submission_list(Request $request)
    // {
    //    $userId = Auth::id();
    //    $user = User::where('id', $userId)
    //    ->where('designation', 'Employee')
    //    ->first();

    //    if (!$user) {
    //     return response()->json([
    //         'status' => 'error',
    //         'message' => 'Access denied: Not an employee',
    //     ], 403);
    // }

    //     $quotation_submission_list = Enquiry::with([
    //         'products_group:id,group_name',
    //         // 'category:id,cat_name'
    //          'products:id,name'
    //     ])
    //     ->where('assign_to', $user->id)
    //     ->where('lead_cycle', 'Quotation')
    //     ->get();


    //     return response()->json([
    //         'status' => 'success',
                
    //             'id' => $user->id,
    //             'quotation_submission_list' => $quotation_submission_list,
            
    //     ], 200);
       
    // }

    // //follow up list

    //  //quotation submission list
    //  public function followup_list(Request $request)
    //  {
    //     $userId = Auth::id();
    //     $user = User::where('id', $userId)
    //     ->where('designation', 'Employee')
    //     ->first();
 
    //     if (!$user) {
    //      return response()->json([
    //          'status' => 'error',
    //          'message' => 'Access denied: Not an employee',
    //      ], 403);
    //  }
 
    //      $followup_list = Enquiry::with([
    //          'products_group:id,group_name',
    //         //  'category:id,cat_name'
    //          'products:id,name'
    //      ])
    //      ->where('assign_to', $user->id)
    //      ->where('lead_cycle', 'Follow-up')
    //      ->get();
 
 
    //      return response()->json([
    //          'status' => 'success',
                 
    //              'id' => $user->id,
    //              'followup_list' => $followup_list,
             
    //      ], 200);
        
    //  }

    //  //order confirmed list
    //  public function order_confirmed_list(Request $request)
    //  {
    //     $userId = Auth::id();
    //     $user = User::where('id', $userId)
    //     ->where('designation', 'Employee')
    //     ->first();
 
    //     if (!$user) {
    //      return response()->json([
    //          'status' => 'error',
    //          'message' => 'Access denied: Not an employee',
    //      ], 403);
    //  }
 
    //      $order_confirmed_list = Enquiry::with([
    //          'products_group:id,group_name',
    //         //  'category:id,cat_name'
    //          'products:id,name'
    //      ])
    //      ->where('assign_to', $user->id)
    //      ->where('lead_cycle', 'Order confimred')
    //      ->get();
 
 
    //      return response()->json([
    //          'status' => 'success',
                 
    //              'id' => $user->id,
    //              'order_confirmed_list' => $order_confirmed_list,
             
    //      ], 200);
        
    //  }

    //  //supplied partial list
    //  public function supplied_partial_list(Request $request)
    //  {
    //     $userId = Auth::id();
    //     $user = User::where('id', $userId)
    //     ->where('designation', 'Employee')
    //     ->first();
 
    //     if (!$user) {
    //      return response()->json([
    //          'status' => 'error',
    //          'message' => 'Access denied: Not an employee',
    //      ], 403);
    //  }
 
    //      $supplied_partial_list = Enquiry::with([
    //          'products_group:id,group_name',
    //         //  'category:id,cat_name'
    //          'products:id,name'
    //      ])
    //      ->where('assign_to', $user->id)
    //      ->where('lead_cycle', 'Material supplied partially')
    //      ->get();
 
 
    //      return response()->json([
    //          'status' => 'success',
                 
    //              'id' => $user->id,
    //              'supplied_partial_list' => $supplied_partial_list,
             
    //      ], 200);
        
    //  }

    //  public function supplied_final_list(Request $request)
    //  {
    //     $userId = Auth::id();
    //     $user = User::where('id', $userId)
    //     ->where('designation', 'Employee')
    //     ->first();
 
    //     if (!$user) {
    //      return response()->json([
    //          'status' => 'error',
    //          'message' => 'Access denied: Not an employee',
    //      ], 403);
    //  }
 
    //      $supplied_final_list = Enquiry::with([
    //          'products_group:id,group_name',
    //         //  'category:id,cat_name'
    //          'products:id,name'
    //      ])
    //      ->where('assign_to', $user->id)
    //      ->where('lead_cycle', 'Material supplied final-full')
    //      ->get();
 
 
    //      return response()->json([
    //          'status' => 'success',
                 
    //              'id' => $user->id,
    //              'supplied_final_list' => $supplied_final_list,
             
    //      ], 200);
        
    //  }
}
