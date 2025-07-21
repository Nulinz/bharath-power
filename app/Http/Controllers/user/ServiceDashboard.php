<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceDashboard extends Controller
{
    public function index()
    {
        $leadCycleCounts = DB::table('service_enquiry')
            ->select('lead_cycle', DB::raw('COUNT(*) AS total'))
            ->where('assign_to', Auth::id())
            ->where(function ($query) {
                $query->whereIn('service_enquiry.status', ['completed', 'cancelled'])
                    ->whereMonth('service_enquiry.created_at', date('m'))
                    ->whereYear('service_enquiry.created_at', date('Y'))
                    ->orWhere('service_enquiry.status', 'pending'); // still under assign_to
            })
            ->groupBy('lead_cycle')
            ->pluck('total', 'lead_cycle');

        $totalEnquiries = DB::table('service_enquiry')
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->whereIn('service_enquiry.status', ['completed', 'cancelled'])
                        ->whereMonth('service_enquiry.created_at', date('m'))
                        ->whereYear('service_enquiry.created_at', date('Y'));
                })->orWhere('service_enquiry.status', 'pending');
            })
            ->where('assign_to', Auth::id())
            ->count();

        $userId = Auth::id();
        $today = date('Y-m-d');

        $todayTasks = DB::table('service_task')
            ->join('service_enquiry', 'service_task.enq_id', '=', 'service_enquiry.id')
            ->leftJoin('users', 'service_task.user_id', '=', 'users.id')
            ->where('service_enquiry.assign_to', $userId)
            ->whereDate('service_task.callback', $today)
            ->whereNotIn('service_task.status', ['completed', 'cancelled'])
            ->select(
                'service_task.*',
                'service_enquiry.enq_no',
                'service_enquiry.name as enquiry_name',
                'users.name as assign_to'
            )
            ->get();


        return view('user.service.dashboard.dashboard', [
            'leadCycleCounts' => $leadCycleCounts,
            'todayTasks' => $todayTasks,
            'totalEnquiries' => $totalEnquiries
        ]);
    }
}
