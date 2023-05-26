<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Invoice_Attachments;
use App\Models\Invoice_Details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice_Details $invoice_Details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)

    {
        $invoices = Invoice::where('id',$id)->first();
        $details  = Invoice_Details::where('id_Invoice',$id)->get();
        $attachments  = Invoice_Attachments::where('invoice_id',$id)->get();

        return view('Invoices.details_invoices',compact('invoices','details','attachments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice_Details $invoice_Details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $invoices = Invoice_Attachments::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    public function GetFile($invoice_number,$file_name)

    {
//        $contents= Storage::disk('public_uploads')
//            ->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
//        return response()->download( $contents);
        $contents = public_path('Attachments/'.$invoice_number.'/'.$file_name);
        return response()->download($contents);
    }



    public function OpenFile($invoice_number,$file_name)

    {
        $files = public_path('Attachments/'.$invoice_number.'/'.$file_name);
        return response()->file($files);
    }
}
