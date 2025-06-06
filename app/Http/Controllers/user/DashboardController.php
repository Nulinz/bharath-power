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
        ->pluck('total', 'lead_cycle'); // returns ['lead_cycle' => total]


    $today = date('Y-m-d');

        $todayTasks = DB::table('task')
            ->whereDate('callback', $today)
            ->where('id', Auth::id())
            ->get();

        return view('user.dashboard.dashboard', ['leadCycleCounts' => $leadCycleCounts, 'todayTasks' => $todayTasks]);
    }
}
