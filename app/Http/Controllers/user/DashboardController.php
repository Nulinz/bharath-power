<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {

        $leadCycleCounts = DB::table('enquiry')
            ->select('lead_cycle', DB::raw('COUNT(*) AS total'))
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->where('assign_to', Auth::id())
            ->groupBy('lead_cycle')
            ->pluck('total', 'lead_cycle');

        $totalEnquiries = DB::table('enquiry')
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->where('assign_to', Auth::id())
            ->count();


        $userId = Auth::id();
        $today = date('Y-m-d');

        // Get today's tasks based on enquiries assigned to this user
        $todayTasks = DB::table('task')
            ->join('enquiry', 'task.enq_id', '=', 'enquiry.id')
            ->leftJoin('users', 'task.user_id', '=', 'users.id')
            ->where('enquiry.assign_to', $userId)
            ->where(function ($query) use ($today) {
                $query->whereDate('task.created_at', $today)
                    ->orWhereDate('task.updated_at', $today);
            })
            ->select('task.*', 'enquiry.enq_no', 'enquiry.name as enquiry_name',  'users.name as assign_to')
            ->get();

        return view('user.dashboard.dashboard', [
            'leadCycleCounts' => $leadCycleCounts,
            'todayTasks' => $todayTasks,
            'totalEnquiries' => $totalEnquiries
        ]);
    }
}
