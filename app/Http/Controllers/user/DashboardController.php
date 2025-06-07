<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
     public function dashboard(){



        $leadCycleCounts = DB::table('enquiry')
            ->select('lead_cycle', DB::raw('COUNT(*) AS total'))
            ->where('assign_to', Auth::id())
            ->groupBy('lead_cycle')
            ->pluck('total', 'lead_cycle');


        // $today = date('Y-m-d');

        // $todayTasks = DB::table('task')
        //     ->whereDate('callback', $today)
        //     ->where('user_id', Auth::id())
        //     ->get();

        $userId = Auth::id();
        $today = date('Y-m-d');

        // Get lead cycle counts for the current user
        // $leadCycleCounts = DB::table('enquiry')
        //     ->select('lead_cycle', DB::raw('COUNT(*) AS total'))
        //     ->where('assign_to', $userId)
        //     ->groupBy('lead_cycle')
        //     ->pluck('total', 'lead_cycle');

        // Get today's tasks based on enquiries assigned to this user
        $todayTasks = DB::table('task')
            ->join('enquiry', 'task.enq_id', '=', 'enquiry.id')
            ->where('enquiry.assign_to', $userId)
            ->where(function ($query) use ($today) {
                $query->whereDate('task.created_at', $today)
                    ->orWhereDate('task.updated_at', $today);
            })
            ->select('task.*', 'enquiry.enq_no', 'enquiry.name as enquiry_name')
            ->get();

        return view('user.dashboard.dashboard', [
            'leadCycleCounts' => $leadCycleCounts,
            'todayTasks' => $todayTasks
        ]);



        // return view('user.dashboard.dashboard', ['leadCycleCounts' => $leadCycleCounts, 'todayTasks' => $todayTasks]);
    }
}
