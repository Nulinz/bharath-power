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
}
