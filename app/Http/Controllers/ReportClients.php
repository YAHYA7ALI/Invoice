<?php

namespace App\Http\Controllers;
use App\Models\section;
use App\Models\Invoice;
use Illuminate\Http\Request;

class ReportClients extends Controller
{
    public function index()
    {
        $sections = section::all();
        return view('Report.CustomerReports',compact('sections'));
    }
    public function SearchCustomer(Request $request)
    {
        //في حاله البحث بدون تاريخ
        if ($request->Section && $request->product && $request->start_at=='' && $request->end_at=='')
        {
            $invoices = Invoice::select('*')->WHERE('section_id','=',$request->Section)->WHERE('product','=',$request->product)->get();;
            $sections = section::all();
            return view('Report.CustomerReports',compact('sections'))->withDetails($invoices);
        }
        //في حاله البحث ب تاريخ
        else
        {
            $start_at = date($request->start_at);
            $end_at = date($request->end_at);
            $invoices = Invoice::whereBetween('invoice_Date',[$start_at,$end_at])->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
            $sections = section::all();
            return view('Report.CustomerReports',compact('sections'))->withDetails($invoices);
        }
        
    }
}