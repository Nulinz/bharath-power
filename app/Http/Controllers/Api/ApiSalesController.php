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
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Log;



class ApiSalesController extends Controller
{
    //
      //
      public function sales_lead_enquiry_list(Request $request)
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
          ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
          ->where('lead_cycle', $request->lead_cycle)
          ->orderBy('created_at', 'desc') 
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
         ->where('user_status', 'Active') 
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
  
        //   $task = DB::table('task as t')
        //   ->leftJoin('users as u', 't.created_by', '=', 'u.id')
        //   ->where('t.enq_id', $request->enquiry_id)
        //   ->select('t.*', 'u.name as created_by_name')
        //   ->orderBy('created_at', 'DESC')
        //   ->get();
           
        //    asset('assets/quote_files/' . $file) 

        $task = DB::table('task as t')
                ->leftJoin('users as u', 't.created_by', '=', 'u.id')
                ->leftJoin('users as as', 't.user_id', '=', 'as.id')

                ->where('t.enq_id', $request->enquiry_id)
                ->select(
                    't.*',
                    'u.name as created_by_name',
                    'as.name as assigned_by_name'
                )
                ->orderBy('t.created_at', 'DESC')
                ->get()
                ->map(function ($task) {

                    // Convert file name to full URL
                    if (!empty($task->quote)) {
                        $task->file_url = asset('assets/quote_files/' . $task->quote);
                    } else {
                        $task->file_url = null;
                    }

                    return $task;
                });


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
        $userId = Auth::id();
        // dd($userId);
        $user = User::where('id', $userId)
        ->where('user_status', 'Active') 
        ->first();
 
