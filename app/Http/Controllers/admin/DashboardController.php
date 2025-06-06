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

        $leadCycleCounts = DB::table('enquiry')
            ->select('lead_cycle', DB::raw('count(*) as total'))
            ->groupBy('lead_cycle')
            ->pluck('total', 'lead_cycle');


        $today = date('Y-m-d');

        // Fetch tasks for today
        $todayTasks = DB::table('task')
            ->whereDate('callback', $today)
            ->get();


        return view('admin.dashboard.dashboard', ['leadCycleCounts' => $leadCycleCounts, 'todayTasks' => $todayTasks]);
    }
}
