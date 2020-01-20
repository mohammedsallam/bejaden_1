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


        return view('admin.financial_reports.financial_reports');

    }
    public function general_accounts()
    {
        return view('admin.financial_reports.general_accounts.general_accounts');

    }
    public function account_statement()
    {

        $MainCompany = MainCompany::pluck('Cmp_Nm'.ucfirst(session('lang')),'Cmp_No');

        return view('admin.financial_reports.general_accounts.accountStatement.account_statement',compact('MainCompany'));

    }

//    public function branche(Request $request)
////    {
////        if($request->ajax())
////        {
////            $mainCompany = $request->mainCompany;
////            $MainBranch = MainBranch::where('Cmp_No',$mainCompany)->pluck('Brn_Nm'.ucfirst(session('lang')),'Brn_No');
////            return $data = view('admin.financial_reports.general_accounts.accountStatement.ajax.get_branche',compact('MainBranch','mainCompany'))->render();
////        }
////    }
    public function acc_state(Request $request)
    {
        $mainCompany = $request->mainCompany;
        if($request->ajax())
        {


            $mtschartac = MtsChartAc::where('Cmp_No',$mainCompany)->where('Acc_Typ',1)->get(['Acc_No', 'Acc_NmAr']);
//            @dd($mtschartac[0]->Acc_No);
            $mtschartac_Acc_No = MtsChartAc::where('Cmp_No',$mainCompany)->where('Acc_Typ',1)->get();
            return view('admin.financial_reports.general_accounts.accountStatement.ajax.account_statement',compact('mtschartac_Acc_No','mainCompany','mtschartac'));
        }
    }
    public function details(Request $request)
    {

        $maincompany = $request->maincompany;

        $fromtree = $request->fromtree;
        $totree = $request->totree;
        $acc_fromtree = $request->acc_fromtree;
        $acc_totree = $request->acc_totree;
        $from = $request->from;
        $to = $request->to;
        if($request->ajax())
        {
//            if($fromtree != null  && $totree != null )
//            {
//                $Acc_No = MtsChartAc::where('Cmp_No',$maincompany)->where('ID_No', '>=', $fromtree)->where('ID_No', '<=', $totree)->pluck('Acc_No')->toArray();

//                $GLjrnTrs = GLjrnTrs::where('Cmp_No',$maincompany)->where('Ac_Ty',1)->whereIN('Acc_No',$Acc_No)->orWhereIN('Sysub_Account',$Acc_No)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->get();

                return $date = view('admin.financial_reports.general_accounts.accountStatement.ajax.details',compact('maincompany','MainBranch','fromtree','totree','from','to'))->render();

//            }else{
//                $Acc_No = MtsChartAc::where('Cmp_No',$maincompany)->where('ID_No', '>=', $acc_fromtree)->where('ID_No', '<=', $acc_totree)->pluck('Acc_No')->toArray();
//
//                $GLjrnTrs = GLjrnTrs::where('Cmp_No',$maincompany)->where('Ac_Ty',1)->whereIN('Acc_No',$Acc_No)->orWhereIN('Sysub_Account',$Acc_No)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->get();
//                return $date = view('admin.financial_reports.general_accounts.accountStatement.ajax.details',compact('maincompany','MainBranch','fromtree','totree','from','to','acc_fromtree','acc_totree'))->render();

//            }

        }

    }
    public function print(Request $request)
    {



        $maincompany = $request->maincompany;


        $fromtree = $request->fromtree;
        $totree = $request->totree;
        $from = $request->from;
        $to = $request->to;

        $Acc_No = MtsChartAc::where('Cmp_No',$maincompany)->where('Acc_No', '=', $fromtree)->where('Acc_No', '=', $totree)->pluck('Acc_No')->toArray();
        if($from > 1600 )
        {
            $GLjrnTrs = GLjrnTrs::where('Cmp_No',$maincompany)->where('Ac_Ty',1)
    ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($from)))
    ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
    ->where(function ($q) use($Acc_No) {
        $q->whereIn('Acc_No', $Acc_No)->orWhereIn('Sysub_Account',$Acc_No);
    })
    ->get();


        }else{
    $GLjrnTrs = GLjrnTrs::where('Cmp_No',$maincompany)->where('Ac_Ty',1)
        ->where('Tr_DtAr','>=', date('Y-m-d 00:00:00',strtotime($from)))
        ->where('Tr_DtAr','<=', date('Y-m-d 00:00:00',strtotime($to)))
        ->where(function ($q) use($Acc_No) {
            $q->whereIn('Acc_No', $Acc_No)->orWhereIn('Sysub_Account',$Acc_No);
        })
        ->get();
}


        $GLjrnTrs = $GLjrnTrs->map(function ($data)use($maincompany,$Acc_No){
            $data->Acc_NmAr = $data->MtsChartAc->where('Cmp_No',$maincompany)->whereIn('Acc_No',$Acc_No)->first()->Acc_NmAr;
            $data->Acc_NmEn = $data->MtsChartAc->where('Cmp_No',$maincompany)->whereIn('Acc_No',$Acc_No)->first()->Acc_NmEn;;
            $data->ID_No_MtsChartAc = $data->MtsChartAc->where('Cmp_No',$maincompany)->whereIn('Acc_No',$Acc_No)->first()->ID_No;;
            $data->acc_no_chart = $data->MtsChartAc->where('Cmp_No',$maincompany)->whereIn('Acc_No',$Acc_No)->first()->Acc_No;;


            return $data;
        });
        //sort;
        $GLjrnTrs = $GLjrnTrs->sortBy(function($post) {
            return $post->Tr_Dt;

        });
        $data = $GLjrnTrs->groupBy(function($date) {

            return session_lang($date->Acc_NmEn,$date->Acc_NmAr);


        });
