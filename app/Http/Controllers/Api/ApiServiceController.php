<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Enquiry;
use App\Models\ServiceEnquiry;
use App\Models\Category;
use App\Models\Products;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Log;


class ApiServiceController extends Controller
{
    //
     //
     public function service_lead_enquiry_list(Request $request)
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
 
 
         $service_enquiry_list = ServiceEnquiry::with([
             'products_group:id,group_name',
             'products:id,name'
         ])
        //  ->where('assign_to', $user->id)
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
         ->where('lead_cycle', $request->lead_cycle)
         ->orderBy('id', 'DESC')
         ->get();
         
 
         return response()->json([
             'status' => 'success',
             'service_enquiry_list' => $service_enquiry_list,
             
         ], 200);
        
     }
 
     public function service_enquiry_profile(Request $request)
     {
         $userId = Auth::id();
        // dd($userId);
        $user = User::where('id', $userId)
        ->where('user_status', 'Active')
        ->first();
 
        if (!$user) {
         return response()->json([
             'status' => 'error',
             'message' => 'Access denied: User Not Active',
         ], 403);
     }
 
 
            $view_eq = DB::table('service_enquiry as enq')
            ->leftJoin('users as ur', 'enq.assign_to', '=', 'ur.id')
            ->leftJoin('products as pro', 'enq.product_category', '=', 'pro.id')
            ->leftJoin('products_group as pg', 'pg.id', '=', 'enq.enq_pro_group')
            ->where('enq.id', $request->enquiry_id)
            ->select(
                'enq.*',
                'ur.name as assigned_user_name',
                'pro.id as product_id',
                'enq.id as enq_id',
                'pro.name as product_name',
                'pg.group_name as group_name'
            )
            ->orderBy('created_at', 'DESC')
            ->first();

        $task = DB::table('service_task as t')
            // ->leftJoin('users as u', 't.created_by', '=', 'u.id', 't.attended_by', '=', 'u.id')
            ->leftJoin('users as u', 't.created_by', '=', 'u.id')
            ->leftJoin('users as ua', 't.user_id', '=', 'ua.id')
            ->where('t.enq_id', $request->enquiry_id)
            ->select('t.*', 'u.name as created_by_name','ua.name as assigned_by_name')
            ->orderBy('created_at', 'DESC')
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

        $user_id = Auth::id();

        // $add_group = DB::table('products_group')->where('status', 'Active')->get();

        // $users = DB::table('users')->where('user_status', 'Active')->get();

 
        return response()->json([
            'status' => 'success',
            'service_enquiry_details' => $view_eq,
            'task'=>$task
            
        ], 200);
        
     }
 
     public function service_task_store(Request $req)
     {

        $userId = Auth::id();
        // dd($userId);
        $user = User::where('id', $userId)
         ->where('user_status', 'Active')
        ->first();
 
        if (!$user) {
         return response()->json([
             'status' => 'error',
             'message' => 'Access denied: User Not Active',
         ], 403);
     }
 
        // Stop if task already completed
        $alreadyCompleted = DB::table('service_task')
            ->where('enq_id', $req->enqid)
            ->whereIn('status', ['completed', 'cancelled'])
            ->exists();

        if ($alreadyCompleted) {
            return response()->json([
                'status' => 'success',
                'message' => 'Task already completed'
                
            ], 200);
            // return back()->withErrors(['message_error' => 'Task already completed.']);
        }

        $filenames = [];
        if ($req->hasFile('quote')) {
            foreach ($req->file('quote') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/quote_files'), $filename);
                $filenames[] = $filename;
            }
        } else {
            $filename = null; 
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

        DB::table('service_task')->insert([
            'enq_id' => $req->enqid,
            'enq_no' => $req->enqno,
            'product_id' => $req->pro_id,
            'user_id' =>  $newAssignee,
            'remarks' => $req->remarks,
            'lead_cycle' => $req->lead_cycle,
            'quote' => implode(',', $filenames),
            'cancel_reason' => $req->cancel,
            'cancel_upload' => $can_filename,
            'service_value' => $req->ser_value,   //
            'attended_by' => $req->attn_name,   //
            'service_date' => $req->serv_date,
            'callback' => $req->callback,
            'value' => $req->quote_value,
            'priority' => $req->priority,
            'status' => $status,
            'created_by' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

       $update_servcie_enq = DB::table('service_enquiry')
        ->where('id', $req->enqid)
        ->update([
                'assign_to' => $newAssignee,
                'lead_cycle' => $req->lead_cycle,
                'status' => $status,
                'updated_at' => now()
        ]);

        if ($update_servcie_enq) {
            // Get all active customers with their device tokens
            $activeCustomers = DB::table('users')
                ->where('user_status', 'Active')
                ->where('device_token', '!=', '')  
                ->where('id', '=', $newAssignee)  
            // ->whereNotNull('device_token') // make sure token exists
                ->select('id', 'device_token','name')
                ->first();
              if($activeCustomers){
                $body = "Your task is currently in {$req->lead_cycle} stage.\n"
                . "⚠️ Priority: {$req->priority}";
                  $title="New Task-{$req->enqno}";
                  $body1 = "Your task is currently in {$req->lead_cycle} stage.\n"
                  . "Priority: {$req->priority}";


                        DB::table('notification')->insert([
                            'assign_user_id' => $newAssignee,
                            'created_user_id' => Auth::id(),
                            'enq_id'=> $req->enqid,
                            'type' => 'service_task',
                            'title' => $title,
                            'body'   => $body1,
                            //'body' =>   "You have a new notification for " . ( 'enquiry'),
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);

                               
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
            'message' => 'Service Task stored successfully'
            
        ], 200);
            
     }

     //service enquiry fetch details
    public function service_edit_enquiry(Request $req)
    {
            $userId = Auth::id();
            // dd($userId);
            $user = User::where('id', $userId)
            ->where('user_status','Active')
            ->first();
    
            if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied: Not an employee',
            ], 403);
        }
            $id=$req->enquiry_id;

            $enquiry_details = DB::table('service_enquiry as enq')
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

    //service enquiry update
    public function service_update_enquiry(Request $req)
   {
        $userId = Auth::id();
        $id = $req->enquiry_id;
        // dd($userId);
        $user = User::where('id', $userId)
        ->where('user_status','Active')
        ->first();

        if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'Access denied: not active',
        ], 403);
        }

        DB::table('service_enquiry')->where('id', $req->enquiry_id)->update([
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


   public function service_today_remainder(Request $req)
   {

    $userId = Auth::id();
    
    $user = User::find($userId);
    //dd($user->designation);

    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'Access denied: Not an employee',
        ], 403);
    }

        $today = date('Y-m-d');    
        $query = DB::table('service_task')
        ->join('service_enquiry', 'service_task.enq_id', '=', 'service_enquiry.id')
        ->leftJoin('users', 'service_task.user_id', '=', 'users.id')
        // ->where('service_enquiry.assign_to', $userId)
        ->whereDate('service_task.callback', $today)
        ->whereNotIn('service_task.status', ['completed', 'cancelled'])
        ->select(
            'service_task.*',
            'service_enquiry.enq_no',
            'service_enquiry.name as enquiry_name',
            'users.name as assign_to'
        );

        if ($user->designation !== 'Admin') {
            $query->where('service_enquiry.assign_to', $userId);
        }
    
        $todayTasks = $query->get();

        return response()->json([
            'status' => 'success',
            'today_task_remainder' => $todayTasks,
        ], 200);
    }

    public function product_group_list()
  {
    try {
        $productGroups = DB::table('products_group')
            ->where('status', 'Active')
            ->select('id', 'group_name')   // optional
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'status' => 'success',
            // 'count' => $productGroups->count(),
            'data' => $productGroups
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to fetch product groups',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function product_list(Request $req)
{
    try {
        $products = DB::table('products')
            ->where('group_id', $req->product_group_id)
            ->where('status', 'Active')
            ->select('id', 'name')
            ->orderBy('id', 'ASC')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $products
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to fetch products',
            'error' => $e->getMessage()
        ], 500);
    }
}

