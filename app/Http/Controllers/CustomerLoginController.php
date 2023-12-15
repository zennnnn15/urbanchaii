<?php

namespace App\Http\Controllers;
use App\Customer;
use App\Models\Customer as ModelsCustomer;
use App\Models\MilkTeaCategory;
use Illuminate\Http\Request;
use App\Models\MilkTea;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('customer.customer_login');
    }

    //show menu
    public function showMenu()
    {
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
        $milkteaCategory = MilkTeaCategory::all();
        
        return view('customer.welcomepage',compact('milkteaCategory','carts'));
    }
    
    public function categoryShow($id)
    {
        $milktea = DB::table('milk_teas')->where('milktea_category_id', $id)->get();
    
        if ($milktea) {
            return view('customer.checkout.milktea_view_bycategory',compact('milktea'));
        } else {
            // Handle the case where the milk tea with the given ID is not found
            abort(404, 'Milk Tea not found');
        }
    }
    public function milkteaSizes($id)
    {
        $customer = auth('customer')->user();      
        //query
        $milkteasize = DB::table('milktea_size_milktea')->where('milktea_id', $id)->first();
        $milkteasizeGet = DB::table('milktea_size_milktea')->where('milktea_id', $id)->get();
        $getArray = $milkteasizeGet->pluck('milktea_size_id');
        
        if ($milkteasize) {
            //get milktea_size_id
            $milkteaSizeId = $milkteasize->milktea_size_id;
             //get milktea_id
            $getImage = $milkteasize->milktea_id;
            $milkteaSizeIds = $milkteasize->milktea_id;
            $getMilktea = DB::table('milk_teas')->where('id',$getImage)->first();
            $getArray = $milkteasizeGet->pluck('milktea_size_id');
            $milkteasizesAvailable = DB::table('milk_tea_sizes')->whereIn('id', $getArray)->get();
            $getID = DB::table('milktea_size_milktea')->where('milktea_id', $id)->get();
            
            return view('customer.checkout.milkteaSize', compact('milkteasizesAvailable','getMilktea','customer'));
        } else {
            // Handle the case where the milk tea with the given ID is not found
            abort(404, 'Milk Tea not found');
        }
    }
    

    public function login(Request $request)
    {
        // Validation logic for email and password
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Authenticate the customer
        $credentials = $request->only('email', 'password');
        
        if (auth('customer')->attempt($credentials)) {
            //test case 1 - success
            //change to main menu
            return redirect()->route('customer.menu');
        }
        

        // Authentication failed, redirect back with an error message
        return redirect()->route('customer.login')->with('error', 'Invalid email or password');
    }

    public function logout()
    {
        // Logout the authenticated customer
        Auth::guard('customer')->logout();

        // Redirect to the customer login page
        return redirect()->route('customer.login');
    }
    

    public function showCustomerCreate(){

        return view('customer.customer_register');
    }

    public function tryshowCustomerCreate(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'address' => 'nullable'
            // Add other validation rules as needed for the remaining fields
        ]);
    
        // Create a new Customer instance
        $customer = new ModelsCustomer();
        $customer->name = $data['name'];
        $customer->email = $data['email'];
        $customer->address = $data['address'];
        $customer->password = bcrypt($data['password']); // Make sure to hash the password
    
        // Set latitude and longitude if provided
        if (isset($data['latitude'])) {
            $customer->latitude = $data['latitude'];
        }
        if (isset($data['longitude'])) {
            $customer->longitude = $data['longitude'];
        }
    
        // Save the new customer to the database
        $customer->save();
    
        // Optionally, you can return a response or redirect somewhere
        return redirect()->route('customer.login');
    }
}
