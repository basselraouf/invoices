<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Customers_Report;
use App\Http\Controllers\InvoiceArchiveController;
use App\Http\Controllers\Invoices_Report;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use App\Models\Invoices;
use App\Models\Invoices_details;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




Route::middleware(['Auth'])->group(function () {
    
    Route::get('/invoices',[InvoicesController::class, 'index']);

    Route::resource('/sections',SectionController::class);
    
    Route::resource('/products',ProductController::class);

    Route::resource('/invoices', InvoicesController::class);

    Route::get('/invoices/create', [InvoicesController::class,'create']);

    Route::get('/edit_invoice/{id}', [InvoicesController::class,'edit']);

    Route::get('/section/{id}', [InvoicesController::class,'getproducts']);

    Route::get('/Status_show/{id}', [InvoicesController::class,'show'])->name('Status_show');

    Route::post('/Status_Update/{id}', [InvoicesController::class,'Status_Update'])->name('Status_Update');

    Route::get('/Paid_invoices', [InvoicesController::class,'Paid_invoices']);

    Route::get('/Unpaid_invoices', [InvoicesController::class,'Unpaid_invoices']);

    Route::get('/Partial_invoices', [InvoicesController::class,'Partial_invoices']);

    Route::resource('/Archive', InvoiceArchiveController::class);

    Route::get('/InvoicesDetails/{id}', [InvoicesDetailsController::class,'edit']);

    Route::get('download/{invoice_number}/{file_name}', [InvoicesDetailsController::class,'get_file']);

    Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class,'open_file']);
   
    Route::post('delete_file', [InvoicesDetailsController::class, 'destroy'])->name('delete_file');

    Route::resource('roles',RoleController::class);
    
    Route::resource('users',UserController::class);

    Route::get('export_invoices', [InvoicesController::class, 'export']);

    Route::get('/invoices_report',[Invoices_Report::class, 'index']);

    Route::post('/Search_invoices',[Invoices_Report::class, 'Search_invoices']);

    Route::get('/customers_report',[Customers_Report::class, 'index']);

    Route::post('/Search_customers',[Customers_Report::class, 'Search_customers']);

    Route::get('MarkAsRead_all',[InvoicesController::class, 'MarkAsRead_all'])->name('MarkAsRead_all');

    Route::get('/{page}', [AdminController::class,'index']);
 

});

