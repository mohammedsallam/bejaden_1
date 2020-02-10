<?php

namespace App\Http\Controllers\admin\financial_reports;

use App\Models\Admin\GLjrnTrs;
use App\Models\Admin\MainCompany;
use App\Models\Admin\MtsChartAc;
use App\Models\Admin\MtsCostcntr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;


class CC_accountingController extends Controller
{
    public function cc_accounting()
    {
        return view('admin.financial_reports.cc_accounting.cc_accounting');
    }
    public function balances_cc()
    {
        return view('admin.financial_reports.cc_accounting.report.balances_cc');
    }
    public function motion_cc()
    {
        return view('admin.financial_reports.cc_accounting.report.motion_cc');
    }
    public function general_balance_cc()
    {
        return view('admin.financial_reports.cc_accounting.report.general_balance_cc');
    }

    // كشف حركة مراكز التكلفه
    public  function movement_statement()
    {
        $MainCompany = MainCompany::pluck('Cmp_Nm'.ucfirst(session('lang')),'Cmp_No');
        return view('admin.financial_reports.cc_accounting.movementStatement.movement_statement', compact('MainCompany'));
    }

    public function movement_acc_cc(Request $request)
    {
        $mainCompany = $request->mainCompany;
        if($request->ajax()){
            $costcntrc = MtsCostcntr::where('Cmp_No', $mainCompany)->get();
            return view('admin.financial_reports.cc_accounting.movementStatement.ajax.movement_statement', compact('costcntrc', 'mtschartac_Acc_No', 'mainCompany'));
        }
    }

    public function movement_details(Request $request)
    {
        $maincompany = $request->maincompany;
        $fromtree = $request->fromtree;
        $totree = $request->totree;
        $acc_fromtree = $request->acc_fromtree;
        $acc_totree = $request->acc_totree;
        $from = $request->from;
        $to = $request->to;

        if ($request->ajax()){
            return view('admin.financial_reports.cc_accounting.movementStatement.ajax.details',compact('maincompany','MainBranch','fromtree','totree','from','to','acc_fromtree','acc_totree'))->render();

        }
    }