//service enquiry store
public function service_enquiry_store(Request $req)
{

    $userId = Auth::id();
   
    // dd($userId);
    $user = User::where('id', $userId)
    ->where('user_status','Active')
    ->first();

    if (!$user) {
    return response()->json([
        'status' => 'error',
        'message' => 'Access denied: not active',
    ], 403);
    }
    $enq_no =    'ENQ' . rand(1000, 9999);

    $status = $req->lead_cycle === 'Final Decision' ? 'completed' : 'pending';

    $insert_id =   DB::table('service_enquiry')->insertGetId([
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
        'service_value' => $req->ser_value,
        'attended_by' => $req->attn_name,
        'service_date' => $req->serv_date,
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

    $task_store=DB::table('service_task')->insert([
        'enq_id' => $insert_id,
        'enq_no' => $enq_no,
        'product_id' => $req->enq_product,
        'purchase_group' => $req->Purchase_group,
        'user_id'  => $req->enq_assign_to,
        'remarks' =>  $req->enq_requirements ?? 'Enquiry Created',
        'lead_cycle' => $req->enq_lead_cycle,
        'quote' => $filename,
        'value' =>  $req->quote_value,
        'service_value' => $req->ser_value,
        'attended_by' => $req->attn_name,
        'service_date' => $req->serv_date,
        'status' => $status,
        'priority' => $req->priority,
        'created_by' => Auth::id(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);


    if ($task_store) {
                     
            $activeCustomers = DB::table('users')
                ->where('user_status', 'Active')
                ->where('device_token', '!=', '')  
                ->where('id', '=', $req->enq_assign_to)  
                ->select('id', 'device_token','name')
                ->first();
                if($activeCustomers)
                {
                    $body = "Your enquiry is currently in {$req->enq_lead_cycle} stage.\n"
                    . "⚠️ Priority: {$req->priority}";

                      $title="New Enquiry-{$enq_no}";

                      $body1 = "Your enquiry is currently in {$req->enq_lead_cycle} stage.\n"
                      . "Priority: {$req->priority}";

                DB::table('notification')->insert([
                    'assign_user_id' => $req->enq_assign_to,
                    'created_user_id' => Auth::id(),
                    'enq_id'=> $insert_id,
                    'type' => 'sales_enquiry',
                    'title' => $title,
                    'body'   => $body1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
              

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
               


    // return redirect()->route('user.service.enquiry.enquiry_list')->with([
    //     'status' => 'Success',
    //     'message' => 'Enquiry created successfully'
    // ]);
    return response()->json([
        'status' => 'success',
        'message' => 'Enquiry created successfully',
        
    ], 200);
}

public function service_report_filter(Request $request)
{

    $userId =  Auth::id(); // Get current user ID
    $user = User::find($userId);
    //dd($user->designation);

    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'Access denied: Not an employee',
        ], 403);
    }

    $query = DB::table('service_enquiry as eq')
    ->join('products as pt', 'eq.product_category', '=', 'pt.id')
    ->join('users as us', 'eq.assign_to', '=', 'us.id')
    ->leftJoin('products_group as pg', 'eq.enq_pro_group', '=', 'pg.id')
    ->select('eq.*', 'pt.name as product_name', 'us.name as usr_name', 'pg.group_name as group_name')
    ->when($user->designation !== 'Admin', function ($query) use ($user) {
        $query->where('assign_to', $user->id);
    })
    ->where(function ($q) {
        $q->where('eq.status', 'pending')
            ->orWhere(function ($sub) {
                $sub->whereIn('eq.status', ['completed', 'cancelled'])
                    ->whereMonth('eq.created_at', date('m'))
                    ->whereYear('eq.created_at', date('Y'));
            });
    });

// Apply date filter
if ($request->start_date && $request->end_date) {
    $query->whereBetween(DB::raw('DATE(eq.created_at)'), [
        $request->start_date,
        $request->end_date
    ]);
}

// Apply product group filter
if ($request->product_group) {
    $query->where('eq.enq_pro_group', $request->product_group);
}

// Apply product filter
if ($request->product_id) {
    $query->where('eq.product_category', $request->product_id);
}

// Apply enquiry number filter
if ($request->enq_no) {
    $query->where('eq.enq_no', 'like', '%' . $request->enq_no . '%');
}

// Apply assigned user filter
if ($request->assign_to) {
    $query->where('eq.assign_to', $request->assign_to);
}



$enquiry = $query->orderBy('eq.created_at', 'DESC')->get();


    return response()->json([
        'status' => 'success',
        'enquiry_list' => $enquiry,
        
    ], 200);

    //return view('user.service.reports.index', compact('enquiry', 'products', 'groups'));
}

public function ser_enquiry_list()
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

    $enquiry = DB::table('service_enquiry as eq')
    ->join('products as pt', 'eq.product_category', '=', 'pt.id')
    ->join('users as us', 'eq.assign_to', '=', 'us.id')
    ->leftJoin('products_group as pg', 'eq.enq_pro_group', '=', 'pg.id')
    ->select('eq.*', 'pt.name as product_name', 'us.name as usr_name', 'pg.group_name as group_name')
   // ->where('eq.assign_to', Auth::id()) // Filter by logged-in user
   ->when($user->designation !== 'Admin', function ($query) use ($user) {
    $query->where('assign_to', $user->id);
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

    // return view('admin.service.enquiry.enquiry_list', ['enquiry' => $enquiry]);
    return response()->json([
        'status' => 'success',
        'enquiry_list' => $enquiry,
        
    ], 200);
}


public function service_task_index()
{
    $authId = Auth::user()->id;
    // dd($authId);

    $user = Auth::user();


    $tasks_todo = DB::table('task_service')
    ->leftJoin('category', 'task_service.category', '=', 'category.id')
 
    ->leftJoin('users as assign_user', 'task_service.assign_to', '=', 'assign_user.id')
    ->leftJoin('users as created_user', 'task_service.created_by', '=', 'created_user.id')
  
    ->where('task_service.assign_to', $authId)
    ->where('task_service.task_status', 'To Do')
    ->select(
        'task_service.*',
        'category.cat_name as category_name',
        'created_user.designation as assigned_role',
        'created_user.name as assigned_user',
        // 'assigned_by_user.name as assigned_by'
    )
    ->orderBy('task_service.id', 'DESC')
    ->get();

$tasks_todo_count = DB::table('task_service')
    ->where('assign_to', $authId)
    ->where('task_status', 'To Do')
    ->count();


    $tasks_inprogress = DB::table('task_service')
    ->leftJoin('category', 'task_service.category', '=', 'category.id')
 
    ->leftJoin('users as assign_user', 'task_service.assign_to', '=', 'assign_user.id')
    ->leftJoin('users as created_user', 'task_service.created_by', '=', 'created_user.id')
  
    ->where('task_service.assign_to', $authId)
    ->where('task_service.task_status', 'In Progress')
    ->select(
        'task_service.*',
        'category.cat_name as category_name',
        'created_user.designation as assigned_role',
        'created_user.name as assigned_user',
        // 'assigned_by_user.name as assigned_by'
    )
    ->orderBy('task_service.id', 'DESC')
    ->get();

    $tasks_inprogress_count = DB::table('task_service')
    ->where('assign_to', $authId)
    ->where('task_status', 'In Progress')
    ->count();


    $tasks_complete = DB::table('task_service')
    ->leftJoin('category', 'task_service.category', '=', 'category.id')
 
    ->leftJoin('users as assign_user', 'task_service.assign_to', '=', 'assign_user.id')
    ->leftJoin('users as created_user', 'task_service.created_by', '=', 'created_user.id')
  
    ->where('task_service.assign_to', $authId)
    ->where('task_service.task_status', 'Completed')
    ->select(
        'task_service.*',
        'category.cat_name as category_name',
        'created_user.designation as assigned_role',
        'created_user.name as assigned_user',
        // 'assigned_by_user.name as assigned_by'
    )
    ->orderBy('task_service.id', 'DESC')
    ->get();

    $tasks_complete_count = DB::table('task_service')
    ->where('assign_to', $authId)
    ->where('task_status', 'Completed')
    ->count();

    
    return response()->json([
        'status' => 'success',
        'tasks_todo' => $tasks_todo,
        'tasks_todo_count' => $tasks_todo_count,
        'tasks_inprogress' => $tasks_inprogress, 
        'tasks_inprogress_count' => $tasks_inprogress_count,
        'tasks_complete' => $tasks_complete, 
        'tasks_complete_count' => $tasks_complete_count
       
        
    ], 200);
// dd ($tasks_todo_count);
    // return view('user.task.service_task_index',  ['tasks_todo' => $tasks_todo, 'tasks_todo_count' => $tasks_todo_count,'tasks_inprogress' => $tasks_inprogress,'tasks_inprogress_count' => $tasks_inprogress_count, 'tasks_complete_count' => $tasks_complete_count,'tasks_complete' => $tasks_complete,]);

}

public function service_task_status_update(Request $request)
{
    //Log::info($request->all());
    //dd($request->all());
    $taskId = $request->id;
    $newStatus = $request->status;

    $authId = Auth::user()->id;

    $task =  DB::table('task_service')
    ->where('id',$taskId)
    ->first();

    // if ($request->status == 'Close') {

        //$first = DB::table('task_sale')->where('f_id', $task->f_id)->orderBy('id', 'asc')->first();

        if ($task) {
           
        //         DB::table('task_sale')
        // ->where('id', $taskId)
        // ->update([
        //     'task_status' => $newStatus
        // ]);
        DB::table('task_service')
        ->where('id', $taskId)
        ->update([
            'task_status' => $newStatus
        ]);
        }
   // }
    // } elseif ($request->status == 'Completed') {
       
    //     if ($task) {
    //         $task->task_status = $newStatus;
    //         $task->task_completed = now();
    //         $task->save();
    //     }
    // } else {
       
    //     if ($task) {
    //         $task->task_status = $newStatus;
    //         $task->save();
    //     }
    // }

    $tasks_todo_count = DB::table('task_service')
        ->where('assign_to', $authId)
        ->where('task_status', 'To Do')
        ->count();

    $tasks_inprogress_count = DB::table('task_service')
        ->where('assign_to', $authId)
        ->where('task_status', 'In Progress')
        ->count();


    $tasks_complete_count = DB::table('task_service')
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
    ],200);

    return response()->json(['success' => false, 'message' => 'Task not found']);
}

public function service_task_ext(Request $req)
{

    $user = Auth::user();
   // $task = Task::findOrFail($req->task_id);
   $task =  DB::table('task_service')
   ->where('id',$req->task_id)
   ->first();

   //  $task1 = Task::findOrFail($task->f_id);

    if ($req->category == 'close') {

       $filename = null;
       if ($req->hasFile('close_attach')) {
         $image = $req->file('close_attach');
         $filename = time() . '_' . $image->getClientOriginalName();
         $image->move(public_path('image/task_service_file'), $filename);
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
        DB::table('service_task_ext')->insert([
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
        DB::table('service_task_ext')->insert([
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
