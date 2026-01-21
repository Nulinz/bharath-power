<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {

        // $leadCycleCounts = DB::table('enquiry')
        //     ->select('lead_cycle', DB::raw('count(*) as total'))
        //     ->groupBy('lead_cycle')
        //     ->pluck('total', 'lead_cycle');


        // $leadCycleCounts = DB::table('enquiry')
        //     ->select('lead_cycle', DB::raw('count(*) as total'))
        //     ->whereRaw('MONTH(created_at) = ?', [date('m')])
        //     ->whereRaw('YEAR(created_at) = ?', [date('Y')])
        //     ->groupBy('lead_cycle')
        //     ->pluck('total', 'lead_cycle');
        //     ->count('enquiy')


        // Lead cycle-wise count for current month
        $leadCycleCounts = DB::table('enquiry')
            ->select('lead_cycle', DB::raw('count(*) as total'))
            ->where(function ($query) {
                $query->whereIn('enquiry.status', ['completed', 'cancelled'])
                    ->whereMonth('enquiry.created_at', date('m'))
                    ->whereYear('enquiry.created_at', date('Y'));
            })
            ->orWhere('enquiry.status', 'pending')
            ->groupBy('lead_cycle')
            ->pluck('total', 'lead_cycle');

        // Total enquiries for current month
        $totalEnquiries = DB::table('enquiry')
            // ->whereMonth('created_at', date('m'))
            // ->whereYear('created_at', date('Y'))
            ->where(function ($query) {
                $query->whereIn('enquiry.status', ['completed', 'cancelled'])
                    ->whereMonth('enquiry.created_at', date('m'))
                    ->whereYear('enquiry.created_at', date('Y'));
            })
            ->orWhere('enquiry.status', 'pending')
            ->count();

        $today = date('Y-m-d');

        // Fetch tasks for today
        $todayTasks = DB::table('task')
            ->leftJoin('users', 'task.user_id', '=', 'users.id')
            ->select(
                'task.*',
                'users.name as assign_to'
            )
            ->whereDate('task.callback', $today)
            ->whereNotIn('task.status', ['completed', 'cancelled'])
            ->get();

        return view('admin.dashboard.dashboard', ['leadCycleCounts' => $leadCycleCounts, 'todayTasks' => $todayTasks, 'totalEnquiries' => $totalEnquiries]);
    }
    public function task_list()
    {
      $task_sale = DB::table('task_sale')
        ->join('category', 'task_sale.category', '=', 'category.id')
        ->leftJoin('users as assign_user', 'task_sale.assign_to', '=', 'assign_user.id')
        ->select(
            'task_sale.*',
            'category.cat_name as category_name',
            'assign_user.name as assigned_name',
        )
        ->get();
        $users = DB::table('users')
        ->select('id', 'name')
        ->where('user_status', 'Active') // optional
        ->get();

        return view('admin.task.task_list', compact('task_sale', 'users'));
    }

    public function add_task()
    {
      $category = DB::table('category')
      ->where('status','Active')
      ->get();
      $users = DB::table('users')
      ->where('user_status','Active')
      ->get();
  
      return view('admin.task.add_task',['category' => $category,'users' => $users]);
      // return view('admin.settings.add_category', ['add_group' => $add_group]);
    }

    public function task_store(Request $request)

  {
    DB::table('sales_task_assign')->insert([
      // 'group_id' => $request->group_id,
      'title' => $request->title,
      'f_cat'  => $request->category,
      'f_user'  => $request->user,
      'des' => $request->description,
      'addtional'  => $request->addtional,
      'start_date'  => $request->start_date,
      'start_time' => $request->start_time,
      'end_date'  => $request->end_date,
      'end_time'  => $request->end_time,
      'priority' => $request->priority,
      'file'  => $request->addtional,
      'status'  =>'Active',
      'created_by'  =>'Active',
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    return redirect()->route('admin.settings.settings')->with([
      'status' => 'success',
      'message' => 'Task Category',
    ]);
  }
  public function sales_task_profile(Request $req)
  {
    $task_sales = DB::table('task_sale')
    ->leftJoin('category', 'task_sale.category', '=', 'category.id')
    ->leftJoin('users as assign_user', 'task_sale.assign_to', '=', 'assign_user.id')
    ->leftJoin('users as created_user', 'task_sale.created_by', '=', 'created_user.id')
    ->select(
        'task_sale.*',
        'category.cat_name as category_name',
        'assign_user.name as assigned_name',
        'assign_user.designation as assigned_designation',
        'created_user.name as created_name',
         'created_user.designation as created_designation'
    )
    ->where('task_sale.id', $req->id)
    ->first();

    return view(
      'admin.task.sales_task_profile',
      compact('task_sales')
  );

      // return view('admin.task.sales_task_profile');

  }


  public function task_sale_store(Request $request)
  {
    $request->validate([
      'task_title' => 'required',
      'file' => 'nullable|mimes:jpg,jpeg,png,pdf', // 2MB
  ]);

    $filename = null;
    if ($request->hasFile('file')) {
      $image = $request->file('file');
      $filename = time() . '_' . $image->getClientOriginalName();
      $image->move(public_path('image/task_sale_file'), $filename);
  }

    DB::table('task_sale')->insert([
      // 'group_id' => $request->group_id,

      'task_title' => $request->task_title,
      'category'  => $request->category_id,
      'assign_to'  => $request->user_id,
       // 'group_id' => $request->group_id,
       'description' => $request->description,
       'add_info'  => $request->add_info,
       'start_date'  => $request->start_date,
       'start_time'  => $request->start_time,
       // 'group_id' => $request->group_id,
       'end_date' => $request->end_date,
       'end_time'  => $request->end_time,
       'priority'  => $request->priority,
       'file'  => $filename,
       'status'  => 'Active',
       'created_by'  =>$request->user,
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    return redirect()->route('admin.admin.task.task_list')->with([
      'status' => 'success',
      'message' => 'Created Task',
    ]);
  }

   public function task_service_store(Request $request)
  {
   // dd($request->all());
    $filename = null;
    if ($request->hasFile('file')) {
      $image = $request->file('file');
      $filename = time() . '_' . $image->getClientOriginalName();
      $image->move(public_path('image/task_service_file'), $filename);
  }

    DB::table('task_service')->insert([
      // 'group_id' => $request->group_id,

      'task_title' => $request->task_title,
      'category'  => $request->category_id,
      'assign_to'  => $request->user_id,
       // 'group_id' => $request->group_id,
       'description' => $request->description,
       'add_info'  => $request->add_info,
       'start_date'  => $request->start_date,
       'start_time'  => $request->start_time,
       // 'group_id' => $request->group_id,
       'end_date' => $request->end_date,
       'end_time'  => $request->end_time,
       'priority'  => $request->priority,
       'file'  => $filename,
       'status'  => 'Active',
       'created_by'  => $request->user,
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    return redirect()->route('admin.service.service_task-list')->with([
      'status' => 'success',
      'message' => 'Created Task',
    ]);
  }

    
}