$Empty_GLjrnTrs = [];
        $GLjrnTrs_name = [];
if($data->isEmpty())

{
if($from > 1600 )
{
    $Empty_GLjrnTrs = GLjrnTrs::where('Cmp_No',$maincompany)->where('Ac_Ty',1)
        ->where('Tr_Dt','<', date('Y-m-d 00:00:00',strtotime($from)))

        ->where(function ($q) use($Acc_No) {
            $q->whereIn('Acc_No', $Acc_No)->orWhereIn('Sysub_Account',$Acc_No);
        })
        ->get();
}else
{
    $Empty_GLjrnTrs = GLjrnTrs::where('Cmp_No',$maincompany)->where('Ac_Ty',1)
        ->where('Tr_DtAr','<', date('Y-m-d 00:00:00',strtotime($from)))

        ->where(function ($q) use($Acc_No) {
            $q->whereIn('Acc_No', $Acc_No)->orWhereIn('Sysub_Account',$Acc_No);
        })
        ->get();
}
    $Empty_GLjrnTrs = $Empty_GLjrnTrs->map(function ($data)use($maincompany,$Acc_No){
        $data->Acc_NmAr = $data->MtsChartAc->where('Cmp_No',$maincompany)->whereIn('Acc_No',$Acc_No)->first()->Acc_NmAr;
        $data->Acc_NmEn = $data->MtsChartAc->where('Cmp_No',$maincompany)->whereIn('Acc_No',$Acc_No)->first()->Acc_NmEn;;
        $data->ID_No_MtsChartAc = $data->MtsChartAc->where('Cmp_No',$maincompany)->whereIn('Acc_No',$Acc_No)->first()->ID_No;;
        $data->acc_no_chart = $data->MtsChartAc->where('Cmp_No',$maincompany)->whereIn('Acc_No',$Acc_No)->first()->Acc_No;;


        return $data;
    });

//    //sort;
    $Empty_GLjrnTrs = $Empty_GLjrnTrs->sortBy(function($post) {
    return $post->Tr_Dt;

});
    $GLjrnTrs_name = MtsChartAc::where('Cmp_No',$maincompany)->where('Acc_No', '=', $fromtree)->where('Acc_No', '=', $totree)
        ->get(['Acc_No','Acc_NmAr'])->first();



}






        $config = ['instanceConfigurator' => function($mpdf) {
            $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
            );
        }];
        $pdf = PDF::loadView('admin.financial_reports.general_accounts.accountStatement.pdf.report', ['GLjrnTrs_name'=>$GLjrnTrs_name,'Empty_GLjrnTrs'=>$Empty_GLjrnTrs,'data'=>$data,'maincompany'=>$maincompany,'fromtree' => $fromtree,'totree' => $totree,'from' => $from,'to' => $to],[],$config);
        return $pdf->stream();

    }
    public function trial_balance()
    {

        $MainCompany = MainCompany::orderBy('Cmp_No', 'ASC')->pluck('Cmp_Nm'.ucfirst(session('lang')),'Cmp_No');
        return view('admin.financial_reports.general_accounts.trial_balance.trial_balance',compact('MainCompany'));

    }
    public function branche_trial_balance(Request $request)
    {
        if($request->ajax())
        {
            $MainCompany = $request->mainCompany;
            $MainBranch = MainBranch::where('Cmp_No',$MainCompany)->pluck('Brn_Nm'.ucfirst(session('lang')),'Brn_No');
            return $data = view('admin.financial_reports.general_accounts.trial_balance.ajax.get_branche',compact('MainBranch','MainCompany'))->render();
        }
    }
    public function trialbalance_show(Request $request)
    {
    //        @dd($request->all());
$MainCompany = $request->MainCompany;

$reporttype = $request->reporttype;
$kind = $request->kind;
$level       = $request->level;

        if($request->ajax())
        {

            if($MainCompany != null &&  $reporttype != null && $kind != null && ($level != null || $level == null)){

                switch ($reporttype){
                    case '0';
                        switch ($kind){
                            default;
                                $level = MtsChartAc::where('Cmp_No',$MainCompany)->where('Acc_Typ',1)->max('Level_No');

                                $MtsChartAc = MtsChartAc::where('Cmp_No',$MainCompany)->where('Acc_Typ',1)->where('Level_No',$level)->pluck('Acc_Nm'.ucfirst(session('lang')),'ID_No');
                                $MtsChartAc2 = MtsChartAc::where('Cmp_No',$MainCompany)->where('Acc_Typ',1)->where('Level_No',$level)->pluck('ID_No');

                                $contents = view('admin.financial_reports.general_accounts.trial_balance.ajax.show', ['fromtree'=>$MtsChartAc2->first(), 'totree'=>$MtsChartAc2->last(),'MainCompany'=>$MainCompany,'MtsChartAc'=>$MtsChartAc,'kind'=>$kind,'level'=>$level])->render();
                                return $contents;
                        }
                        break;
                    case '1';
                        switch ($kind){
                            default;

                                $MtsChartAc = MtsChartAc::where('Cmp_No',$MainCompany)
                                    ->where(function ($q)  {
                                        $q->Where('Acc_No', 1)->orWhere('Acc_No',null);
                                    })

                                    ->where('Acc_Typ',1)->where('Level_No',$level)->pluck('Acc_Nm'.ucfirst(session('lang')),'ID_No');
                                $MtsChartAc2 = MtsChartAc::where('Cmp_No',$MainCompany)->where('Acc_Typ',1)->where('Level_No',$level)->pluck('ID_No');

                                $contents = view('admin.financial_reports.general_accounts.trial_balance.ajax.show', ['fromtree'=>$MtsChartAc2->first(), 'totree'=>$MtsChartAc2->last(),'MainCompany'=>$MainCompany,'MtsChartAc'=>$MtsChartAc,'kind'=>$kind,'level'=>$level])->render();
                                return $contents;

                        }
                        break;
                }
            }
        }
    }

    public function trialbalance_details(Request $request)
    {

        if($request->ajax()){
            $MainCompany = $request->MainCompany;
            $MainBranch = $request->MainBranch;
            $level = $request->level;
            $kind = $request->kind;
            $fromtree = $request->fromtree;
            $totree = $request->totree;
            $from = $request->from;
            $to = $request->to;


            if ($from && $to){
                $contents = view('admin.financial_reports.general_accounts.trial_balance.ajax.details', ['MainCompany'=>$MainCompany,'MainBranch'=>$MainBranch,'level'=>$level,'kind'=>$kind,'fromtree'=>$fromtree, 'totree'=>$totree,'from'=>$from,'to'=>$to])->render();
                return $contents;
            }
        }

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