            if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied: Not an employee',
            ], 403);
        }
 
  
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
               //'purchase_group' => $req->Purchase_group,
               'callback' => $req->callback,
               'value' => $req->quote_value,
               'priority' => $req->priority,
               'status' => $status,
               'created_by' => Auth::id(),
               'created_at' => now(),
               'updated_at' => now(),
       ]);
  
      $update_enq = DB::table('enquiry')
               ->where('id', $req->enqid)
               ->update([
                       'assign_to' => $newAssignee,
                       'lead_cycle' => $req->lead_cycle,
                       'status' => $status,
                       'updated_at' => now()
               ]);


               if ($update_enq) {
                // Get all active customers with their device tokens
                $activeCustomers = DB::table('users')
                    ->where('user_status', 'Active')
                    ->where('device_token', '!=', '')  
                    ->where('id', '=', $newAssignee)  
                // ->whereNotNull('device_token') // make sure token exists
                    ->select('id', 'device_token','name')
                    ->first();

                    if($activeCustomers){
                            DB::table('notification')->insert([
                                'assign_user_id' => $newAssignee,
                                'created_user_id' => Auth::id(),
                                'enq_id'=>$req->enqid,
                                'type' => 'sales_task',
                                'title' => 'New Task',
                                'body'   => "Hello , you have a new enquiry assigned.",
                                //'body' =>   "You have a new notification for " . ( 'enquiry'),
                                'body'   => "Hello {$activeCustomers->name}, you have a new task assigned.",
                                'created_at' => now(),
                                'updated_at' => now()
                            ]);

                            $body = "You have a new enquiry assigned.\n"
                            . "⚠️ PRIORITY: {$req->priority}";

                            $title="Hello {$activeCustomers->name}-New Enquiry,";
                            // $body= "Hello , you have a new Task assigned.";
            
                            try {
                        
                                    app(FirebaseService::class)->sendNotification($activeCustomers->device_token,
                                    [
                                        'title' => $title,
                                        'body'  => $body,
                                        'id'    => (string) $activeCustomers->id,
                                        'type'  => 'chat', // example custom data
                                        'sound' => 'default'
                                    ]
                                   
                                );
                        
                                } catch (\Exception $e) {
                                    Log::error('Push notification failed for user ID ' . $activeCustomers->id . ': ' . $e->getMessage());
                                }
                    }
              
                 }
                //$body= "Hello {$activeCustomers->name},x you have a new Task assigned.";
               
  
              return response()->json([
                  'status' => 'success',
                  'message' => 'Task stored successfully'
                  
              ], 200);
             
      }


      public function task_index()
      {
          $authId = Auth::user()->id;
          // dd($authId);
  
          $user = Auth::user();
  
  
          $tasks_todo = DB::table('task_sale')
          ->leftJoin('category', 'task_sale.category', '=', 'category.id')
       
          ->leftJoin('users as assign_user', 'task_sale.assign_to', '=', 'assign_user.id')
          ->leftJoin('users as created_user', 'task_sale.created_by', '=', 'created_user.id')
        
          ->where('task_sale.assign_to', $authId)
          ->where('task_sale.task_status', 'To Do')
          ->select(
              'task_sale.*',
              'category.cat_name as category_name',
              'created_user.designation as assigned_role',
              'created_user.name as assigned_user',
              // 'assigned_by_user.name as assigned_by'
          )
          ->orderBy('task_sale.id', 'DESC')
          ->get();
  
      $tasks_todo_count = DB::table('task_sale')
          ->where('assign_to', $authId)
          ->where('task_status', 'To Do')
          ->count();
  
  
          $tasks_inprogress = DB::table('task_sale')
          ->leftJoin('category', 'task_sale.category', '=', 'category.id')
       
          ->leftJoin('users as assign_user', 'task_sale.assign_to', '=', 'assign_user.id')
          ->leftJoin('users as created_user', 'task_sale.created_by', '=', 'created_user.id')
        
          ->where('task_sale.assign_to', $authId)
          ->where('task_sale.task_status', 'In Progress')
          ->select(
              'task_sale.*',
              'category.cat_name as category_name',
              'created_user.designation as assigned_role',
              'created_user.name as assigned_user',
              // 'assigned_by_user.name as assigned_by'
          )
          ->orderBy('task_sale.id', 'DESC')
          ->get();
  
          $tasks_inprogress_count = DB::table('task_sale')
          ->where('assign_to', $authId)
          ->where('task_status', 'In Progress')
          ->count();
  
  
          $tasks_complete = DB::table('task_sale')
          ->leftJoin('category', 'task_sale.category', '=', 'category.id')
       
          ->leftJoin('users as assign_user', 'task_sale.assign_to', '=', 'assign_user.id')
          ->leftJoin('users as created_user', 'task_sale.created_by', '=', 'created_user.id')
        
          ->where('task_sale.assign_to', $authId)
          ->where('task_sale.task_status', 'Completed')
          ->select(
              'task_sale.*',
              'category.cat_name as category_name',
              'created_user.designation as assigned_role',
              'created_user.name as assigned_user',
              // 'assigned_by_user.name as assigned_by'
          )
          ->orderBy('task_sale.id', 'DESC')
          ->get();
  
          $tasks_complete_count = DB::table('task_sale')
          ->where('assign_to', $authId)
          ->where('task_status', 'Completed')
          ->count();
  // dd ($tasks_todo_count);
          return view('user.task.task_index',  ['tasks_todo' => $tasks_todo, 'tasks_todo_count' => $tasks_todo_count,'tasks_inprogress' => $tasks_inprogress, 'tasks_inprogress_count' => $tasks_inprogress_count,'tasks_complete' => $tasks_complete, 'tasks_complete_count' => $tasks_complete_count]);
  
      }

      public function sales_edit_enquiry(Request $req)
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
        $id=$req->enquiry_id;

        

        $enquiry_details = DB::table('enquiry as enq')
        ->leftJoin('users as ur', 'enq.assign_to', '=', 'ur.id')
        ->leftJoin('products as pro', 'enq.product_category', '=', 'pro.id')
        ->leftJoin('products_group as pg', 'pg.id', '=', 'enq.enq_pro_group')
        ->where('enq.id', $id)
        ->select(
                'enq.*',
                'ur.name as assigned_user_name',
                'pro.id as product_id',
                'enq.id as enq_id',
                'pro.name as product_name',
                'enq.product_category as product_id',
                'pg.group_name as group_name',
                'enq.enq_pro_group as group_id'
        )
        ->orderBy('created_at', 'DESC')
        ->first();

      return response()->json([
        'status' => 'success',
        'enquiry_details' => $enquiry_details,
        
    ], 200);
}

public function sales_update_enquiry(Request $req)
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

        DB::table('enquiry')->where('id', $req->enquiry_id)->update([
            'name' => $req->name,
            'contact' => $req->contact,
            'enq_pro_group' => $req->enq_pro_group,
            'product_category' => $req->enq_product,
            'requirements' => $req->requirements,
            'quantity' => $req->quantity,
            'enq_uom' => $req->enq_uom,
            'enq_capacity' => $req->enq_capacity,
            'enq_address' => $req->enq_address,
            'location' => $req->location,
            'source' => $req->source,
            'enq_ref_name' => $req->enq_ref_name,
            'enq_ref_contact' => $req->enq_ref_contact,
            'updated_at' => now(),
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'enquiry updated successfully',
            
        ], 200);
}

