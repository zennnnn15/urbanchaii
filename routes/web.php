<?php

use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Features;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\MilkTeaController;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Admin routes
    Route::middleware(['admin'])->group(function () {
        // Define admin-specific routes here
    });

    // Customer routes
    Route::middleware(['customer'])->group(function () {
        // Define customer-specific routes here
    });
});
Route::post('/customer/login', [CustomerAuthController::class, 'login']);
Route::get('/customer/login', [CustomerAuthController::class, 'showLoginForm'])->name('customer.login');
Route::post('/customer/login', [CustomerAuthController::class, 'login']);


Route::get('/welcomepage', [HomeController::class, 'viewWelcomePage'])->name('welcome');



Route::get('/', function () {
    return view('customer.customer_login');
});

use App\Models\Transaction; // Import the Transaction model at the beginning of your file

Route::get('/dashboard', function () {
    $totalSales = Transaction::join('milk_tea_sizes', 'transactions.milktea_id', '=', 'milk_tea_sizes.id')
        ->join('customers', 'transactions.customer_id', '=', 'customers.id')
        ->where('transactions.status', 2) // Filter transactions with status = 2 (Done)
        ->select(
            'milk_tea_sizes.name as milktea_size_name', 
            'customers.name as customer_name', 
            'transactions.*'
        )
        ->orderBy('transactions.updated_at', 'desc')
        ->get();


        $recentOrders = Transaction::join('milk_tea_sizes', 'transactions.milktea_id', '=', 'milk_tea_sizes.id')
        ->join('customers', 'transactions.customer_id', '=', 'customers.id')
        ->where('transactions.status', 2) // Filter transactions with status = 2 (Done)
        ->select(
            'milk_tea_sizes.name as milktea_size_name', 
            'customers.name as customer_name', 
            'transactions.*'
        )
        ->orderBy('transactions.updated_at', 'desc')
        ->limit(5) // Limit the results to the latest 5 records
        ->get();


    return view('dashboard', compact('totalSales','recentOrders'));
})->middleware(['auth'])->name('dashboard');





//Customer Login


Route::get('/customer/login', [CustomerLoginController::class, 'showLoginForm'])->name('customer.login');
Route::get('/customer/signup', [CustomerLoginController::class, 'showCustomerCreate'])->name('signup.customer');
Route::post('/customer/trysignup', [CustomerLoginController::class, 'tryshowCustomerCreate'])->name('try.signup.customer');


Route::post('/customer/login', [CustomerLoginController::class, 'login'])->name('tryCustomerLogin');
Route::post('/customer/logout', [CustomerLoginController::class, 'logout'])->name('customer.logout');
Route::get('/customer/menu', [CustomerLoginController::class, 'showMenu'])->name('customer.menu');
Route::get('/customer/menu/category/{id}', [CustomerLoginController::class, 'categoryShow'])->name('customer.categoryShow');
//add to cart
Route::get('/customer/menu/category/milktea/{id}', [CustomerLoginController::class, 'milkteaSizes'])->name('cart.add');
Route::get('/customer/carts', [HomeController::class, 'showCart'])->name('cart.show');
Route::get('/customer/transaction', [HomeController::class, 'movetotransaction'])->name('checkoutw');










require __DIR__.'/auth.php';


//MilkTa Category Admin
use App\Http\Controllers\MilkTeaCategoryController;

Route::get('/milktea/categories', [MilkTeaCategoryController::class, 'index'])->name('milktea.categories.index');
Route::get('/milktea/categories/create', [MilkTeaCategoryController::class, 'create'])->name('milktea.categories.create');
Route::post('/milktea/categories', [MilkTeaCategoryController::class, 'store'])->name('milktea.categories.store');
Route::get('/milktea/categories/{category}/edit', [MilkTeaCategoryController::class, 'edit'])->name('milktea.categories.edit');
Route::put('/milktea/categories/{category}', [MilkTeaCategoryController::class, 'update'])->name('milktea.categories.update');
Route::delete('/milktea/categories/{category}', [MilkTeaCategoryController::class, 'destroy'])->name('milktea.categories.destroy');


Route::resource('milktea', MilkTeaController::class);

use App\Http\Controllers\MilkteaSizeMilkteaController;
Route::resource('milkteasize', MilkteaSizeMilkteaController::class);
Route::delete('/milkteasize/{id}', [MilkteaSizeMilkteaController::class, 'destroy'])->name('milkteasize.destroy');
// Route::get('milkteasize/create/{id}', [MilkteaSizeMilkteaController::class,'create'])->name('newmilktea');
Route::get('/milkteasize/create/{milktea}', [MilkteaSizeMilkteaController::class, 'create'])->name('milkteasize.create');
Route::get('/milkteasize/manage/{milktea}', [MilkteaSizeMilkteaController::class, 'manage'])->name('milkteasize.manage');

use App\Http\Controllers\MilkteaSizeController;
Route::resource('milkteaInSize', MilkteaSizeController::class);
Route::get('/milkteaInSize/index', [MilkteaSizeController::class, 'index'])->name('milkteaInSize');
Route::get('/milkteaInSize/index/{milkteaSize}', [MilkteaSizeMilkteaController::class, 'manage'])->name('milkteaInSize.manage.me');
Route::get('/milkteaInSize/{id}', 'MilkteaSizeController@show')->name('milkteaInSize.show');
Route::get('/milkteaInSize/{id}/edit', 'MilkteaSizeController@edit')->name('milkteaInSize.edit');
Route::delete('/milkteaInSize/{milkteaSize}', 'MilkteaSizeController@destroy')->name('milkteaInSize.destroy');




use App\Http\Controllers\TransactionController;
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/transaction/currents', [TransactionController::class, 'currentOrders'])->name('transactions.current');
Route::get('/sales', [TransactionController::class, 'salesReport'])->name('sales.report');
Route::get('/sales/filtered', [TransactionController::class, 'filteredSold'])->name('salesfiltered.report');
Route::patch('/transactions/{transaction}', [TransactionController::class, 'updateStatus'])->name('transactions.updateStatus');
Route::post('/checkout', [TransactionController::class, 'sendorder'])->name('checkout.store');
Route::get('/customer/tra', [TransactionController::class, 'sendToTransactions'])->name('send.to.transaction');
// web.php or routes.php
Route::delete('/remove-from-cart/{milkteaId}', [TransactionController::class, 'removeFromCart']);
Route::get('/transactions/view/{transactionId}', [TransactionController::class, 'viewTransaction'])->name('viewTransaction');
