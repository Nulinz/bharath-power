<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceDashboard extends Controller
{

    public function index()
    {
        // Lead cycle-wise count for current month
        $leadCycleCounts = DB::table('service_enquiry')
            ->select('lead_cycle', DB::raw('count(*) as total'))
            ->where(function ($query) {
                $query->whereIn('service_enquiry.status', ['completed', 'cancelled'])
                    ->whereMonth('service_enquiry.created_at', date('m'))
                    ->whereYear('service_enquiry.created_at', date('Y'));
            })
            ->orWhere('service_enquiry.status', 'pending')
            ->groupBy('lead_cycle')
            ->pluck('total', 'lead_cycle');

        // Total enquiries for current month
        $totalEnquiries = DB::table('service_enquiry')
            // ->whereMonth('created_at', date('m'))
            // ->whereYear('created_at', date('Y'))
            ->where(function ($query) {
                $query->whereIn('service_enquiry.status', ['completed', 'cancelled'])
                    ->whereMonth('service_enquiry.created_at', date('m'))
                    ->whereYear('service_enquiry.created_at', date('Y'));
            })
            ->orWhere('service_enquiry.status', 'pending')
            ->count();

        $today = date('Y-m-d');

        // Fetch tasks for today
        $todayTasks = DB::table('service_task')
            ->leftJoin('users', 'service_task.user_id', '=', 'users.id')
            ->select(
                'service_task.*',
                'users.name as assign_to'
            )
            ->whereDate('service_task.callback', $today)
            ->whereNotIn('service_task.status', ['completed', 'cancelled'])
            ->get();

        return view('admin.service.dashboard.dashboard', ['leadCycleCounts' => $leadCycleCounts, 'todayTasks' => $todayTasks, 'totalEnquiries' => $totalEnquiries]);
    }

    public function service_task_list()
    {
        $task_service = DB::table('task_service')
        ->join('category', 'task_service.category', '=', 'category.id')
        ->leftJoin('users as assign_user', 'task_service.assign_to', '=', 'assign_user.id')
        
        ->select(
            'task_service.*',
            'category.cat_name as category_name',
            'assign_user.name as assigned_name'
        )
        ->get();

    return view('admin.service.ser_task.service_task_list', compact('task_service'));
       // return view('admin.service.ser_task.service_task_list');

    }
    public function add_service_task()
    {
      $category = DB::table('category')
      ->where('status', 'Active')
      ->get();
      $users = DB::table('users')
      ->where('user_status', 'Active')
      ->get();
  
      return view('admin.service.ser_task.add_service_task',['category' => $category,'users' => $users]);
      // return view('admin.settings.add_category', ['add_group' => $add_group]);
    }
    public function service_task_profile(Request $req)
    {
       // dd($req->all());
       $task_service = DB::table('task_service')
        ->leftJoin('category', 'task_service.category', '=', 'category.id')
        ->leftJoin('users as assign_user', 'task_service.assign_to', '=', 'assign_user.id')
        ->leftJoin('users as created_user', 'task_service.created_by', '=', 'created_user.id')
        ->select(
            'task_service.*',
            'category.cat_name as category_name',
            'assign_user.name as assigned_name',
            'assign_user.designation as assigned_designation',
            'created_user.name as created_name',
             'created_user.designation as created_designation'
        )
        ->where('task_service.id', $req->id)
        ->first();

   
   //dd($task_service);
   //dd($task_service);
   $taskClosed = DB::table('service_task_ext')
   ->where('task_id', $req->id)
   ->whereRaw('LOWER(TRIM(category)) = ?', [strtolower('close')])
   ->exists();



        return view(
            'admin.service.ser_task.service_task_profile',
            compact('task_service','taskClosed')
        );

    }
}
