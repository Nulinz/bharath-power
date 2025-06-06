<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnquiryController extends Controller
{
      public function enquiry_list(){

          $enquiry = DB::table('enquiry as eq')
                  ->join('products as pt', 'eq.product_category', '=', 'pt.id')
                  ->select('eq.*', 'pt.name as product_name')
                  ->where('assign_to', Auth::id())->get();

            return view('user.enquiry.enquiry_list', ['enquiry' => $enquiry]);
    }

     public function add_enquiry(){
                  $users = DB::table('users')->get();
                  $products = DB::table('products')->get();
                  return view('user.enquiry.add_enquiry', ['users' => $users, 'products' => $products]);
    }


      public function enquiry_store(Request $req)
        {

                $enq_no =    'ENQ' . rand(1000, 9999);


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
                        'user_id'  => $req->enq_assign_to,
                        'lead_cycle' => $req->enq_lead_cycle,
                        'quote' => $filename,
                        'created_at' => now(),
                        'updated_at' => now(),
                ]);

                return redirect()->route('user.enquiry.enquiry_list')->with([
                        'status' => 'Success',
                        'message' => 'Enquiry created successfully'
                ]);
        }

      public function view_enquiry($id){

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


                $task = DB::table('task')
                        ->where('enq_id', $id)
                        ->get();

                $user_id = Auth::id();

                return view('user.enquiry.enquiry_view', ['enquiry' => $view_eq, 'task' => $task, 'user_id' => $user_id]);

    }

//     task

     public function store_quote(Request $req)
        {

                if ($req->hasFile('quote')) {
                        $image = $req->file('quote');
                        $filename = time() . '_' . $image->getClientOriginalName();

                        $image->move(public_path('assets/quote_files'), $filename);
                } else {
                        $filename = null; // no file uploaded
                }

                DB::table('task')->insert([
                        'enq_id' => $req->enqid,
                        'enq_no' => $req->enqno,
                        'product_id' => $req->pro_id,
                        'user_id' => $req->user_id,
                        //  'name' => $req->enq_no,
                        'remarks' => $req->remarks,
                        'lead_cycle' => $req->lead_cycle,
                        'quote' => $filename,
                        'callback' => $req->callback,
                        'created_at'  => now(),
                        'updated_at' => now(),
                ]);

                 DB::table('enquiry')
                        ->where('id', $req->enqid)
                        ->update([
                                'lead_cycle' => $req->lead_cycle,
                                'updated_at' => now()
                 ]);

                return redirect()->route('user.enquiry.enquiry_view', ['id' => $req->enqid])->with([
                        'status' => 'Success',
                        'message' => 'Task updated successfully'
                ]);
        }

}
