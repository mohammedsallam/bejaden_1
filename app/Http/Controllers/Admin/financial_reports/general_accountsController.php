<?php

namespace App\Http\Controllers\admin\financial_reports;

use App\Branches;
use App\limitations;
use App\limitationsType;
use App\Models\Admin\MainCompany;
use App\Models\Admin\MainBranch;
use App\Models\Admin\MtsChartAc;
use App\Models\Admin\GLJrnal;
use App\Models\Admin\GLjrnTrs;
use App\operation;
use App\receipts;
use App\receiptsType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;

class general_accountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function financial_reports()
    {


        return view('admin.financial_reports.financial_reports',compact(''));

    }
    public function general_accounts()
    {
        return view('admin.financial_reports.general_accounts.general_accounts');

    }
    public function account_statement()
    {

        $MainCompany = MainCompany::pluck('Cmp_Nm'.ucfirst(session('lang')),'ID_No');

        return view('admin.financial_reports.general_accounts.report.account_statement',compact('MainCompany'));

    }

    public function branche(Request $request)
    {
        if($request->ajax())
        {
            $mainCompany = $request->mainCompany;
            $MainBranch = MainBranch::where('Cmp_No',$mainCompany)->pluck('Brn_Nm'.ucfirst(session('lang')),'ID_No');
            return view('admin.financial_reports.general_accounts.ajax.get_branche',compact('MainBranch','mainCompany'));
        }
    }
    public function acc_state(Request $request)
    {
        if($request->ajax())
        {
            $mainCompany = $request->mainCompany;
            $MainBranch = $request->MainBranch;
            $mtschartac = MtsChartAc::where('Cmp_No',$mainCompany)->where('Acc_Typ',1)->pluck('Acc_Nm'.ucfirst(session('lang')),'ID_No');
            return view('admin.financial_reports.general_accounts.ajax.account_statement',compact('MainBranch','mainCompany','mtschartac'));
        }
    }
    public function details(Request $request)
    {

$maincompany = $request->maincompany;

$MainBranch = $request->MainBranch;
$fromtree = $request->fromtree;
$totree = $request->totree;
$from = $request->from;
$to = $request->to;
if($request->ajax())
{
    $Acc_No = MtsChartAc::where('Cmp_No',$maincompany)->where('ID_No', '>=', $fromtree)->where('ID_No', '<=', $totree)->pluck('Acc_No')->toArray();

//    $GLjrnTrs = GLjrnTrs::where('Cmp_No',$maincompany)->where('Brn_No',$MainBranch)->where('Ac_Ty',1)->whereIN('Acc_No',$Acc_No)->orWhereIN('Sysub_Account',$Acc_No)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->get();
    $GLjrnTrs = GLjrnTrs::where('Cmp_No',$maincompany)->where('Brn_No',$MainBranch)->where('Ac_Ty',1)->whereIN('Acc_No',$Acc_No)->orWhereIN('Sysub_Account',$Acc_No)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->get();
    return $date = view('admin.financial_reports.general_accounts.ajax.details',compact('maincompany','MainBranch','fromtree','totree','from','to'))->render();

}

    }
    public function print(Request $request)
    {



        $maincompany = $request->maincompany;

        $MainBranch = $request->MainBranch;
        $fromtree = $request->fromtree;
        $totree = $request->totree;
        $from = $request->from;
        $to = $request->to;

            $Acc_No = MtsChartAc::where('Cmp_No',$maincompany)->where('ID_No', '>=', $fromtree)->where('ID_No', '<=', $totree)->pluck('Acc_No')->toArray();

            $GLjrnTrs = GLjrnTrs::where('Cmp_No',$maincompany)->where('Brn_No',$MainBranch)->where('Ac_Ty',1)->whereIN('Acc_No',$Acc_No)->orWhereIN('Sysub_Account',$Acc_No)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->get();

        $config = ['instanceConfigurator' => function($mpdf) {
            $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
            );
        }];
        $pdf = PDF::loadView('admin.financial_reports.general_accounts.pdf.report', ['GLjrnTrs'=>$GLjrnTrs,'maincompany'=>$maincompany,'MainBranch'=>$MainBranch,'fromtree' => $fromtree,'totree' => $totree,'from' => $from,'to' => $to],[],$config);
        return $pdf->stream();

    }
    public function trial_balance()
    {
        return view('admin.financial_reports.general_accounts.report.trial_balance');

    }
    public function daily_restriction()
    {
        return view('admin.financial_reports.general_accounts.report.daily_restriction');

    }
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
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
