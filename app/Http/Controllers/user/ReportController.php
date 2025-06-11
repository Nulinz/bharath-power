<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function view_report(Request $request)
    {

        $userId =  Auth::id(); // Get current user ID

        $query = DB::table('enquiry as eq')
            ->join('products as pt', 'eq.product_category', '=', 'pt.id')
            ->join('users as us', 'eq.assign_to', '=', 'us.id')
            ->leftJoin('products_group as pg', 'eq.enq_pro_group', '=', 'pg.id')
            ->select('eq.*', 'pt.name as product_name', 'us.name as usr_name', 'pg.group_name as group_name')
            ->where('eq.assign_to', $userId) // Only assigned enquiries
            ->where(function ($q) {
                $q->where('eq.status', 'pending') // Include all pending
                    ->orWhere(function ($sub) {
                        $sub->whereIn('eq.status', ['cancelled', 'completed']) // Only completed/cancelled from current month
                            ->whereMonth('eq.created_at', date('m'))
                            ->whereYear('eq.created_at', date('Y'));
                    });
            })
            ->orderBy('eq.created_at', 'DESC');


        // Date filter
        if ($request->start_date && $request->end_date) {
            $query->whereBetween(DB::raw('DATE(eq.created_at)'), [
                $request->start_date,
                $request->end_date
            ]);
        }

        // Product Group filter
        if ($request->product_group) {
            $query->where('eq.enq_pro_group', $request->product_group);
        }

        // Product filter
        if ($request->product_id) {
            $query->where('eq.product_category', $request->product_id);
        }

        // Enquiry number filter
        if ($request->enq_no) {
            $query->where('eq.enq_no', 'like', '%' . $request->enq_no . '%');
        }

        $enquiry = $query->orderBy('eq.created_at', 'DESC')->get();

        // Dropdown data
        $products = DB::table('products')->pluck('name', 'id');
        $groups = DB::table('products_group')->pluck('group_name', 'id');

        return view('user.reports.index', compact('enquiry', 'products', 'groups'));
    }
}
