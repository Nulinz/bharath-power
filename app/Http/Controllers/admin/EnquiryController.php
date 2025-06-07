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
                        ->select('eq.*', 'pt.name as product_name')
                        ->get();

                return view('admin.enquiry.enquiry_list', ['enquiry' => $enquiry]);
        }

        public function add_enquiry()
        {
                $users = DB::table('users')->where('user_status', 'Active')->get();
                $products = DB::table('products')->where('status', 'Active')->get();
                return view('admin.enquiry.add_enquiry', ['users' => $users, 'products' => $products]);
        }


        public function enquiry_store(Request $req)
        {
                $enq_no =    'ENQ' . rand(1000, 9999);

                $status = $req->lead_cycle === 'Final Decision' ? 'completed' : 'pending';

                $insert_id =   DB::table('enquiry')->insertGetId([
                        'enq_no' => $enq_no,
                        'name' => $req->enq_name,
                        'product_category' => $req->enq_product,
                        'quantity' => $req->enq_qty,
                        'lead_cycle' => $req->enq_lead_cycle,
                        'upload_quote' => $req->enq_quote,
                        'requirements' => $req->enq_requirements,
                        'contact' => $req->enq_contact,
                        'location' => $req->enq_location,
                        'source' => $req->enq_source,
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
                        ->where('enq.id', $id)
                        ->select(
                                'enq.*',
                                'ur.name as assigned_user_name',
                                'pro.id as product_id',
                                'enq.id as enq_id',
                                'pro.name as product_name'
                        )
                        ->first();


                $task = DB::table('task as t')
                        ->leftJoin('users as u', 't.created_by', '=', 'u.id')
                        ->where('t.enq_id', $id)
                        ->select('t.*', 'u.name as created_by_name')
                        ->get();

                $user_id = Auth::id();

                return view('admin.enquiry.enquiry_view', ['enquiry' => $view_eq, 'task' => $task, 'user_id' => $user_id]);
        }
        // task
        // public function store_quote(Request $req)
        // {



        //         if ($req->hasFile('quote')) {
        //                 $image = $req->file('quote');
        //                 $filename = time() . '_' . $image->getClientOriginalName();

        //                 $image->move(public_path('assets/quote_files'), $filename);
        //         } else {
        //                 $filename = null;
        //         }

        //         DB::table('task')->insert([
        //                 'enq_id' => $req->enqid,
        //                 'enq_no' => $req->enqno,
        //                 'product_id' => $req->pro_id,
        //                 'user_id' => $req->user_id,
        //                 'remarks' => $req->remarks,
        //                 'lead_cycle' => $req->lead_cycle,
        //                 'quote' => $filename,
        //                 'purchase_group' => $req->Purchase_group,
        //                 'callback' => $req->callback,
        //                 'created_at'  => now(),
        //                 'updated_at' => now(),
        //         ]);

        //         DB::table('enquiry')
        //                 ->where('id', $req->enqid)
        //                 ->update([
        //                         'lead_cycle' => $req->lead_cycle,
        //                         'updated_at' => now(),
        //                 ]);

        //         return redirect()->route('admin.enquiry.enquiry_view', ['id' => $req->enqid])->with([
        //                 'status' => 'Success',
        //                 'message' => 'Task updated successfully'
        //         ]);

        // }


        public function store_quote(Request $req)
        {
                // Stop if task already completed
                $alreadyCompleted = DB::table('task')
                        ->where('enq_id', $req->enqid)
                        ->where('status', 'completed')
                        ->exists();

                if ($alreadyCompleted) {
                        return back()->withErrors(['message_error' => 'Task already completed.']);
                }

                // Handle file
                $filename = null;
                if ($req->hasFile('quote')) {
                        $file = $req->file('quote');
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('assets/quote_files'), $filename);
                }

                // Set task status
                $status = $req->lead_cycle === 'Final Decision' ? 'completed' : 'pending';

                // Insert task
                DB::table('task')->insert([
                        'enq_id' => $req->enqid,
                        'enq_no' => $req->enqno,
                        'product_id' => $req->pro_id,
                        'user_id' => $req->user_id,
                        'remarks' => $req->remarks,
                        'lead_cycle' => $req->lead_cycle,
                        'quote' => $filename,
                        'purchase_group' => $req->Purchase_group,
                        'callback' => $req->callback,
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
