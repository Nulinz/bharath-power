<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DashboardController extends Controller
{
    public function dashboard()
    {

        // $leadCycleCounts = DB::table('enquiry')
        //     ->select('lead_cycle', DB::raw('COUNT(*) AS total'))
        //     ->where(function ($query) {
        //         $query->whereIn('enquiry.status', ['completed', 'cancelled'])
        //             ->whereMonth('enquiry.created_at', date('m'))
        //             ->whereYear('enquiry.created_at', date('Y'));
        //     })
        //     ->where('assign_to', Auth::id())
        //     ->orWhere('enquiry.status', 'pending')
        //     ->groupBy('lead_cycle')
        //     ->pluck('total', 'lead_cycle');


        $leadCycleCounts = DB::table('enquiry')
            ->select('lead_cycle', DB::raw('COUNT(*) AS total'))
            ->where('assign_to', Auth::id())
            ->where(function ($query) {
                $query->whereIn('enquiry.status', ['completed', 'cancelled'])
                    ->whereMonth('enquiry.created_at', date('m'))
                    ->whereYear('enquiry.created_at', date('Y'))
                    ->orWhere('enquiry.status', 'pending'); // still under assign_to
            })
            ->groupBy('lead_cycle')
            ->pluck('total', 'lead_cycle');

        $totalEnquiries = DB::table('enquiry')
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->whereIn('enquiry.status', ['completed', 'cancelled'])
                        ->whereMonth('enquiry.created_at', date('m'))
                        ->whereYear('enquiry.created_at', date('Y'));
                })->orWhere('enquiry.status', 'pending');
            })
            ->where('assign_to', Auth::id())
            ->count();



        $userId = Auth::id();
        $today = date('Y-m-d');

        // Get today's tasks based on enquiries assigned to this user
        // $todayTasks = DB::table('task')
        //     ->join('enquiry', 'task.enq_id', '=', 'enquiry.id')
        //     ->leftJoin('users', 'task.user_id', '=', 'users.id')
        //     ->where('enquiry.assign_to', $userId)
        //     ->whereDate('task.callback', $today)
        //     ->select('task.*', 'enquiry.enq_no', 'enquiry.name as enquiry_name',  'users.name as assign_to')
        //     ->get();

        $todayTasks = DB::table('task')
            ->join('enquiry', 'task.enq_id', '=', 'enquiry.id')
            ->leftJoin('users', 'task.user_id', '=', 'users.id')
            ->where('enquiry.assign_to', $userId)
            ->whereDate('task.callback', $today)
            ->whereNotIn('task.status', ['completed', 'cancelled'])
            ->select(
                'task.*',
                'enquiry.enq_no',
                'enquiry.name as enquiry_name',
                'users.name as assign_to'
            )
            ->get();


        return view('user.dashboard.dashboard', [
            'leadCycleCounts' => $leadCycleCounts,
            'todayTasks' => $todayTasks,
            'totalEnquiries' => $totalEnquiries
        ]);
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

    public function updateTaskStatus(Request $request)
    {
        //Log::info($request->all());
        //dd($request->all());
        $taskId = $request->id;
        $newStatus = $request->status;

        $authId = Auth::user()->id;

        $task =  DB::table('task_sale')
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
            DB::table('task_sale')
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
        ]);

        return response()->json(['success' => false, 'message' => 'Task not found']);
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
// dd ($tasks_todo_count);
        return view('user.task.service_task_index',  ['tasks_todo' => $tasks_todo, 'tasks_todo_count' => $tasks_todo_count,'tasks_inprogress' => $tasks_inprogress,'tasks_inprogress_count' => $tasks_inprogress_count, 'tasks_complete_count' => $tasks_complete_count,'tasks_complete' => $tasks_complete,]);

    }

    public function update_service_status(Request $request)
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
        ]);

        return response()->json(['success' => false, 'message' => 'Task not found']);
    }

    public function task_ext(Request $req)
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
 
         return redirect()->back()->with('success', 'Task end date updated successfully.');
     }


     public function update_service_task(Request $request)
    {
        //Log::info($request->all());
        //dd($request->all());
        $taskId = $request->id;
        $newStatus = $request->status;

        $authId = Auth::user()->id;

        $task =  DB::table('task_service')
        ->where('id',$taskId)
        ->first();

     

            if ($task) {
               
         
            DB::table('task_service')
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
        ]);

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

        return redirect()->back()->with('success', 'Task end date updated successfully.');
    }




}