//sales today remainder
public function sales_today_remainder(Request $req)
{
    $userId = Auth::id();
    $user = User::where('id', $userId)
    ->where('user_status','Active')
    ->first();


    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'Access denied: Not an employee',
        ], 403);
    }

    $today = date('Y-m-d');

    $query = DB::table('task')
        ->join('enquiry', 'task.enq_id', '=', 'enquiry.id')
        ->leftJoin('users', 'task.user_id', '=', 'users.id')
        ->whereDate('task.callback', $today)
        ->whereNotIn('task.status', ['completed', 'cancelled'])
        ->select(
            'task.*',
            'enquiry.enq_no',
            'enquiry.name as enquiry_name',
            'users.name as assign_to'
        );

   
    if ($user->designation !== 'Admin') {
        $query->where('enquiry.assign_to', $userId);
    }

    $todayTasks = $query->get();

    return response()->json([
        'status' => 'success',
        'today_task_remainder' => $todayTasks,
    ], 200);
}

//enquiry store
public function sales_enquiry_store(Request $req)
{
        $userId = Auth::id();
        $user = User::find($userId);

        if (!$user || $user->user_status !== 'Active') {
            return response()->json([
                'status' => 'error',
                'message' => 'User inactive or not found'
            ], 403);
        }
        $enq_no =    'ENQ' . rand(1000, 9999);

        $status = $req->lead_cycle === 'Final Decision' ? 'completed' : 'pending';

        $insert_id =   DB::table('enquiry')->insertGetId([
                'enq_no' => $enq_no,
                'name' => $req->enq_name,
                'enq_pro_group' => $req->enq_pro_group,
                'product_category' => $req->enq_product,
                'quantity' => $req->enq_qty,
                'enq_capacity' => $req->enq_capacity,
                'enq_uom' => $req->enq_uom,
                'lead_cycle' => $req->enq_lead_cycle,
                'upload_quote' => $req->enq_quote,
                'requirements' => $req->enq_requirements,
                'contact' => $req->enq_contact,
                'location' => $req->enq_location,
                'enq_address' => $req->enq_address,
                'source' => $req->enq_source,
                'enq_ref_name' => $req->enq_ref_name,
                'enq_ref_contact' => $req->enq_ref_contact,
                'status' => $status,
                'created_by' => Auth::id(),
                'assign_to' => $req->enq_assign_to,
                'created_at' => now(),
                'updated_at' => now(),
        ]);

        if ($req->hasFile('enq_quote')) {
                $image = $req->file('enq_quote');
                $filename = time() . '_' . $image->getClientOriginalName();

                $image->move(public_path('assets/quote_files'), $filename);
        } else {
                $filename = null;
        }

       $task_update = DB::table('task')->insert([
                'enq_id' => $insert_id,
                'enq_no' => $enq_no,
                'product_id' => $req->enq_product,
                'purchase_group' => $req->Purchase_group,
                'user_id'  => $req->enq_assign_to,
                'remarks' =>  $req->enq_requirements ?? 'Enquiry Created',
                'lead_cycle' => $req->enq_lead_cycle,
                'quote' => $filename,
                'value' =>  $req->quote_value,
                'status' => $status,
                'priority' => $req->priority,
                'created_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
        ]);

        if ($task_update) {
                $activeCustomers = DB::table('users')
                ->where('user_status', 'Active')
                ->where('device_token', '!=', '')  
                ->where('id', '=', $req->enq_assign_to)  
                ->select('id', 'device_token','name')
                ->first();
                    if($activeCustomers){
                        DB::table('notification')->insert([
                            'assign_user_id' => $req->enq_assign_to,
                            'created_user_id' => Auth::id(),
                            'enq_id'=> $insert_id,
                            'type' => 'sales_enquiry',
                            'title' => 'New Enquiry',
                            'body'   => "Hello {$activeCustomers->name}, you have a new enquiry assigned.",
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                        $title="Hello {$activeCustomers->name}-New Enquiry,";
                        $body = "You have a new enquiry assigned.\n"
                                        . "⚠️ PRIORITY: {$req->priority}";
            
                        try {
                                
                                app(FirebaseService::class)->sendNotification($activeCustomers->device_token,
                                [
                                    'title' => $title,
                                    'body'  => $body,
                                    'id'    => (string) $activeCustomers->id,
                                    'type'  => 'chat', // example custom data
                                    'sound' => 'default'
                                ]
                            
                            );
                    
                            } catch (\Exception $e) {
                                Log::error('Push notification failed for user ID ' . $activeCustomers->id . ': ' . $e->getMessage());
                            }
                        }
    }
          

        return response()->json([
            'status' => 'success',
            'message' => 'enquiry added successfully',
        
        ], 200);
}


//report filter

public function sales_report_filter(Request $request)
{

    $userId =  Auth::id(); // Get current user ID
    $user = User::where('id', $userId)
    ->where('user_status', 'Active')
    ->first();

    if (!$user) {
     return response()->json([
         'status' => 'error',
         'message' => 'Access denied: user not active',
     ], 403);
 }
    $query = DB::table('enquiry as eq')
        ->join('products as pt', 'eq.product_category', '=', 'pt.id')
        ->join('users as us', 'eq.assign_to', '=', 'us.id')
        ->leftJoin('products_group as pg', 'eq.enq_pro_group', '=', 'pg.id')
        ->select('eq.*', 'pt.name as product_name', 'us.name as usr_name', 'pg.group_name as group_name')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        });
    // ->orderBy('eq.created_at', 'DESC')->get();
    // Optional filters (only applied if present)

    // Date range
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween(DB::raw('DATE(eq.created_at)'), [
            $request->start_date,
            $request->end_date
        ]);
    }

    // Product group
    if ($request->filled('product_group')) {
        $query->where('eq.enq_pro_group', $request->product_group);
    }

    // Product
    if ($request->filled('product_id')) {
        $query->where('eq.product_category', $request->product_id);
    }

    // Enquiry number
    if ($request->filled('enq_no')) {
        $query->where('eq.enq_no', 'like', '%' . $request->enq_no . '%');
    }

    // Assigned user
    if ($request->filled('assign_to')) {
        $query->where('eq.assign_to', $request->assign_to);
    }

    // Get final data
    $enquiry = $query->orderBy('eq.created_at', 'DESC')->get();

    // Dropdowns for filters
    $products = DB::table('products')->pluck('name', 'id');
    $users = DB::table('users')->pluck('name', 'id');
    $groups = DB::table('products_group')->pluck('group_name', 'id');

    return response()->json([
        'status' => 'success',
        'enquiry_list' => $enquiry,
        
    ], 200);

   // return view('admin.reports.index', compact('enquiry', 'products', 'users', 'groups'));
}



