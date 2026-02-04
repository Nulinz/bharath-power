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
    //    ->where('designation', 'Employee')
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

    public function sales_task_store(Request $req)
    {
      //  dd($req->all());

             // Stop if task already completed
             $alreadyCompleted = DB::table('task')
             ->where('enq_id', $req->enqid)
             ->whereIn('status', ['completed', 'cancelled'])
             ->exists();

     if ($alreadyCompleted) {
            //  return back()->withErrors(['message_error' => 'Task already completed.']);
            return response()->json([
                'status' => 'success',
                'message' => 'Task already completed'
                
            ], 400);
     }

     $filenames = [];
     if ($req->hasFile('quote')) {
             foreach ($req->file('quote') as $file) {
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


            return response()->json([
                'status' => 'success',
                'message' => 'Task stored successfully'
                
            ], 200);
           
    }


   }
