<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class ApiLoginController extends Controller
{

    //login method
    public function login(Request $request)
    {
        $request->validate([
            'contact_number' => 'required',
            'password' => 'required',
            'fcm_token' => 'required',
        ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 'error',
        //         'errors' => $validator->errors(),
        //     ], 422);
        // }

        $user = User::where('contact_number', $request->contact_number)->first();

        
        if (!$user || $request->password !== $user->password) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
            ], 401);
        }
        $token = $user->createToken('enquiry')->plainTextToken;

        $user->device_token = $request->fcm_token;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'token' => $token,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'role'=>$user->designation
            ]
        ], 200);
    }

    public function sales_dashboard(Request $request)
    {
        $userId = Auth::id();
       // dd($userId);
       $user = User::where('id', $userId)
       ->where('user_status', 'Active')
       ->first();

       if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'Access denied: Not an employee',
        ], 403);
    }

        $enquiry_received_count = DB::table('enquiry')
        // ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Enquiry Received')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('enquiry.created_at', date('m'))
                  ->whereYear('enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('enquiry.status', 'pending');
                //   ->whereMonth('enquiry.created_at', date('m'))
                //   ->whereYear('enquiry.created_at', date('Y'));
            });
        })
        ->count();
       

        $inital_contact_count = DB::table('enquiry')
        // ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Initial Contact')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('enquiry.created_at', date('m'))
                  ->whereYear('enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('enquiry.status', 'pending');
                //   ->whereMonth('enquiry.created_at', date('m'))
                //   ->whereYear('enquiry.created_at', date('Y'));
            });
        })
        ->count();

        $requirement_gathering_count = DB::table('enquiry')
        ->where('lead_cycle', 'Requirement Gathering')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('enquiry.created_at', date('m'))
                  ->whereYear('enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('enquiry.status', 'pending');
                //   ->whereMonth('enquiry.created_at', date('m'))
                //   ->whereYear('enquiry.created_at', date('Y'));
            });
        })
        ->count();

       

        $product_selection_count = DB::table('enquiry')
        ->where('lead_cycle', 'Product Selection')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('enquiry.created_at', date('m'))
                  ->whereYear('enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('enquiry.status', 'pending');
                //   ->whereMonth('enquiry.created_at', date('m'))
                //   ->whereYear('enquiry.created_at', date('Y'));
            });
        })
        ->count();

        $qutation_preparation_count = DB::table('enquiry')
        ->where('lead_cycle', 'Quotation Preparation')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('enquiry.created_at', date('m'))
                  ->whereYear('enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('enquiry.status', 'pending');
                //   ->whereMonth('enquiry.created_at', date('m'))
                //   ->whereYear('enquiry.created_at', date('Y'));
            });
        })
        ->count();

        $qutation_submission_count = DB::table('enquiry')
        ->where('lead_cycle', 'Quotation')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('enquiry.created_at', date('m'))
                  ->whereYear('enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('enquiry.status', 'pending');
                //   ->whereMonth('enquiry.created_at', date('m'))
                //   ->whereYear('enquiry.created_at', date('Y'));
            });
        })
        ->count();

        $follow_up_count = DB::table('enquiry')
        ->where('lead_cycle', 'Follow-up')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('enquiry.created_at', date('m'))
                  ->whereYear('enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('enquiry.status', 'pending');
                //   ->whereMonth('enquiry.created_at', date('m'))
                //   ->whereYear('enquiry.created_at', date('Y'));
            });
        })
        ->count();

        $order_confirmed_count = DB::table('enquiry')
        ->where('lead_cycle', 'Order confimred')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('enquiry.created_at', date('m'))
                  ->whereYear('enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('enquiry.status', 'pending');
                //   ->whereMonth('enquiry.created_at', date('m'))
                //   ->whereYear('enquiry.created_at', date('Y'));
            });
        })
        ->count();

        $supplied_partial_count = DB::table('enquiry')
        ->where('lead_cycle', 'Material supplied partially')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('enquiry.created_at', date('m'))
                  ->whereYear('enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('enquiry.status', 'pending');
                //   ->whereMonth('enquiry.created_at', date('m'))
                //   ->whereYear('enquiry.created_at', date('Y'));
            });
        })
        ->count();

        $supplied_final_count = DB::table('enquiry')
        ->where('lead_cycle', 'Material supplied final-full')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('enquiry.created_at', date('m'))
                  ->whereYear('enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('enquiry.status', 'pending');
                //   ->whereMonth('enquiry.created_at', date('m'))
                //   ->whereYear('enquiry.created_at', date('Y'));
            });
        })
        ->count();

        $payment_received_partial_count = DB::table('enquiry')
        ->where('lead_cycle', 'Payment received partial')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('enquiry.created_at', date('m'))
                  ->whereYear('enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('enquiry.status', 'pending');
                //   ->whereMonth('enquiry.created_at', date('m'))
                //   ->whereYear('enquiry.created_at', date('Y'));
            });
        })
        ->count();

        $payment_received_final_count = DB::table('enquiry')
        ->where('lead_cycle', 'Payment received final-full')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('enquiry.created_at', date('m'))
                  ->whereYear('enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('enquiry.status', 'pending');
                //   ->whereMonth('enquiry.created_at', date('m'))
                //   ->whereYear('enquiry.created_at', date('Y'));
            });
        })
        ->count();

        $final_decision_count = DB::table('enquiry')
        ->where('lead_cycle', 'Final Decision')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('enquiry.created_at', date('m'))
                  ->whereYear('enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('enquiry.status', 'pending');
                //   ->whereMonth('enquiry.created_at', date('m'))
                //   ->whereYear('enquiry.created_at', date('Y'));
            });
        })

        ->count();

    

        $cancel_count = DB::table('enquiry')
        ->where('lead_cycle', 'Cancelled')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('enquiry.created_at', date('m'))
                  ->whereYear('enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('enquiry.status', 'pending');
                //   ->whereMonth('enquiry.created_at', date('m'))
                //   ->whereYear('enquiry.created_at', date('Y'));
            });
        })
        ->count();

        // $totalEnquiries = DB::table('enquiry')
        // ->when($user->designation !== 'Admin', function ($query) use ($user) {
        //     $query->where('assign_to', $user->id);
        // })
        // ->where(function ($query) {
        //     $query->whereIn('enquiry.status', ['completed', 'cancelled'])
        //         ->whereMonth('enquiry.created_at', date('m'))
        //         ->whereYear('enquiry.created_at', date('Y'));
        // })
        // ->orWhere('enquiry.status', 'pending')
        // ->count();

        $totalEnquiries = DB::table('enquiry')
    ->when($user->designation !== 'Admin', function ($query) use ($user) {
        $query->where('assign_to', $user->id);
    })
    ->where(function ($query) {
        $query->where(function ($q) {
            $q->whereIn('enquiry.status', ['completed', 'cancelled'])
              ->whereMonth('enquiry.created_at', date('m'))
              ->whereYear('enquiry.created_at', date('Y'));
        })
        ->orWhere(function ($q) {
            $q->where('enquiry.status', 'pending');
            //   ->whereMonth('enquiry.created_at', date('m'))
            //   ->whereYear('enquiry.created_at', date('Y'));
        });
    })
    ->count();

       

        return response()->json([ 
            'status' => 'success',
            'message' => 'Sales Dashboard',
            'total_enquiry_count'=>$totalEnquiries,
            'enquiry_received_count' => $enquiry_received_count,
            'inital_contact_count' => $inital_contact_count,
            'requirement_gathering_count' => $requirement_gathering_count,
            'product_selection_count' => $product_selection_count,
            'qutation_preparation_count' => $qutation_preparation_count,
            'qutation_submission_count' => $qutation_submission_count,
            'follow_up_count' => $follow_up_count,
            'order_confirmed_count' => $order_confirmed_count,
            

            'supplied_partial_count' => $supplied_partial_count,
            'supplied_final_count' => $supplied_final_count,
            'payment_received_partial_count' => $payment_received_partial_count,
            'payment_received_final_count' => $payment_received_final_count,
            'final_decision_count' => $final_decision_count,
            'cancel_count' => $cancel_count,

           
            // 'data' => [
            //     'id' => $user->id,
                
            // ]
        ], 200);
        // //contractor
        // $contractor_total=UserDetail::where('as_a','=','Contractor')->where('ref_id','=',$user->code)->count();
        // $today_contractor_count = UserDetail::where('as_a', 'Contractor')
        //                 ->where('ref_id', $user->code)
        //                 ->whereDate('created_at', Carbon::today()) // only today’s date
        //                 ->count();

    }


    //

    public function service_dashboard(Request $request)
    {
        $userId = Auth::id();
       // dd($userId);
       $user = User::where('id', $userId)
      ->where('user_status', 'Active')
       ->first();

       if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'Access denied: user not found',
        ], 403);

    }

   

        $enquiry_received_count = DB::table('service_enquiry')
        ->where('lead_cycle', 'Enquiry Received')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('service_enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('service_enquiry.created_at', date('m'))
                  ->whereYear('service_enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('service_enquiry.status', 'pending');
                //   ->whereMonth('service_enquiry.created_at', date('m'))
                //   ->whereYear('service_enquiry.created_at', date('Y'));
            });
        })
        ->count();

        $inital_contact_count = DB::table('service_enquiry')
        ->where('lead_cycle', 'Initial Contact')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('service_enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('service_enquiry.created_at', date('m'))
                  ->whereYear('service_enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('service_enquiry.status', 'pending');
                //   ->whereMonth('service_enquiry.created_at', date('m'))
                //   ->whereYear('service_enquiry.created_at', date('Y'));
            });
        })
        ->count();

        $requirement_gathering_count = DB::table('service_enquiry')
        ->where('lead_cycle', 'Requirement Gathering')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('service_enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('service_enquiry.created_at', date('m'))
                  ->whereYear('service_enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('service_enquiry.status', 'pending');
                //   ->whereMonth('service_enquiry.created_at', date('m'))
                //   ->whereYear('service_enquiry.created_at', date('Y'));
            });
        })
        ->count();

       

        $product_selection_count = DB::table('service_enquiry')
        ->where('lead_cycle', 'Product Selection')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('service_enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('service_enquiry.created_at', date('m'))
                  ->whereYear('service_enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('service_enquiry.status', 'pending');
                //   ->whereMonth('service_enquiry.created_at', date('m'))
                //   ->whereYear('service_enquiry.created_at', date('Y'));
            });
        })
        ->count();

        $qutation_preparation_count = DB::table('service_enquiry')
        ->where('lead_cycle', 'Quotation Preparation')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('service_enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('service_enquiry.created_at', date('m'))
                  ->whereYear('service_enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('service_enquiry.status', 'pending');
                //   ->whereMonth('service_enquiry.created_at', date('m'))
                //   ->whereYear('service_enquiry.created_at', date('Y'));
            });
        })
        ->count();

        $qutation_submission_count = DB::table('service_enquiry')
        ->where('lead_cycle', 'Quotation')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('service_enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('service_enquiry.created_at', date('m'))
                  ->whereYear('service_enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('service_enquiry.status', 'pending');
                //   ->whereMonth('service_enquiry.created_at', date('m'))
                //   ->whereYear('service_enquiry.created_at', date('Y'));
            });
        })
        ->count();

        $follow_up_count = DB::table('service_enquiry')
        ->where('lead_cycle', 'Follow-up')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('service_enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('service_enquiry.created_at', date('m'))
                  ->whereYear('service_enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('service_enquiry.status', 'pending');
                //   ->whereMonth('service_enquiry.created_at', date('m'))
                //   ->whereYear('service_enquiry.created_at', date('Y'));
            });
        })
        ->count();

        $service_entry_count = DB::table('service_enquiry')
        ->where('lead_cycle', 'Service Entry')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('service_enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('service_enquiry.created_at', date('m'))
                  ->whereYear('service_enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('service_enquiry.status', 'pending');
                //   ->whereMonth('service_enquiry.created_at', date('m'))
                //   ->whereYear('service_enquiry.created_at', date('Y'));
            });
        })
        ->count();


        $order_confirmed_count = DB::table('service_enquiry')
        ->where('assign_to', $user->id)
        ->where('lead_cycle', 'Order confimred')
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('service_enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('service_enquiry.created_at', date('m'))
                  ->whereYear('service_enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('service_enquiry.status', 'pending');
                //   ->whereMonth('service_enquiry.created_at', date('m'))
                //   ->whereYear('service_enquiry.created_at', date('Y'));
            });
        })
        ->count();

        $supplied_partial_count = DB::table('service_enquiry')
        ->where('lead_cycle', 'Material supplied partially')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('service_enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('service_enquiry.created_at', date('m'))
                  ->whereYear('service_enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('service_enquiry.status', 'pending');
                //   ->whereMonth('service_enquiry.created_at', date('m'))
                //   ->whereYear('service_enquiry.created_at', date('Y'));
            });
        })
        ->count();

        $supplied_final_count = DB::table('service_enquiry')
        ->where('lead_cycle', 'Material supplied final-full')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('service_enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('service_enquiry.created_at', date('m'))
                  ->whereYear('service_enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('service_enquiry.status', 'pending');
                //   ->whereMonth('service_enquiry.created_at', date('m'))
                //   ->whereYear('service_enquiry.created_at', date('Y'));
            });
        })
        ->count();

        $payment_received_partial_count = DB::table('service_enquiry')
        ->where('lead_cycle', 'Payment received partial')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('service_enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('service_enquiry.created_at', date('m'))
                  ->whereYear('service_enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('service_enquiry.status', 'pending');
                //   ->whereMonth('service_enquiry.created_at', date('m'))
                //   ->whereYear('service_enquiry.created_at', date('Y'));
            });
        })
        ->count();

        $payment_received_final_count = DB::table('service_enquiry')
        ->where('lead_cycle', 'Payment received final-full')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('service_enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('service_enquiry.created_at', date('m'))
                  ->whereYear('service_enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('service_enquiry.status', 'pending');
                //   ->whereMonth('service_enquiry.created_at', date('m'))
                //   ->whereYear('service_enquiry.created_at', date('Y'));
            });
        })
        ->count();

        $final_decision_count = DB::table('service_enquiry')
        ->where('lead_cycle', 'Final Decision')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('service_enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('service_enquiry.created_at', date('m'))
                  ->whereYear('service_enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('service_enquiry.status', 'pending');
                //   ->whereMonth('service_enquiry.created_at', date('m'))
                //   ->whereYear('service_enquiry.created_at', date('Y'));
            });
        })
        ->count();


        $cancel_count = DB::table('service_enquiry')
        ->where('lead_cycle', 'Cancelled')
        ->when($user->designation !== 'Admin', function ($query) use ($user) {
            $query->where('assign_to', $user->id);
        })
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereIn('service_enquiry.status', ['completed', 'cancelled'])
                  ->whereMonth('service_enquiry.created_at', date('m'))
                  ->whereYear('service_enquiry.created_at', date('Y'));
            })
            ->orWhere(function ($q) {
                $q->where('service_enquiry.status', 'pending');
                //   ->whereMonth('service_enquiry.created_at', date('m'))
                //   ->whereYear('service_enquiry.created_at', date('Y'));
            });
        })
        ->count();

        // $totalEnquiries = DB::table('service_enquiry')
        // ->where(function ($query) {
        //     $query->whereIn('service_enquiry.status', ['completed', 'cancelled'])
        //         ->whereMonth('service_enquiry.created_at', date('m'))
        //         ->whereYear('service_enquiry.created_at', date('Y'));
        // })
        // ->orWhere('service_enquiry.status', 'pending')
        // ->when($user->designation !== 'Admin', function ($query) use ($user) {
        //     $query->where('assign_to', $user->id);
        // })
        // ->count();

        $totalEnquiries = DB::table('service_enquiry')
    ->when($user->designation !== 'Admin', function ($query) use ($user) {
        $query->where('assign_to', $user->id);
    })
    ->where(function ($query) {
        $query->where(function ($q) {
            $q->whereIn('service_enquiry.status', ['completed', 'cancelled'])
              ->whereMonth('service_enquiry.created_at', date('m'))
              ->whereYear('service_enquiry.created_at', date('Y'));
        })
        ->orWhere(function ($q) {
            $q->where('service_enquiry.status', 'pending');
            //   ->whereMonth('service_enquiry.created_at', date('m'))
            //   ->whereYear('service_enquiry.created_at', date('Y'));
        });
    })
    ->count();



    

        // $cancel_count = DB::table('enquiry')
        // ->where('assign_to', $user->id)
        // ->where('lead_cycle', 'Cancelled')
        // ->count();

       

        return response()->json([ 
            'status' => 'success',
            'message' => 'Service Dashboard',
            'total_enquiry_count'=>$totalEnquiries,
            'enquiry_received_count' => $enquiry_received_count,
            'inital_contact_count' => $inital_contact_count,
            'requirement_gathering_count' => $requirement_gathering_count,
            'product_selection_count' => $product_selection_count,
            'qutation_preparation_count' => $qutation_preparation_count,
            'qutation_submission_count' => $qutation_submission_count,
            'follow_up_count' => $follow_up_count,
            'service_entry_count' => $service_entry_count,
            'order_confirmed_count' => $order_confirmed_count,
            

            'supplied_partial_count' => $supplied_partial_count,
            'supplied_final_count' => $supplied_final_count,
            'payment_received_partial_count' => $payment_received_partial_count,
            'payment_received_final_count' => $payment_received_final_count,
            'final_decision_count' => $final_decision_count,
             'cancel_count' => $cancel_count,

           
            // 'data' => [
            //     'id' => $user->id,
                
            // ]
        ], 200);
        // //contractor
        // $contractor_total=UserDetail::where('as_a','=','Contractor')->where('ref_id','=',$user->code)->count();
        // $today_contractor_count = UserDetail::where('as_a', 'Contractor')
        //                 ->where('ref_id', $user->code)
        //                 ->whereDate('created_at', Carbon::today()) // only today’s date
        //                 ->count();

    }

    public function users_list(Request $request)
    {
       $users = DB::table('users')->where('user_status', 'Active')->get();

       return response()->json([
        'status' => 'success',
        'message' => 'User details',
        'users' => $users,
       
    ], 200);

    }

   

  
  public function product_filter_list(Request $req)
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
      try {
          $products = DB::table('products')
              ->where('status', 'Active')
              ->select('id', 'name')
              ->orderBy('id', 'ASC')
              ->get();
  
          return response()->json([
              'status' => 'success',
              'data' => $products
          ], 200);
  
      } catch (\Exception $e) {
          return response()->json([
              'status' => 'error',
              'message' => 'Failed to fetch products',
              'error' => $e->getMessage()
          ], 500);
      }
  }

  public function notification_list(Request $req)
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
      try {
          $notifify = DB::table('notification')
              ->where('assign_user_id', $user->id)
            //   ->select('id', 'name')
              ->orderBy('id', 'DESC')
              ->get();
  
          return response()->json([
              'status' => 'success',
              'notification_list' => $notifify
          ], 200);
  
      } catch (\Exception $e) {
          return response()->json([
              'status' => 'error',
              'message' => 'Failed to fetch products',
              'error' => $e->getMessage()
          ], 500);
      }
  }
  
  

  
    
}




   