/*
public function sales_report_filter(Request $request)
{

    $userId =  Auth::id(); // Get current user ID
    $user = User::where('id', $userId)
    ->where('user_status', 'Active')
    ->first();

    if (!$user) {
     return response()->json([
         'status' => 'error',
         'message' => 'Access denied: Not an employee',
     ], 403);
 }

    $query = DB::table('enquiry as eq')
        ->join('products as pt', 'eq.product_category', '=', 'pt.id')
        ->join('users as us', 'eq.assign_to', '=', 'us.id')
        ->leftJoin('products_group as pg', 'eq.enq_pro_group', '=', 'pg.id')
        ->select('eq.*', 'pt.name as product_name', 'us.name as usr_name', 'pg.group_name as group_name')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        // ->where('eq.assign_to', $userId) // Only assigned enquiries
        ->where(function ($q) {
            $q->where('eq.status', 'pending') // Include all pending
                ->orWhere(function ($sub) {
                    $sub->whereIn('eq.status', ['cancelled', 'completed']) // Only completed/cancelled from current month
                        ->whereMonth('eq.created_at', date('m'))
                        ->whereYear('eq.created_at', date('Y'));
                });
        })
        ->orderBy('eq.created_at', 'DESC');


    // Date filter
    if ($request->start_date && $request->end_date) {
        $query->whereBetween(DB::raw('DATE(eq.created_at)'), [
            $request->start_date,
            $request->end_date
        ]);
    }

    // Product Group filter
    if ($request->product_group) {
        $query->where('eq.enq_pro_group', $request->product_group);
    }

    // Product filter
    if ($request->product_id) {
        $query->where('eq.product_category', $request->product_id);
    }

    // Enquiry number filter
    if ($request->enq_no) {
        $query->where('eq.enq_no', 'like', '%' . $request->enq_no . '%');
    }

    $enquiry = $query->orderBy('eq.created_at', 'DESC')->get();

    // Dropdown data
    $products = DB::table('products')->pluck('name', 'id');
    $groups = DB::table('products_group')->pluck('group_name', 'id');

    return response()->json([
        'status' => 'success',
        'enquiry_list' => $enquiry,
        
    ], 200);

    //return view('user.reports.index', compact('enquiry', 'products', 'groups'));
}
*/

 public function sale_enquiry_list()
 {

        $userId = Auth::id();
        // dd($userId);
        $user = User::where('id', $userId)
       ->where('user_status', 'Active')
        ->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied: Not an employee',
            ], 403);
        }

        $enquiry = DB::table('enquiry as eq')
                ->join('products as pt', 'eq.product_category', '=', 'pt.id')
                ->join('users as us', 'eq.assign_to', '=', 'us.id')
                ->leftJoin('products_group as pg', 'eq.enq_pro_group', '=', 'pg.id')
                ->select('eq.*', 'pt.name as product_name', 'us.name as usr_name', 'pg.group_name as group_name')
               // ->where('eq.assign_to', Auth::id()) // Filter by logged-in user
               ->when($user->designation !== 'Admin', function ($query) use ($user) {
                $query->where('eq.assign_to', $user->id);
            })
                ->where(function ($q) {
                        $q->where('eq.status', 'pending') // All pending
                                ->orWhere(function ($sub) {
                                        $sub->whereIn('eq.status', ['cancelled', 'completed']) // Only completed/cancelled for current month
                                                ->whereMonth('eq.created_at', date('m'))
                                                ->whereYear('eq.created_at', date('Y'));
                                });
                })
                ->orderBy('eq.created_at', 'DESC')
                ->get();

        //   ->join('products as pt', 'eq.product_category', '=', 'pt.id')
        //   ->select('eq.*', 'pt.name as product_name')

        // return view('user.enquiry.enquiry_list', ['enquiry' => $enquiry]);

        return response()->json([
            'status' => 'success',
            'enquiry_list' => $enquiry,
            
        ], 200);
   }


   public function sales_task_index()
   {
       $authId = Auth::user()->id;
       // dd($authId);

       $user = Auth::user();


       $tasks_todo = DB::table('task_sale')
       ->leftJoin('category', 'task_sale.category', '=', 'category.id')
    
       ->leftJoin('users as assign_user', 'task_sale.assign_to', '=', 'assign_user.id')
       ->leftJoin('users as created_user', 'task_sale.created_by', '=', 'created_user.id')
     
       ->where('task_sale.assign_to', $authId)
       ->where('task_sale.task_status', 'To Do')
       ->select(
           'task_sale.*',
           'category.cat_name as category_name',
           'created_user.designation as assigned_role',
           'created_user.name as assigned_user',
           // 'assigned_by_user.name as assigned_by'
       )
       ->orderBy('task_sale.id', 'DESC')
       ->get();

   $tasks_todo_count = DB::table('task_sale')
       ->where('assign_to', $authId)
       ->where('task_status', 'To Do')
       ->count();


       $tasks_inprogress = DB::table('task_sale')
       ->leftJoin('category', 'task_sale.category', '=', 'category.id')
    
       ->leftJoin('users as assign_user', 'task_sale.assign_to', '=', 'assign_user.id')
       ->leftJoin('users as created_user', 'task_sale.created_by', '=', 'created_user.id')
     
       ->where('task_sale.assign_to', $authId)
       ->where('task_sale.task_status', 'In Progress')
       ->select(
           'task_sale.*',
           'category.cat_name as category_name',
           'created_user.designation as assigned_role',
           'created_user.name as assigned_user',
           // 'assigned_by_user.name as assigned_by'
       )
       ->orderBy('task_sale.id', 'DESC')
       ->get();

       $tasks_inprogress_count = DB::table('task_sale')
       ->where('assign_to', $authId)
       ->where('task_status', 'In Progress')
       ->count();


       $tasks_complete = DB::table('task_sale')
       ->leftJoin('category', 'task_sale.category', '=', 'category.id')
    
       ->leftJoin('users as assign_user', 'task_sale.assign_to', '=', 'assign_user.id')
       ->leftJoin('users as created_user', 'task_sale.created_by', '=', 'created_user.id')
     
       ->where('task_sale.assign_to', $authId)
       ->where('task_sale.task_status', 'Completed')
       ->select(
           'task_sale.*',
           'category.cat_name as category_name',
           'created_user.designation as assigned_role',
           'created_user.name as assigned_user',
           // 'assigned_by_user.name as assigned_by'
       )
       ->orderBy('task_sale.id', 'DESC')
       ->get();

       $tasks_complete_count = DB::table('task_sale')
       ->where('assign_to', $authId)
       ->where('task_status', 'Completed')
       ->count();
// dd ($tasks_todo_count);


        return response()->json([
            'status' => 'success',
            'tasks_todo' => $tasks_todo,
            'tasks_todo_count' => $tasks_todo_count,
            'tasks_inprogress' => $tasks_inprogress, 
            'tasks_inprogress_count' => $tasks_inprogress_count,
            'tasks_complete' => $tasks_complete, 
            'tasks_complete_count' => $tasks_complete_count
           
            
        ], 200);
    //    return view('user.task.task_index',  ['tasks_todo' => $tasks_todo, 'tasks_todo_count' => $tasks_todo_count,'tasks_inprogress' => $tasks_inprogress, 'tasks_inprogress_count' => $tasks_inprogress_count,'tasks_complete' => $tasks_complete, 'tasks_complete_count' => $tasks_complete_count]);

   }

   public function sale_task_status_update(Request $request)
    {
        //Log::info($request->all());
        //dd($request->all());
        $taskId = $request->id;
        $newStatus = $request->status;

        $authId = Auth::user()->id;

        $task =  DB::table('task_sale')
        ->where('id',$taskId)
        ->first();

        
            if ($task) {
               
            DB::table('task_sale')
            ->where('id', $taskId)
            ->update([
                'task_status' => $newStatus
            ]);
            }
    

        $tasks_todo_count = DB::table('task_sale')
            ->where('assign_to', $authId)
            ->where('task_status', 'To Do')
            ->count();

        $tasks_inprogress_count = DB::table('task_sale')
            ->where('assign_to', $authId)
            ->where('task_status', 'In Progress')
            ->count();


        $tasks_complete_count = DB::table('task_sale')
            ->where('assign_to', $authId)
            ->where('task_status', 'Completed')
            ->count();

        return response()->json([
            'success' => true,
            'message' => 'Task status updated',
            'taskCounts' => [
                'todo' => $tasks_todo_count,
                'inprogress' => $tasks_inprogress_count,
                //'onhold' => $tasks_onhold_count,
                 'complete' => $tasks_complete_count,
            ],
        ], 200);

        return response()->json(['success' => false, 'message' => 'Task not found']);
    }

    public function sales_task_ext(Request $req)
    {

        $user = Auth::user();
       // $task = Task::findOrFail($req->task_id);
       $task =  DB::table('task_sale')
       ->where('id',$req->task_id)
       ->first();

       //  $task1 = Task::findOrFail($task->f_id);

        if ($req->category == 'close') {

           $filename = null;
           if ($req->hasFile('close_attach')) {
             $image = $req->file('close_attach');
             $filename = time() . '_' . $image->getClientOriginalName();
             $image->move(public_path('image/task_sale_file'), $filename);
         }
       

            // Handle file upload
           //  if ($req->hasFile('close_attach')) {
           //      $image = $req->file('close_attach');

           //      if ($image->isValid()) {
           //          $filename = time().'_'.$image->getClientOriginalName();
           //          $image->move('assets/image/task_sale_file', $filename);
           //      } else {
           //          return back()->with('error', 'Uploaded file is invalid.');
           //      }
           //  } else {
           //      return back()->with('error', 'Please upload a file to close the task.');
           //  }

            // Insert close request
            DB::table('task_ext')->insert([
                'task_id' => $req->task_id,
                'request_for' => $req->assined_by ?? null,
                 'attach' => $filename,
                'status' => 'Close Request',
                'c_remarks' => $req->remarks,
                'category' => $req->category,
                'c_by' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            // Insert extend request
            DB::table('task_ext')->insert([
                'task_id' => $req->task_id,
                'request_for' => $req->assined_by ?? null,
                'extend_date' => $req->extend_date,
                'status' => 'Pending',
                'c_remarks' => $req->remarks,
                'category' => $req->category,
                'c_by' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // return redirect()->back()->with('success', 'Task end date updated successfully.');
        return response()->json([
            'status' => 'success',
             'message'=>'Task end date updated successfully.'
           
            
        ], 200);
    }





  
  
}
