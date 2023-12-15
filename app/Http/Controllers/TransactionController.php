<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\MilkTeaSize;
use App\Models\Cart;
use App\Models\MilkTea;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{

    public function sendorder(Request $request)
    {
   

        logger($request->milktea_id);
        $add = '';
        // Validate form data
        $request->validate([
            'milktea_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            'status' => 'required|numeric',
            'customer' => 'required|numeric',
            'comments' => 'required|in:cash_on_delivery,pick_up',
        ]);
        
        $milktea = MilkTeaSize::find($request->milktea_id);
        if (!$milktea) {
            // Handle the case where MilkTea with the given ID is not found
            abort(404, 'MilkTea not found');
        }
        $totalPrice = $milktea->price * $request->quantity;
    
        // // Add extra charge if payment method is 'cash_on_delivery'
        // if ($request->comments === 'cash_on_delivery') {
        //     $totalPrice += 40;
        // }
    
        Cart::create([
            'milktea_id' => $request->milktea_id, // Include milktea_id in the insertion process
            'status' => $request->status,
            'quantity' => $request->quantity,
            'total' => $totalPrice,
            'customer_id' => $request->customer,
            'comment' => $request->comments,
            'address'=>$add,
        ]);
        
        
        return response()->json(['message' => 'Order placed successfully'], 200);
    }
    public function sendToTransactions(Request $request)
    {
     
    $address = $request->query('address');
    dd($address);


    }
    

    public function index()
    {
        $transactions = DB::table('transactions')
        ->join('milk_tea_sizes', 'transactions.milktea_id', '=', 'milk_tea_sizes.id')
        ->join('customers', 'transactions.customer_id', '=', 'customers.id')
        ->select(
            'milk_tea_sizes.name as milktea_size_name', 
            'customers.name as customer_name', 
            'transactions.*'
        )
        ->orderBy('transactions.updated_at', 'desc') // Sort by updated_at column in descending order
        ->paginate(10); // Paginate the results, displaying 10 records per page

    

                
            
        return view('transactions.index', compact('transactions'));
    }



    public function currentOrders()
    {
        $transactions = DB::table('transactions')
            ->join('milk_tea_sizes', 'transactions.milktea_id', '=', 'milk_tea_sizes.id')
            ->join('customers', 'transactions.customer_id', '=', 'customers.id')
            ->where('transactions.status', 1) // Filter transactions with status = 1
            ->select(
                'milk_tea_sizes.name as milktea_size_name', 
                'customers.name as customer_name', 
                'transactions.*'
            )
            ->orderBy('transactions.updated_at', 'desc')
            ->paginate(10);
    
        return view('transactions.current_orders', compact('transactions'));
    }
    


    public function filteredSold(Request $request)
    {
        $filter = $request->query('filter');
        $endDate = now();
        $startDate = null;
    
        if ($filter === 'week') {
            $startDate = now()->startOfWeek();
        } elseif ($filter === 'month') {
            $startDate = now()->startOfMonth();
        }
        elseif ($filter === 'all') {
            $startDate = null;
            $endDate = now();
        } elseif ($filter === 'day') {
            $startDate = now()->startOfDay();
        } elseif ($filter === 'today') {
            $startDate = now()->startOfDay();
            $endDate = now()->endOfDay();
        }
        $filteredSales = Transaction::where('transactions.status', 2)
        ->when($startDate, function ($query) use ($startDate, $endDate) {
            return $query->whereBetween('transactions.updated_at', [$startDate, $endDate]);
        })
        ->join('milk_tea_sizes', 'transactions.milktea_id', '=', 'milk_tea_sizes.id')
        ->join('customers', 'transactions.customer_id', '=', 'customers.id')
        ->select(
            'milk_tea_sizes.name as milktea_size_name',
            'customers.name as customer_name',
            'transactions.*'
        )
        ->orderBy('transactions.updated_at', 'desc')
        ->get();
    
    
        // Calculate total sales amount from $filteredSales
        $totalAmount = $filteredSales->sum('total');
    
        return view('transactions.filtered', ['filteredSales' => $filteredSales, 'totalSales' => $totalAmount]);
    }
    
    
    
 
    public function salesReport()
    {
        $totalSales = DB::table('transactions')
            ->join('milk_tea_sizes', 'transactions.milktea_id', '=', 'milk_tea_sizes.id')
            ->join('customers', 'transactions.customer_id', '=', 'customers.id')
            ->where('transactions.status', 2) // Filter transactions with status = 2 (Done)
            ->select(
                'milk_tea_sizes.name as milktea_size_name', 
                'customers.name as customer_name', 
                'transactions.*'
            )
            ->orderBy('transactions.updated_at', 'desc')
            ->paginate(10);

            $totalAmount = DB::table('transactions')
            ->where('status', 2)
            ->sum('total');
       

        return view('transactions.sold_milktea', compact('totalSales','totalAmount'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:1,2,3', // Ensure the status is one of the allowed values (1, 2, or 3)
        ]);
    
        $transaction->update([
            'status' => $request->status,
        ]);
    
        $transactions = DB::table('transactions')
        ->join('milk_tea_sizes', 'transactions.milktea_id', '=', 'milk_tea_sizes.id')
        ->join('customers', 'transactions.customer_id', '=', 'customers.id')
        ->select(
            'milk_tea_sizes.name as milktea_size_name', 
            'customers.name as customer_name', 
            'transactions.*'
        )
        ->orderBy('transactions.updated_at', 'desc') // Sort by updated_at column in descending order
        ->paginate(10); // Paginate the results, displaying 10 records per page
    
    
    
        return response()->json(['message' => 'Status updated successfully', 'transactions' => $transactions]);
    }

    public function passtoTransaction(Request $request)
    {
   

        logger($request->milktea_id);
        $add = '';
        // Validate form data
        $request->validate([
            'milktea_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            'status' => 'required|numeric',
            'customer' => 'required|numeric',
            'comments' => 'required|in:cash_on_delivery,pick_up',
        ]);
        
        $milktea = MilkTeaSize::find($request->milktea_id);
        if (!$milktea) {
            // Handle the case where MilkTea with the given ID is not found
            abort(404, 'MilkTea not found');
        }
        $totalPrice = $milktea->price * $request->quantity;
        if ($request->comments === 'cash_on_delivery') {
            $totalPrice += 40;
        }
    }


    // CartController.php
public function removeFromCart($milkteaId)
{
    // Perform the removal logic from the database based on $milkteaId

    // For example:
    Cart::where('milktea_id', $milkteaId)->delete();

    return response()->json(['message' => 'Item removed successfully']);
}


public function viewTransaction(Request$request){
    $id = $request ->transactionId;
    $transactions = DB::table('transactions')
    ->join('milk_tea_sizes', 'transactions.milktea_id', '=', 'milk_tea_sizes.id')
    ->join('customers', 'transactions.customer_id', '=', 'customers.id')
    ->where('transactions.id', $id) // Filter transactions with status = 1
    ->select(
        'milk_tea_sizes.name as milktea_size_name', 
        'customers.name as customer_name', 
        'transactions.*'
    )
    ->orderBy('transactions.updated_at', 'desc')
    ->first();
   
    
    return view('transactions.viewOrder',compact('transactions'));
}
    
    

    
}
