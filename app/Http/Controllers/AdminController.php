<?php

namespace App\Http\Controllers;
use App\Models\Invoice;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if(view()->exists($id)){
            return view($id);
        }
        else
        {
            return view('404');
        }

     //   return view($id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //=================احصائية نسبة تنفيذ الحالات======================
        $count_all =Invoice::count();
        $count_invoices1 = Invoice::where('Value_Status', 1)->count();
        $count_invoices2 = Invoice::where('Value_Status', 2)->count();
        $count_invoices3 = Invoice::where('Value_Status', 3)->count();
        if($count_invoices2 == 0)
        {
            $nspainvoices2=0;
        }
        else
        {
            $nspainvoices2 = $count_invoices2/ $count_all*100;
        }
        if($count_invoices1 == 0)
        {
            $nspainvoices1=0;
        }
        else
        {
            $nspainvoices1 = $count_invoices1/ $count_all*100;
        }
        if($count_invoices3 == 0)
        {
            $nspainvoices3=0;
        }
        else
        {
            $nspainvoices3 = $count_invoices3/ $count_all*100;
        }
            $chartjs = app()->chartjs
                ->name('barChartTest')
                ->type('bar')
                ->size(['width' => 1000, 'height' => 400])
                ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
                ->datasets([
                    [
                        "label" => "الفواتير الغير المدفوعة",
                        'backgroundColor' => ['#ec5858'],
                        'data' => [$nspainvoices2]
                    ],
                    [
                        "label" => "الفواتير المدفوعة",
                        'backgroundColor' => ['#029666'],
                        'data' => [$nspainvoices1]
                    ],
                    [
                        "label" => "الفواتير المدفوعة جزئيا",
                        'backgroundColor' => ['#ff9642'],
                        'data' => [$nspainvoices3]
                    ],
                ])
                ->options([]);
//---------//////--------//////--////---------//////--------//////--////---------//////--------//////--////---------//////--------//////--//
            $chartjs_2 = app()->chartjs
                ->name('pieChartTest')
                ->type('pie')
                ->size(['width' => 400, 'height' => 200])
                ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
                ->datasets([
                    [
                        'backgroundColor' => ['#ec5858', '#029666','#ff9642'],
                        'data' => [$nspainvoices2, $nspainvoices1,$nspainvoices3]
                    ]
                ])
                ->options([]);
        return view('dashboard', compact('chartjs','chartjs_2'));
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
