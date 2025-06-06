<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
  public function settings()
  {
    $users = DB::table('users')->get();
    $products = DB::table('products')->get();
    return view('admin.settings.settings', ['users' => $users, 'products' => $products]);
  }

  //  public function product_view(){


  //     return view('admin.settings.settings', []);
  // }

  public function add_product()
  {
    return view('admin.settings.add_product');
  }

  public function product_store(Request $request)

  {

    // dd($request);

    DB::table('products')->insert([
      'name' => $request->pro_name,
      'desc'  => $request->pro_desc,
      'status'  => $request->pro_status,
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    return redirect()->route('admin.settings.settings', ['tab' => 'Products'])->with([
      'status' => 'success',
      'message' => 'Created Product',
    ]);
  }


  public function edit_product($id)
  {

    $products = DB::table('products')->where('id', $id)->first();

    return view('admin.settings.edit_product', ['products' => $products]);
  }

  // update product
  public function update_product(Request $request)
  {

    DB::table('products')->where('id', $request->edit_id)->update([
      'name' => $request->name,
      'desc'  => $request->desc,
      'status'  => $request->status,
      'updated_at' => now(),

    ]);

    return redirect()->route('admin.settings.settings')->with([
      'status' => 'Success',
      'message' => 'Product updated successfully'
    ]);
  }

  // user add
  public function add_user()
  {
    return view('admin.settings.add_users');
  }

  public function store_user(Request  $req)
  {
    DB::table('users')->insert([
      'name' => $req->user_name,
      'designation' => $req->user_desig,
      'contact_number' => $req->user_contact,
      'email' => $req->user_mail,
      'password' => $req->user_pass,
      'user_status' => $req->user_status,
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    return redirect()->route('admin.settings.settings', ['tab' => 'Users'])->with([
      'status' => 'Success',
      'message' => 'User created successfully'
    ]);
  }

  public function users_edit($id){

    $user_data  = DB::table('users')->where('id', $id)->first();

    return view('admin.settings.edit_user', ['user_data' => $user_data] );
  }


   public function users_update(Request $req){

     DB::table('users')->where('id', $req->user_id)->update([
       'name' => $req->user_name,
      'designation' => $req->user_desig,
      'contact_number' => $req->user_contact,
      'email' => $req->user_mail,
      'password' => $req->user_pass,
      'user_status' => $req->user_status,
      'updated_at' => now(),

    ]);

    return redirect()->route('admin.settings.settings')->with([
      'status' => 'Success',
      'message' => 'User updated successfully'
    ]);

  }

}
