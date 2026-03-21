<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{

    public function view_report(Request $request)
    {
        $query = DB::table('enquiry as eq')
            ->join('products as pt', 'eq.product_category', '=', 'pt.id')
            ->join('users as us', 'eq.assign_to', '=', 'us.id')
            ->leftJoin('products_group as pg', 'eq.enq_pro_group', '=', 'pg.id')
            ->select('eq.*', 'pt.name as product_name', 'us.name as usr_name', 'pg.group_name as group_name');
        // ->orderBy('eq.created_at', 'DESC')->get();
        // Optional filters (only applied if present)

        // Date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween(DB::raw('DATE(eq.created_at)'), [
                $request->start_date,
                $request->end_date
            ]);
        }

        // Product group
        if ($request->filled('product_group')) {
            $query->where('eq.enq_pro_group', $request->product_group);
        }

        // Product
        if ($request->filled('product_id')) {
            $query->where('eq.product_category', $request->product_id);
        }

        // Enquiry number
        if ($request->filled('enq_no')) {
            $query->where('eq.enq_no', 'like', '%' . $request->enq_no . '%');
        }
        // Priority filter
        if ($request->filled('priority')) {
            $query->where('eq.enq_priority', $request->priority);
        }

        // Assigned user
        if ($request->filled('assign_to')) {
            $query->where('eq.assign_to', $request->assign_to);
        }

        // Get final data
        $enquiry = $query->orderBy('eq.created_at', 'DESC')->get();

        // Dropdowns for filters
        $products = DB::table('products')->pluck('name', 'id');
        $users = DB::table('users')->pluck('name', 'id');
        $groups = DB::table('products_group')->pluck('group_name', 'id');

        return view('admin.reports.index', compact('enquiry', 'products', 'users', 'groups'));
    }
}
