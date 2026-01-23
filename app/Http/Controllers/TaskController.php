<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Task;





class TaskController extends Controller
{
    //
     //  request extend or close
     public function task_ext(Request $req)
     {
 
         $user = Auth::user();
         $task = Task::findOrFail($req->task_id);
 
         $task1 = Task::findOrFail($task->f_id);
 
         if ($req->category == 'close') {
 
             // Handle file upload
             if ($req->hasFile('close_attach')) {
                 $image = $req->file('close_attach');
 
                 if ($image->isValid()) {
                     $filename = time().'_'.$image->getClientOriginalName();
                     $image->move('assets/images/task_sale_file', $filename);
                 } else {
                     return back()->with('error', 'Uploaded file is invalid.');
                 }
             } else {
                 return back()->with('error', 'Please upload a file to close the task.');
             }
 
             // Insert close request
             DB::table('task_ext')->insert([
                 'task_id' => $req->task_id,
                 'request_for' => $task1->assign_by ?? null,
                 'attach' => $filename,
                 'status' => 'Close Request',
                 'c_remarks' => $req->remarks,
                 'category' => $req->category,
                 'c_by' => $user->id,
                 'created_at' => now(),
                 'updated_at' => now(),
             ]);
         } else {
             // Insert extend request
             DB::table('task_ext')->insert([
                 'task_id' => $req->task_id,
                 'request_for' => $task1->assign_by ?? null,
                 'extend_date' => $req->extend_date,
                 'status' => 'Pending',
                 'c_remarks' => $req->remarks,
                 'category' => $req->category,
                 'c_by' => $user->id,
                 'created_at' => now(),
                 'updated_at' => now(),
             ]);
         }
 
         return redirect()->back()->with('success', 'Task end date updated successfully.');
     }
 
}