    public function movement_pdf(Request $request)
    {
        $maincompany = $request->maincompany;
        $fromtree = $request->fromtree;
        $totree = $request->totree;
        $from = $request->from;
        $to = $request->to;
        $costcntrc = MtsCostcntr::where('Cmp_No', $maincompany)->where('Costcntr_No', '=', $fromtree)->where('Costcntr_No', '=', $totree)->pluck('Costcntr_No');
//        dd($costcntrc);
        $Acc_No = MtsChartAc::where('Cmp_No',$maincompany)->where('Clsacc_No3',$costcntrc)->pluck('Acc_No');
//        dd($Acc_No);

        if($from > 1600 )
        {
            $GLjrnTrs = GLjrnTrs::where('Cmp_No',$maincompany)
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
                $Empty_GLjrnTrs = GLjrnTrs::where('Cmp_No',$maincompany)
                    ->where('Tr_Dt','<', date('Y-m-d 00:00:00',strtotime($from)))
                    ->where(function ($q) use($Acc_No) {
                        $q->whereIn('Acc_No', $Acc_No)->orWhereIn('Sysub_Account',$Acc_No);
                    })
                    ->get();
            }
            else
            {
                $Empty_GLjrnTrs = GLjrnTrs::where('Cmp_No',$maincompany)
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
//            $GLjrnTrs_name = MtsChartAc::where('Cmp_No',$maincompany)->where('Acc_No', '=', $fromtree)->where('Acc_No', '=', $totree)
//                ->get(['Acc_No','Acc_NmAr'])->first();
            $GLjrnTrs_name = MtsCostcntr::where('Cmp_No', $maincompany)->where('Costcntr_No', '=', $fromtree)->where('Costcntr_No', '=', $totree)->get(['Costcntr_No','Costcntr_Nmar'])->first();



        }

        $Acc_No = MtsChartAc::where('Cmp_No',$maincompany)->where('ID_No', '>=', $fromtree)->where('ID_No', '<=', $totree)->pluck('Acc_No')->toArray();
        $GLjrnTrs = GLjrnTrs::where('Cmp_No',$maincompany)->where('Ac_Ty',1)

            ->WhereIN('Sysub_Account',$Acc_No)->WhereIN('Acc_No',$Acc_No)
            ->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->get();

        $config = ['instanceConfigurator' => function($mpdf) {
            $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
            );
        }];
        $pdf = PDF::loadView('admin.financial_reports.cc_accounting.movementStatement.pdf.report', ['GLjrnTrs_name'=>$GLjrnTrs_name,'Empty_GLjrnTrs'=>$Empty_GLjrnTrs,'data'=>$data,'maincompany'=>$maincompany,'fromtree' => $fromtree,'totree' => $totree,'from' => $from,'to' => $to],[],$config);
        return $pdf->stream();

    }

    //ميزان مراجعه
    public function movement_balance()
    {
        $MainCompany = MainCompany::pluck('Cmp_Nm'.ucfirst(session('lang')),'Cmp_No');
        return view('admin.financial_reports.cc_accounting.trial_balance.trial_balance', compact('MainCompany'));
    }


    public function trialbalance_show(Request $request)
    {
        $MainCompany = $request->MainCompany;
        if($request->ajax())
        {
            $MtsCostcntr  = MtsCostcntr::where('Cmp_No',$MainCompany)->pluck('Costcntr_Nm'.session('lang'),'Costcntr_No');
            $MtsCostcntr2 = MtsCostcntr::where('Cmp_No',$MainCompany)->pluck('ID_No');
            $MtsCostcntr3 = MtsCostcntr::where('Cmp_No',$MainCompany)->pluck('Costcntr_No');
            //$level = MtsChartAc::where('Cmp_No',$MainCompany)->where('Acc_Typ',1)->max('Level_No');
            $contents = view('admin.financial_reports.cc_accounting.trial_balance.ajax.show', ['MtsCostcntr'=>$MtsCostcntr,'fromtree'=>$MtsCostcntr2->first(), 'totree'=>$MtsCostcntr2->last(),'MtsCostcntr3'=>$MtsCostcntr3,'MainCompany'=>$MainCompany])->render();
            return $contents;

        }
    }

    public function get_levels(Request $request)
    {
        $MainCompany = $request->MainCompany;
        $fromtree    = $request->fromtree;
        $MtsCostcntr  = MtsCostcntr::where('Cmp_No',$MainCompany)->where('Costcntr_No', 'like', $fromtree . '%')->groupBy('Level_No')->pluck('Level_No');
//        dd($MtsCostcntr);
        return view('admin.financial_reports.cc_accounting.trial_balance.ajax.get_levels', compact('MtsCostcntr'));
    }

    public function trialbalance_details(Request $request)
    {
        if($request->ajax()){
            $MainCompany = $request->MainCompany;
            $level = $request->level;
            $fromtree = $request->fromtree;
            $totree = $request->totree;
            $from = $request->from;
            $to = $request->to;
            $but_level_check = $request->but_level_check;
            $radiodepartment = $request->radiodepartment;


            $contents = view('admin.financial_reports.cc_accounting.trial_balance.ajax.details',
                ['MainCompany'=>$MainCompany,
                    'level'=>$level,
                    'fromtree'=>$fromtree,
                    'totree'=>$totree,
                    'from'=>$from,
                    'to'=>$to,
                    'but_level_check'=>$but_level_check,
                    'radiodepartment'=>$radiodepartment,
                ])->render();
            return $contents;

        }

    }

    public function trialbalance_level(Request $request)
    {
        $MainCompany = $request->MainCompany;
        $level = $request->level;
        $from = $request->from;
        $to = $request->to;
        $but_level_check = $request->but_level_check;
        $radiodepartment = $request->radiodepartment;

        if($request->ajax()){
            $MtsCostcntr  = MtsCostcntr::where('Cmp_No',$MainCompany)->where('Level_No',$level)->pluck('Costcntr_Nm'.session('lang'),'Costcntr_No');
            $MtsCostcntr2 = MtsCostcntr::where('Cmp_No',$MainCompany)->where('Level_No',$level)->pluck('ID_No');
            $MtsCostcntr3 = MtsCostcntr::where('Cmp_No',$MainCompany)->where('Level_No',$level)->pluck('Costcntr_No');
            return  $contents = view('admin.financial_reports.cc_accounting.trial_balance.ajax.show_level',
                ['MtsCostcntr'=>$MtsCostcntr,
                    'fromtree'=>$MtsCostcntr2->first(),
                    'totree'=>$MtsCostcntr2->last(),
                    'MtsCostcntr3'=>$MtsCostcntr3,
                    'MainCompany'=>$MainCompany,'level'=>$level,
                    'from'=>$from,
                    'to'=>$to,
                    'but_level_check'=>$but_level_check,
                    'radiodepartment'=>$radiodepartment,
                    'level'=>$level,

                ])->render();


        }

    }

    public function trialbalance_print(Request $request)
    {

        $MainCompany = $request->MainCompany;
        $level = $request->level;
        $fromtree = $request->fromtree;
        $totree = $request->totree;
        $from = $request->from;
        $to = $request->to;
        $but_level_check = $request->but_level_check;
        $radiodepartment = $request->radiodepartment;

        switch ($radiodepartment) {
                case '1';
                    $GLjrnTrs1 = GLjrnTrs::where('Cmp_No',$MainCompany)->where('Ac_Ty',1)
                        ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($from)))
                        ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                        ->where('Ln_No',1)->pluck('Acc_No');

                    $GLjrnTrs2 = GLjrnTrs::where('Cmp_No',$MainCompany)->where('Ac_Ty',1)
                        ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($from)))
                        ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                        ->where('Ln_No','>',1)->pluck('Sysub_Account');

                    $data  = MtsCostcntr::where('Cmp_No',$MainCompany)->where('Costcntr_No', 'like', $fromtree . '%')
                        ->get();


                    $config = ['instanceConfigurator' => function($mpdf) {
                        $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                        );
                    }];
                    $pdf = PDF::loadView('admin.financial_reports.cc_accounting.trial_balance.pdf.department_total',
                        ['data'=>$data,'from' => $from,'to' => $to],[],$config);
                    return $pdf->stream();
                /****/
                case '2';
                    $GLjrnTrs1 = GLjrnTrs::where('Cmp_No',$MainCompany)->where('Ac_Ty',1)
                        ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($from)))
                        ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                        ->where('Ln_No',1)->pluck('Acc_No');

                    $GLjrnTrs2 = GLjrnTrs::where('Cmp_No',$MainCompany)->where('Ac_Ty',1)
                        ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($from)))
                        ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                        ->where('Ln_No','>',1)->pluck('Sysub_Account');

                    $data = MtsChartAc::where('Cmp_No',$MainCompany)
                        ->where(function ($q) use($GLjrnTrs1, $GLjrnTrs2) {
                            $q->whereIn('Acc_No',$GLjrnTrs2)->orWhereIn('Acc_No',$GLjrnTrs1);
                        })->get();


                    $config = ['instanceConfigurator' => function($mpdf) {
                        $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                        );
                    }];
                    $pdf = PDF::loadView('admin.financial_reports.cc_accounting.trial_balance.pdf.balance_account',
                        ['data'=>$data,'from' => $from,'to' => $to],[],$config);
                    return $pdf->stream();

                /*****/
                case '3';
                    $GLjrnTrs1 = GLjrnTrs::where('Cmp_No',$MainCompany)->where('Ac_Ty',1)
                        ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($from)))
                        ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                        ->where('Ln_No',1)->pluck('Acc_No');

                    $GLjrnTrs2 = GLjrnTrs::where('Cmp_No',$MainCompany)->where('Ac_Ty',1)
                        ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($from)))
                        ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                        ->where('Ln_No','>',1)->pluck('Sysub_Account');

                    $data = MtsChartAc::where('Cmp_No',$MainCompany)
                        ->where(function ($q) use($GLjrnTrs1, $GLjrnTrs2) {
                            $q->whereIn('Acc_No',$GLjrnTrs2)->orWhereIn('Acc_No',$GLjrnTrs1);
                        })->get();


                    $config = ['instanceConfigurator' => function($mpdf) {
                        $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                        );
                    }];
                    $pdf = PDF::loadView('admin.financial_reports.cc_accounting.trial_balance.pdf.debit_account',
                        ['data'=>$data,'from' => $from,'to' => $to],[],$config);
                    return $pdf->stream();
                /*****/
                case '4';
                    $GLjrnTrs1 = GLjrnTrs::where('Cmp_No',$MainCompany)->where('Ac_Ty',1)
                        ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($from)))
                        ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                        ->where('Ln_No',1)->pluck('Acc_No');

                    $GLjrnTrs2 = GLjrnTrs::where('Cmp_No',$MainCompany)->where('Ac_Ty',1)
                        ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($from)))
                        ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                        ->where('Ln_No','>',1)->pluck('Sysub_Account');

                    $data = MtsChartAc::where('Cmp_No',$MainCompany)
                        ->where(function ($q) use($GLjrnTrs1, $GLjrnTrs2) {
                            $q->whereIn('Acc_No',$GLjrnTrs2)->orWhereIn('Acc_No',$GLjrnTrs1);
                        })->get();


                    $config = ['instanceConfigurator' => function($mpdf) {
                        $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                        );
                    }];
                    $pdf = PDF::loadView('admin.financial_reports.cc_accounting.trial_balance.pdf.credit_account',
                        ['data'=>$data,'from' => $from,'to' => $to],[],$config);
                    return $pdf->stream();
            /*****/
            case '5';
                $GLjrnTrs1 = GLjrnTrs::where('Cmp_No',$MainCompany)->where('Ac_Ty',1)
                    ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($from)))
                    ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                    ->where('Ln_No',1)->pluck('Acc_No');

                $GLjrnTrs2 = GLjrnTrs::where('Cmp_No',$MainCompany)->where('Ac_Ty',1)
                    ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($from)))
                    ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                    ->where('Ln_No','>',1)->pluck('Sysub_Account');

                $data = MtsChartAc::where('Cmp_No',$MainCompany)
                    ->where(function ($q) use($GLjrnTrs1, $GLjrnTrs2) {
                        $q->whereIn('Acc_No',$GLjrnTrs2)->orWhereIn('Acc_No',$GLjrnTrs1);
                    })->get();


                $config = ['instanceConfigurator' => function($mpdf) {
                    $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                    );
                }];
                $pdf = PDF::loadView('admin.financial_reports.cc_accounting.trial_balance.pdf.credit_account',
                    ['data'=>$data,'from' => $from,'to' => $to],[],$config);
                return $pdf->stream();

            }


    }

    /******************************/
    //cc balance
    // أرصدة مراكز التكلفه
    public function cc_balance()
    {
        $MainCompany = MainCompany::pluck('Cmp_Nm'.ucfirst(session('lang')),'Cmp_No');
        return view('admin.financial_reports.cc_accounting.cc_balance.cc_balance', compact('MainCompany'));
    }

    public function cc_balance_show(Request $request)
    {
        $MainCompany = $request->MainCompany;
        if($request->ajax())
        {
            $MtsCostcntr  = MtsCostcntr::where('Cmp_No',$MainCompany)->where('Level_No','>',1);
            $MtsCostcntr2 = MtsCostcntr::where('Cmp_No',$MainCompany)->pluck('ID_No');
            $MtsCostcntr3 = MtsCostcntr::where('Cmp_No',$MainCompany)->pluck('Costcntr_No');
            $level = MtsChartAc::where('Cmp_No',$MainCompany)->where('Acc_Typ',1)->max('Level_No');
            $contents = view('admin.financial_reports.cc_accounting.cc_balance.ajax.show', ['MtsCostcntr'=>$MtsCostcntr,
                'fromtree'=>$MtsCostcntr2->first(), 'totree'=>$MtsCostcntr2->last(),'MtsCostcntr3'=>$MtsCostcntr3,
                'MainCompany'=>$MainCompany,'level'=>$level])->render();
            return $contents;

        }
    }

    public function cc_balance_details(Request $request)
    {
        if($request->ajax()){
            $MainCompany = $request->MainCompany;
            $level = $request->level;
            $fromtree = $request->fromtree;
            $totree = $request->totree;
            $from = $request->from;
            $to = $request->to;
            $but_level_check = $request->but_level_check;
            $radiodepartment = $request->radiodepartment;


            $contents = view('admin.financial_reports.cc_accounting.cc_balance.ajax.details',
                ['MainCompany'=>$MainCompany,
                    'level'=>$level,
                    'fromtree'=>$fromtree,
                    'totree'=>$totree,
                    'from'=>$from,
                    'to'=>$to,
                    'but_level_check'=>$but_level_check,
                    'radiodepartment'=>$radiodepartment,
                ])->render();
            return $contents;

        }

    }

    public function cc_balance_level(Request $request)
    {
        $MainCompany = $request->MainCompany;
        $level = $request->level;
        $from = $request->from;
        $to = $request->to;
        $but_level_check = $request->but_level_check;
        $radiodepartment = $request->radiodepartment;

        if($request->ajax()){
            $MtsCostcntr  = MtsCostcntr::where('Cmp_No',$MainCompany)->where('Level_No',$level);
            $MtsCostcntr2 = MtsCostcntr::where('Cmp_No',$MainCompany)->where('Level_No',$level)->pluck('ID_No');
            $MtsCostcntr3 = MtsCostcntr::where('Cmp_No',$MainCompany)->where('Level_No',$level)->pluck('Costcntr_No');
            return  $contents = view('admin.financial_reports.cc_accounting.cc_balance.ajax.show_level',
                ['MtsCostcntr'=>$MtsCostcntr,
                    'fromtree'=>$MtsCostcntr2->first(),
                    'totree'=>$MtsCostcntr2->last(),
                    'MtsCostcntr3'=>$MtsCostcntr3,
                    'MainCompany'=>$MainCompany,'level'=>$level,
                    'from'=>$from,
                    'to'=>$to,
                    'but_level_check'=>$but_level_check,
                    'radiodepartment'=>$radiodepartment,
                    'level'=>$level,

                ])->render();


        }

    }

    public function cc_balance_print(Request $request)
    {
        $MainCompany = $request->MainCompany;
        $level = $request->level;
        $fromtree = $request->fromtree;
        $totree = $request->totree;
        $from = $request->from;
        $to = $request->to;
        $but_level_check = $request->but_level_check;
        $radiodepartment = $request->radiodepartment;

        if ($but_level_check){
            switch ($radiodepartment) {
                case '1';
                    $data  = MtsCostcntr::where('Cmp_No',$MainCompany)->where('Level_Status', 1)->get();

                    $config = ['instanceConfigurator' => function($mpdf) {
                        $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                        );
                    }];
                    $pdf = PDF::loadView('admin.financial_reports.cc_accounting.cc_balance.pdf.department_total',
                        ['data'=>$data,'from' => $from,'to' => $to],[],$config);
                    return $pdf->stream();

                /****/
                case '2';
                    $data  = MtsCostcntr::where('Cmp_No',$MainCompany)->where('Level_Status', 1)->get();
//                    @dd($data);
                    $config = ['instanceConfigurator' => function($mpdf) {
                        $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                        );
                    }];
                    $pdf = PDF::loadView('admin.financial_reports.cc_accounting.cc_balance.pdf.department_total',
                        ['data'=>$data,'from' => $from,'to' => $to],[],$config);
                    return $pdf->stream();

                /*****/
                case '3';
                    $data  = MtsCostcntr::where('Cmp_No',$MainCompany)->where('Level_Status', 1)->get();

                    $config = ['instanceConfigurator' => function($mpdf) {
                        $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                        );
                    }];
                    $pdf = PDF::loadView('admin.financial_reports.cc_accounting.cc_balance.pdf.debit_account',
                        ['data'=>$data,'from' => $from,'to' => $to],[],$config);
                    return $pdf->stream();

                /*****/
                case '4';
                    $data  = MtsCostcntr::where('Cmp_No',$MainCompany)->where('Level_Status', 1)->get();

                    $config = ['instanceConfigurator' => function($mpdf) {
                        $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                        );
                    }];
                    $pdf = PDF::loadView('admin.financial_reports.cc_accounting.cc_balance.pdf.credit_account',
                        ['data'=>$data,'from' => $from,'to' => $to],[],$config);
                    return $pdf->stream();

                /****/
                //بدون حركات
                case '5';
                    $data  = MtsCostcntr::where('Cmp_No',$MainCompany)->where('Level_Status', 1)->get();

                    $config = ['instanceConfigurator' => function($mpdf) {
                        $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                        );
                    }];
                    $pdf = PDF::loadView('admin.financial_reports.cc_accounting.cc_balance.pdf.no_movements',
                        ['data'=>$data,'from' => $from,'to' => $to],[],$config);
                    return $pdf->stream();
            }
        }
        else
        {

            switch ($radiodepartment) {

                case '1';
                    $data  = MtsCostcntr::where('Cmp_No',$MainCompany)->where('Level_No',$level)->get();

                    $config = ['instanceConfigurator' => function($mpdf) {
                        $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                        );
                    }];
                    $pdf = PDF::loadView('admin.financial_reports.cc_accounting.cc_balance.pdf.levels.level',
                        ['data'=>$data,'from' => $from,'to' => $to],[],$config);
                    return $pdf->stream();
                /*****/

                case '2';
                    $data  = MtsCostcntr::where('Cmp_No',$MainCompany)->where('Level_No',$level)->get();

                    $config = ['instanceConfigurator' => function($mpdf) {
                        $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                        );
                    }];
                    $pdf = PDF::loadView('admin.financial_reports.cc_accounting.cc_balance.pdf.levels.level',
                        ['data'=>$data,'from' => $from,'to' => $to],[],$config);
                    return $pdf->stream();
                /*****/

                case '3';
                    $data  = MtsCostcntr::where('Cmp_No',$MainCompany)->where('Level_No',$level)->get();

                    $config = ['instanceConfigurator' => function($mpdf) {
                        $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                        );
                    }];
                    $pdf = PDF::loadView('admin.financial_reports.cc_accounting.cc_balance.pdf.levels.level',
                        ['data'=>$data,'from' => $from,'to' => $to],[],$config);
                    return $pdf->stream();
                /*****/

                case '4';
                    $data  = MtsCostcntr::where('Cmp_No',$MainCompany)->where('Level_No',$level)->get();

                    $config = ['instanceConfigurator' => function($mpdf) {
                        $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                        );
                    }];
                    $pdf = PDF::loadView('admin.financial_reports.cc_accounting.cc_balance.pdf.levels.level',
                        ['data'=>$data,'from' => $from,'to' => $to],[],$config);
                    return $pdf->stream();

                /*****/
                //بدون حركات
                case '5';
                    $data  = MtsCostcntr::where('Cmp_No',$MainCompany)->where('Level_No',$level)->get();

                    $config = ['instanceConfigurator' => function($mpdf) {
                        $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                        );
                    }];
                    $pdf = PDF::loadView('admin.financial_reports.cc_accounting.cc_balance.pdf.levels.level',
                        ['data'=>$data,'from' => $from,'to' => $to],[],$config);
                    return $pdf->stream();

            }
        }

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
