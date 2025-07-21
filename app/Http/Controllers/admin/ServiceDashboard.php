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
}
