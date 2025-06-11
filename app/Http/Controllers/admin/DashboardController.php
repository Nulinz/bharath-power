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
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('lead_cycle')
            ->pluck('total', 'lead_cycle');

        // Total enquiries for current month
        $totalEnquiries = DB::table('enquiry')
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
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
            ->get();



        return view('admin.dashboard.dashboard', ['leadCycleCounts' => $leadCycleCounts, 'todayTasks' => $todayTasks, 'totalEnquiries' => $totalEnquiries]);
    }
}
