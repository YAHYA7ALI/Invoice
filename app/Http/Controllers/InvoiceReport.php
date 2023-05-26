<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
class InvoiceReport extends Controller
{
    public function index()
    {
        return view('Report.invoice-Report');
    }

    public function SearchInvoic(Request $request)
    {
        $rdio = $request ->rdio ;

        if ($rdio == 1)
        {
            // في حاله عدم تحديد التاريخ
            if ($request->type && $request->start_at =='' && $request->end_at=='')
            {
                $invoices = Invoice::select('*')->WHERE('Status','=',$request->type)->get();
                $type = $request ->type ;
                return view('Report.invoice-Report',compact('type'))->withDetails($invoices);
            }
             // في حاله تحديد التاريخ
            else
            {
                $start_at = date($request -> start_at);
                $end_at = date($request -> end_at);
                $type = $request ->type ;
                $invoices = Invoice::whereBetween('invoice_Date',[$start_at,$end_at])->WHERE('Status','=',$request->type)->get();
                return view('Report.invoice-Report',compact('type','start_at','end_at'))->withDetails($invoices);
            }
            
        } 
        // في حاله البحث  برقم الفاتوره
        else
        {
            $invoices = Invoice::select('*')->WHERE('invoice_number','=',$request->invoice_number)->get();
            return view('Report.invoice-Report')->withDetails($invoices);
        }
        
    }
}
