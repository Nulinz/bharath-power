<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ApiSettingsController extends Controller
{
    //

    public function add_product(Request $request)
    {
  
      $userId = Auth::id();
      $user = User::where('id', $userId)
      ->where('user_status', 'Active')
      ->first();
  
      if (!$user) {
       return response()->json([
           'status' => 'error',
           'message' => 'Access denied: user not found',
       ], 403);
   }
      DB::table('products')->insert([
        'group_id' => $request->group_id,
        'name' => $request->pro_name,
        'desc'  => $request->pro_desc,
        'status'  => $request->pro_status,
        'created_at' => now(),
        'updated_at' => now(),
      ]);
  
      
      return response()->json([
          'status' => 'success',
          'message' => 'Products added Successfuly',
          // 'users' => $users,
         
      ], 200);
  
      // return redirect()->route('admin.settings.settings')->with([
      //   'status' => 'success',
      //   'message' => 'Created Product',
      // ]);
    }
    public function setting_fetch_list(Request $request)
    {
  
     $userId = Auth::id();
      $user = User::where('id', $userId)
      ->where('user_status', 'Active')
      ->first();
  
      if (!$user) {
       return response()->json([
           'status' => 'error',
           'message' => 'Access denied: user not found',
       ], 403);
   }
    $users = DB::table('users')->get();
    $groups = DB::table('products_group')->get();
    $category = DB::table('category')->get();

    $products = DB::table('products')
      ->leftJoin('products_group', 'products.group_id', '=', 'products_group.id')
      ->select('products.*', 'products_group.group_name as group_name') // update this if needed
      ->get();

      return response()->json([
      'users' => $users,
      'products' => $products,
      'groups' => $groups,
      'category' => $category
    ]);
}

//edit product
public function edit_product(Request $request)
  {

    $userId = Auth::id();
    $user = User::where('id', $userId)
    ->where('user_status', 'Active')
    ->first();

    if (!$user) {
     return response()->json([
         'status' => 'error',
         'message' => 'Access denied: user not found',
     ], 403);
 }
     
    $product = DB::table('products')
      ->join('products_group', 'products.group_id', '=', 'products_group.id')
      ->select('products.*', 'products_group.group_name')
      ->where('products.id', $request->product_id)
      ->first();

    $productGroups = DB::table('products_group')->get();
    return response()->json([
      'status' => 'success',
      'product' => $product,
      
    ]);
  }

  // update product
  public function update_product(Request $request)
  {

    $userId = Auth::id();
    //dd($userId);
    $user = User::where('id', $userId)
    ->where('user_status', 'Active')
    ->first();

    if (!$user) {
     return response()->json([
         'status' => 'error',
         'message' => 'Access denied: user not found',
     ], 403);
 }
    DB::table('products')->where('id', $request->edit_id)->update([
      'group_id' => $request->group_id,
      'name' => $request->name,
      'desc'  => $request->desc,
       'status'  => $request->status,
      'updated_at' => now(),

    ]);

    return response()->json([
      'status' => 'success',
       'message' => 'Product updated successfully'
      
    ]);

    
  }

  public function add_group(Request $req)
  {
    DB::table('products_group')->insert([
      'group_name' => $req->group_name,
      'desc' => $req->group_desc,
      'status' => $req->group_status,
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    
    return response()->json([
      'status' => 'success',
       'message' => 'Product group created successfully'
      
    ]);

  }

  //edit product group

  public function edit_group(Request $req)
  {
    $userId = Auth::id();
    //dd($userId);
    $user = User::where('id', $userId)
    ->where('user_status', 'Active')
    ->first();

    if (!$user) {
     return response()->json([
         'status' => 'error',
         'message' => 'Access denied: user not found',
     ], 403);
 }
    $group_edi = DB::table('products_group')->where('id', $req->group_id)->first();

    return response()->json([
      'status' => 'success',
      'group' => $group_edi,
      
    ]);
  }

  //update product group

  public function update_group(Request $req)
  {

    $userId = Auth::id();
    //dd($userId);
    $user = User::where('id', $userId)
    ->where('user_status', 'Active')
    ->first();

    if (!$user) {
     return response()->json([
         'status' => 'error',
         'message' => 'Access denied: user not found',
     ], 403);
 }
    DB::table('products_group')->where('id', $req->group_id)->update([
      'group_name' => $req->group_name,
      'desc' => $req->group_desc,
      'status' => $req->group_status,
      'updated_at' => now(),
    ]);

    // dd($req);

    return response()->json([
      'status' => 'success',
       'message' => '    Product group updated successfully'
      
    ]);


    // return view('admin.settings.edit_group');
  }

  //user add
  public function add_user(Request  $req)
  {
    $userId = Auth::id();
    //dd($userId);
    $user = User::where('id', $userId)
    ->where('user_status', 'Active')
    ->first();

    if (!$user) {
     return response()->json([
         'status' => 'error',
         'message' => 'Access denied: user not found',
     ], 403);
 }
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

    return response()->json([
      'status' => 'success',
       'message' => 'User created successfully'
      
    ]);

  }

  public function edit_user(Request $req)
  {
    $userId = Auth::id();
    //dd($userId);
    $user = User::where('id', $userId)
    ->where('user_status', 'Active')
    ->first();

    if (!$user) {
     return response()->json([
         'status' => 'error',
         'message' => 'Access denied: user not found',
     ], 403);
 }

    $user_data  = DB::table('users')->where('id', $req->user_id)->first();
    return response()->json([
      'status' => 'success',
       'user' => $user_data
      
    ]);

    //return view('admin.settings.edit_user', ['user_data' => $user_data]);
  }

  //update user

  public function update_user(Request $req)
  {

    $userId = Auth::id();
    //dd($userId);
    $user = User::where('id', $userId)
    ->where('user_status', 'Active')
    ->first();

    if (!$user) {
     return response()->json([
         'status' => 'error',
         'message' => 'Access denied: user not found',
     ], 403);
 }

    DB::table('users')->where('id', $req->user_id)->update([
      'name' => $req->user_name,
      'designation' => $req->user_desig,
      'contact_number' => $req->user_contact,
      'email' => $req->user_mail,
      'password' => $req->user_pass,
      'user_status' => $req->user_status,
      'updated_at' => now(),

    ]);

    return response()->json([
      'status' => 'success',
       'message' => "User updated successfully"
      
    ]);

}

//add category
  public function add_category(Request $request)
  {
      $userId = Auth::id();
      $user = User::where('id', $userId)
      ->where('user_status', 'Active')
      ->first();

          if (!$user) {
          return response()->json([
              'status' => 'error',
              'message' => 'Access denied: user not found',
          ], 403);
        }
        DB::table('category')->insert([
          // 'group_id' => $request->group_id,
          'cat_name' => $request->cat_name,
          'cat_desc'  => $request->cat_desc,
          'status'  => $request->cat_status,
          'created_at' => now(),
          'updated_at' => now(),
        ]);

        return response()->json([
          'status' => 'success',
          'message' => 'Category added Successfuly',
          // 'users' => $users,
         
      ], 200);
  }

  public function edit_category(Request $req )
  {

    $userId = Auth::id();
    //dd($userId);
          $user = User::where('id', $userId)
          ->where('user_status', 'Active')
          ->first();

          if (!$user) {
          return response()->json([
              'status' => 'error',
              'message' => 'Access denied: user not found',
          ], 403);
      }

    $category_data  = DB::table('category')->where('id', $req->category_id)->first();

    return response()->json([
      'status' => 'success',
       'category' => $category_data
      
    ]);

  }

  //update category

  public function update_category(Request $request)
 {

       $userId = Auth::id();
            $user = User::where('id', $userId)
            ->where('user_status', 'Active')
            ->first();

            if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied: user not found',
            ], 403);
        }

      DB::table('category')->where('id', $request->category_id)->update([
        
        'cat_name' => $request->category_name,
        'cat_desc'  => $request->category_desc,
        'status'  => $request->category_status,
        'updated_at' => now(),

      ]);

      return response()->json([
        'status' => 'success',
        'message' => "Category updated successfully"
        
      ]);
  
 }

}
