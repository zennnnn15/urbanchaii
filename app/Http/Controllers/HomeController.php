<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MilkTeaCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function viewWelcomePage(){
        $user = Auth::guard('customer')->user();
        

    $carts = DB::table('transactions')
        ->join('milk_tea_sizes', 'transactions.milktea_id', '=', 'milk_tea_sizes.id')
        ->join('customers', 'transactions.customer_id', '=', 'customers.id')
        ->select(
            'milk_tea_sizes.name as milktea_size_name',
            'customers.name as customer_name',
            'transactions.*'
        )
        ->where('transactions.customer_id', $user->id) ->where('transactions.status', 1) // Filter by the currently logged-in user's ID
        ->orderBy('transactions.updated_at', 'desc')->get();
 

        $milkteaCategory = MilkTeaCategory::all();
        
      
        return view('customer.welcomepage',compact('milkteaCategory','carts'));
    }

    public function showCart (){
        $user = Auth::guard('customer')->user();


        $carts = DB::table('carts')
            ->join('milk_tea_sizes', 'carts.milktea_id', '=', 'milk_tea_sizes.id')
            ->join('customers', 'carts.customer_id', '=', 'customers.id')
            ->select(
                'milk_tea_sizes.name as milktea_size_name',
                'customers.name as customer_name',
                'carts.*'
            )
            ->where('carts.customer_id', $user->id) ->where('carts.status', 1) // Filter by the currently logged-in user's ID
            ->orderBy('carts.updated_at', 'desc')->get();

        

            $orderedItems = DB::table('transactions')
            ->join('milk_tea_sizes', 'transactions.milktea_id', '=', 'milk_tea_sizes.id')
            ->join('customers', 'transactions.customer_id', '=', 'customers.id')
            ->select(
                'milk_tea_sizes.name as milktea_size_name',
                'customers.name as customer_name',
                'transactions.*'
            )
            ->where('transactions.customer_id', $user->id) ->where('transactions.status', 1) // Filter by the currently logged-in user's ID
            ->orderBy('transactions.updated_at', 'desc')->get();

            $doneItems = DB::table('transactions')
            ->join('milk_tea_sizes', 'transactions.milktea_id', '=', 'milk_tea_sizes.id')
            ->join('customers', 'transactions.customer_id', '=', 'customers.id')
            ->select(
                'milk_tea_sizes.name as milktea_size_name',
                'customers.name as customer_name',
                'transactions.*'
            )
            ->where('transactions.customer_id', $user->id) ->where('transactions.status', 2) // Filter by the currently logged-in user's ID
            ->orderBy('transactions.updated_at', 'desc')->get();
                
                
                
          
           
            return view('customer.my_order',compact('carts','user','orderedItems' ,'doneItems'));
    }

    public function movetotransaction(Request $request){
        $user = Auth::guard('customer')->user();
        $customer = Auth::guard('customer')->user();
        $address = $customer->address;
        $latitude = $customer->latitude;
        $longitude = $customer->longitude;
        $typeofdelivery = $request->input('typeofdelivery');
      
   
        
        // Retrieve items from the cart
        $carts = DB::table('carts')
            ->join('milk_tea_sizes', 'carts.milktea_id', '=', 'milk_tea_sizes.id')
            ->join('customers', 'carts.customer_id', '=', 'customers.id')
            ->select(
                'milk_tea_sizes.name as milktea_size_name',
                'customers.name as customer_name',
                'carts.*'
            )
            ->where('carts.customer_id', $user->id)
            ->where('carts.status', 1) // Filter by the currently logged-in user's ID and cart status
            ->orderBy('carts.updated_at', 'desc')
            ->get();
        
        // Move items to the transactions table
        foreach ($carts as $cartItem) {
            DB::table('transactions')->insert([
                'milktea_id' => $cartItem->milktea_id,
                'customer_id' => $cartItem->customer_id,
                'status' => $cartItem->status,
                'quantity' => $cartItem->quantity,
                'total' => $cartItem->total,
                'address' => $address,
                'latitude'=>$latitude,
                'longitude'=>$longitude,
                'typeofdelivery'=>$typeofdelivery,
                // Add other fields you want to copy from carts to transactions
                'created_at' => now(), // You might want to set the creation date
                'updated_at' => now(), // Set the updated_at timestamp
            ]);
    
            // Optionally, you can also delete these items from the cart after moving them
            DB::table('carts')->where('id', $cartItem->id)->delete();
        }
    
        return redirect()->back(); // Redirect to the previous page or any desired location after the operation
    }
    

}
