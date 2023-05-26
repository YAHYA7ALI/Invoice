<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\InvoiceArchiveController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceDetailsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceReport;
use App\Http\Controllers\ReportClients;
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
    return view('auth.login');
});
Route::get('/dashboard', [AdminController::class,'store'], function (){
    //return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth']], function()
{
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::resource('invoices', InvoiceController::class)->only([
    'index','create','store','update','destroy',
]);

Route::resource('sections', SectionController::class)->only([
    'index','create','store','update','destroy',
]);

Route::resource('products', ProductController::class)->only([
    'index','create','store','update','destroy',
]);
Route::resource('InvoiceAttachments', InvoiceAttachmentsController::class)->only([
    'index','create','store','update','destroy',
]);
Route::resource('Archive_Invoices', InvoiceArchiveController::class)->only([
    'index','create','store','update','destroy',
]);
Route::get('ReportInvoic', [InvoiceReport::class,'index']);

Route::post('Search_invoices', [InvoiceReport::class,'SearchInvoic']);

Route::get('CustomerReports', [ReportClients::class, 'index'])->name('CustomerReports');

Route::post('Search_Customer', [ReportClients::class, 'SearchCustomer']);

Route::get('/Print_invoice/{id}', [InvoiceController::class,'Print']);

Route::get('/section/{id}', [InvoiceController::class,'GetProducts']);

Route::get('/InvoicesDetails/{id}', [InvoiceDetailsController::class,'edit']);

Route::get('view_file/{invoice_number}/{file_name}' ,[InvoiceDetailsController::class,'OpenFile']);

Route::get('download/{invoice_number}/{file_name}', [InvoiceDetailsController::class,'GetFile']);

Route::post('delete_file',[InvoiceDetailsController::class,'destroy'])->name('delete_file');

Route::get('/invoices_edit/{id}', [InvoiceController::class,'edit']);

Route::get('/Status_show/{id}', [InvoiceController::class,'show'])->name('Status_show');

Route::post('/Status_Update/{id}', [InvoiceController::class,'StatusUpdate'])->name('Status_Update');

Route::get('invoices_paid', [InvoiceController::class,'Invoices_Paid']);

Route::get('invoices_unpaid', [InvoiceController::class,'Invoices_Unpaid']);

Route::get('invoices_PartiallyPaid', [InvoiceController::class,'Invoices_PartiallyPaid']);

Route::get('MarkAsRead_all', [InvoiceController::class,'MarkAsRead_all'])->name('MarkAsRead_all');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::get('{page}',[AdminController::class,'index']);