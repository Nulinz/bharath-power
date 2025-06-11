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
    $groups = DB::table('products_group')->get();

    $products = DB::table('products')
      ->leftJoin('products_group', 'products.group_id', '=', 'products_group.id')
      ->select('products.*', 'products_group.group_name as group_name') // update this if needed
      ->get();

    return view('admin.settings.settings', [
      'users' => $users,
      'products' => $products,
      'groups' => $groups
    ]);
  }

  public function add_product()
  {
    $add_group = DB::table('products_group')->get();

    return view('admin.settings.add_product', ['add_group' => $add_group]);
  }

  public function product_store(Request $request)

  {
    DB::table('products')->insert([
      'group_id' => $request->group_id,
      'name' => $request->pro_name,
      'desc'  => $request->pro_desc,
      'status'  => $request->pro_status,
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    return redirect()->route('admin.settings.settings')->with([
      'status' => 'success',
      'message' => 'Created Product',
    ]);
  }


  public function edit_product($id)
  {

    $product = DB::table('products')
      ->join('products_group', 'products.group_id', '=', 'products_group.id')
      ->select('products.*', 'products_group.group_name')
      ->where('products.id', $id)
      ->first();

    $productGroups = DB::table('products_group')->get();
    return view('admin.settings.edit_product', compact('product', 'productGroups'));
  }

  // update product
  public function update_product(Request $request)
  {

    DB::table('products')->where('id', $request->edit_id)->update([
      'group_id' => $request->group_id,
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

    return redirect()->route('admin.settings.settings')->with([
      'status' => 'Success',
      'message' => 'User created successfully'
    ]);
  }

  public function users_edit($id)
  {

    $user_data  = DB::table('users')->where('id', $id)->first();

    return view('admin.settings.edit_user', ['user_data' => $user_data]);
  }


  public function users_update(Request $req)
  {

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

  public function add_group()
  {
    return view('admin.settings.add_pro_group');
  }

  public function store_group(Request $req)
  {
    DB::table('products_group')->insert([
      'group_name' => $req->group_name,
      'desc' => $req->group_desc,
      'status' => $req->group_status,
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    return redirect()->route('admin.settings.settings')->with([
      'status' => 'Success',
      'message' => 'Product group created successfully'
    ]);
  }

  // edit group
  public function group_edit($id)
  {
    $group_edi = DB::table('products_group')->where('id', $id)->first();

    return view('admin.settings.edit_group', ['group_edi' => $group_edi]);
  }

  // group update
  public function group_update(Request $req)
  {
    DB::table('products_group')->where('id', $req->group_id)->update([
      'group_name' => $req->group_name,
      'desc' => $req->group_desc,
      'status' => $req->group_status,
      'updated_at' => now(),
    ]);

    // dd($req);

    return redirect()->route('admin.settings.settings')->with([
      'status' => 'Success',
      'message' => 'Prodcut Group Update'
    ]);

    // return view('admin.settings.edit_group');
  }
}
