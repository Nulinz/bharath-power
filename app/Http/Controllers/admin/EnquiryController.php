<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnquiryController extends Controller
{
        //        list of enquiry
        public function enquiry_list()
        {

                $enquiry = DB::table('enquiry as eq')
                        ->join('products as pt', 'eq.product_category', '=', 'pt.id')
                        ->join('users as us', 'eq.assign_to', '=', 'us.id')
                        ->leftJoin('products_group as pg', 'eq.enq_pro_group', '=', 'pg.id')
                        ->select('eq.*', 'pt.name as product_name', 'us.name as usr_name', 'pg.group_name as group_name')
                        ->where(function ($query) {
                                $query->whereIn('eq.status', ['completed', 'cancelled'])
                                        ->whereMonth('eq.created_at', date('m'))
                                        ->whereYear('eq.created_at', date('Y'));
                        })
                        ->orWhere('eq.status', 'pending')
                        ->orderBy('eq.created_at', 'DESC')
                        ->get();

                return view('admin.enquiry.enquiry_list', ['enquiry' => $enquiry]);
        }

        public function add_enquiry()
        {
                $users = DB::table('users')->where('user_status', 'Active')->get();
                $products = DB::table('products')->where('status', 'Active')->get();
                $add_group = DB::table('products_group')->where('status', 'Active')->get();
                return view('admin.enquiry.add_enquiry', ['users' => $users, 'products' => $products, 'add_group' => $add_group]);
        }


        public function enquiry_store(Request $req)
        {
                $enq_no =    'ENQ' . rand(1000, 9999);

                $status = $req->lead_cycle === 'Final Decision' ? 'completed' : 'pending';

                $insert_id =   DB::table('enquiry')->insertGetId([
                        'enq_no' => $enq_no,
                        'name' => $req->enq_name,
                        'enq_pro_group' => $req->enq_pro_group,
                        'product_category' => $req->enq_product,
                        'quantity' => $req->enq_qty,
                        'enq_capacity' => $req->enq_capacity,
                        'enq_uom' => $req->enq_uom,
                        'lead_cycle' => $req->enq_lead_cycle,
                        'upload_quote' => $req->enq_quote,
                        'requirements' => $req->enq_requirements,
                        'contact' => $req->enq_contact,
                        'location' => $req->enq_location,
                        'enq_address' => $req->enq_address,
                        'source' => $req->enq_source,
                        'enq_ref_name' => $req->enq_ref_name,
                        'enq_ref_contact' => $req->enq_ref_contact,
                        'status' => $status,
                        'created_by' => Auth::id(),
                        'assign_to' => $req->enq_assign_to,
                        'created_at' => now(),
                        'updated_at' => now(),
                ]);

                if ($req->hasFile('enq_quote')) {
                        $image = $req->file('enq_quote');
                        $filename = time() . '_' . $image->getClientOriginalName();

                        $image->move(public_path('assets/quote_files'), $filename);
                } else {
                        $filename = null;
                }

                DB::table('task')->insert([
                        'enq_id' => $insert_id,
                        'enq_no' => $enq_no,
                        'product_id' => $req->enq_product,
                        'purchase_group' => $req->Purchase_group,
                        'remarks' => 'Enquiry Created',
                        'user_id'  => $req->enq_assign_to,
                        'lead_cycle' => $req->enq_lead_cycle,
                        'quote' => $filename,
                        'value' =>  $req->quote_value,
                        'status' => $status,
                        'created_by' => Auth::id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                ]);

                return redirect()->route('admin.enquiry.enquiry_list')->with([
                        'status' => 'Success',
                        'message' => 'Enquiry created successfully'
                ]);
        }

        public function view_enquiry($id)
        {
                $view_eq = DB::table('enquiry as enq')
                        ->leftJoin('users as ur', 'enq.assign_to', '=', 'ur.id')
                        ->leftJoin('products as pro', 'enq.product_category', '=', 'pro.id')
                        ->leftJoin('products_group as pg', 'pg.id', '=', 'enq.enq_pro_group')
                        ->where('enq.id', $id)
                        ->select(
                                'enq.*',
                                'ur.name as assigned_user_name',
                                'pro.id as product_id',
                                'enq.id as enq_id',
                        'pro.name as product_name',
                        'pg.group_name as group_name'
                        )
                        ->orderBy('created_at', 'DESC')
                        ->first();


                $task = DB::table('task as t')
                        ->leftJoin('users as u', 't.created_by', '=', 'u.id')
                        ->where('t.enq_id', $id)
                        ->select('t.*', 'u.name as created_by_name')
                        ->orderBy('created_at', 'DESC')
                        ->get();

                $user_id = Auth::id();

                return view('admin.enquiry.enquiry_view', ['enquiry' => $view_eq, 'task' => $task, 'user_id' => $user_id]);
        }

        public function store_quote(Request $req)
        {
                // Stop if task already completed
                $alreadyCompleted = DB::table('task')
                        ->where('enq_id', $req->enqid)
                        ->whereIn('status', ['completed', 'cancelled'])
                        ->exists();

                if ($alreadyCompleted) {
                        return back()->withErrors(['message_error' => 'Task already completed.']);
                }

                // Handle file
                if ($req->hasFile('quote')) {
                        $file = $req->file('quote');
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('assets/quote_files'), $filename);
                } else {
                        $filename = null;
                }

                if ($req->hasFile('cancel_upload')) {
                        $file = $req->file('cancel_upload');
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('assets/quote_files'), $filename);
                } else {
                        $filename = null;
                }

                // Set task status
                if ($req->lead_cycle === 'Final Decision') {
                        $status = 'completed';
                } elseif ($req->lead_cycle === 'Cancelled') {
                        $status = 'cancelled';
                } else {
                        $status = 'pending';
                }

                // Insert task
                DB::table('task')->insert([
                        'enq_id' => $req->enqid,
                        'enq_no' => $req->enqno,
                        'product_id' => $req->pro_id,
                        'user_id' => $req->user_id,
                        'remarks' => $req->remarks,
                        'lead_cycle' => $req->lead_cycle,
                        'quote' => $filename,
                        'cancel_reason' => $req->cancel,
                        'cancel_upload' => $req->cancel_upload,
                        'purchase_group' => $req->Purchase_group,
                        'callback' => $req->callback,
                        'value' => $req->quote_value,
                        'status' => $status,
                        'created_by' => Auth::id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                ]);

                // Update enquiry
                DB::table('enquiry')->where('id', $req->enqid)->update([
                        'lead_cycle' => $req->lead_cycle,
                        'status' => $status,
                        'updated_at' => now(),
                ]);

                return redirect()->route('admin.enquiry.enquiry_view', ['id' => $req->enqid])
                        ->with(['status' => 'Success', 'message' => 'Task updated successfully']);
        }

        public function enquiry_view($id)
        {
                // Fetch enquiry with related user and product info
                $enquiry = DB::table('enquiry as enq')
                        ->leftJoin('users as ur', 'enq.assign_to', '=', 'ur.id')
                        ->leftJoin('products as pro', 'enq.product_category', '=', 'pro.id')
                        ->where('enq.id', $id)
                        ->select(
                                'enq.*',
                                'ur.name as assigned_user_name',
                                'pro.id as product_id',
                                'pro.name as product_name',
                                'enq.id as enq_id'
                        )
                        ->first();

                // Get all tasks related to this enquiry
                $tasks = DB::table('task')
                        ->leftJoin('users', 'task.created_by', '=', 'users.id')
                        ->where('task.enq_id', $id)
                        ->select('task.*', 'users.name as created_by_name')
                        ->orderBy('task.updated_at', 'desc')
                        ->get();

                // Optional: check if user is allowed to view this enquiry
                if (!$enquiry || ($enquiry->assign_to !== Auth::id() && Auth::user()->role !== 'admin')) {
                        abort(403, 'Unauthorized');
                }

                // Return the view with the enquiry and task data
                return view('admin.enquiry.enquiry_view', compact('enquiry', 'tasks'));
        }
};
