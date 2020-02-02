<?php

namespace App\Http\Controllers\admin\financial_reports;

use App\Branches;
use App\limitations;
use App\limitationsType;
use App\Models\Admin\MainCompany;
use App\Models\Admin\MainBranch;
use App\Models\Admin\AstSalesman;
use App\Models\Admin\MtsChartAc;
use App\Models\Admin\GLJrnal;
use App\Models\Admin\GLjrnTrs;
use App\Models\Admin\MTsCustomer;
use App\operation;
use App\receipts;
use App\receiptsData;
use App\receiptsType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;

class customer_accountingcontroller extends Controller
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
    public function customer_accounting()
    {
        return view('admin.financial_reports.customer_accounting.customer_accounts');

    }
    public function cust_account_statement()
    {

        $MainCompany = MainCompany::pluck('Cmp_Nm'.ucfirst(session('lang')),'Cmp_No');

        return view('admin.financial_reports.customer_accounting.accountStatement.account_statement',compact('MainCompany'));

    }

    public function acc_state(Request $request)
    {
        $mainCompany = $request->mainCompany;
        if($request->ajax())
        {


            $mtschartac = MtsChartAc::where('Cmp_No',$mainCompany)->where('Acc_Typ',2)->get(['Acc_No', 'Acc_NmAr']);
//            @dd($mtschartac[0]->Acc_No);
            $mtschartac_Acc_No = MtsChartAc::where('Cmp_No',$mainCompany)->where('Acc_Typ',2)->get();
            return view('admin.financial_reports.customer_accounting.accountStatement.ajax.account_statement',compact('mtschartac_Acc_No','mainCompany','mtschartac'));
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

            return $date = view('admin.financial_reports.customer_accounting.accountStatement.ajax.details',compact('maincompany','MainBranch','fromtree','totree','from','to'))->render();

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
            $GLjrnTrs = GLjrnTrs::where('Cmp_No',$maincompany)->where('Ac_Ty',2)
                ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($from)))
                ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                ->where(function ($q) use($Acc_No) {
                    $q->whereIn('Acc_No', $Acc_No)->orWhereIn('Sysub_Account',$Acc_No);
                })
                ->get();


        }else{
            $GLjrnTrs = GLjrnTrs::where('Cmp_No',$maincompany)->where('Ac_Ty',2)
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
                $Empty_GLjrnTrs = GLjrnTrs::where('Cmp_No',$maincompany)->where('Ac_Ty',2)
                    ->where('Tr_Dt','<', date('Y-m-d 00:00:00',strtotime($from)))

                    ->where(function ($q) use($Acc_No) {
                        $q->whereIn('Acc_No', $Acc_No)->orWhereIn('Sysub_Account',$Acc_No);
                    })
                    ->get();
            }else
            {
                $Empty_GLjrnTrs = GLjrnTrs::where('Cmp_No',$maincompany)->where('Ac_Ty',2)
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
        $pdf = PDF::loadView('admin.financial_reports.customer_accounting.accountStatement.pdf.report', ['GLjrnTrs_name'=>$GLjrnTrs_name,'Empty_GLjrnTrs'=>$Empty_GLjrnTrs,'data'=>$data,'maincompany'=>$maincompany,'fromtree' => $fromtree,'totree' => $totree,'from' => $from,'to' => $to],[],$config);
        return $pdf->stream();

    }
    public function trial_balance()
    {

        $MainCompany = MainCompany::pluck('Cmp_Nm'.ucfirst(session('lang')),'Cmp_No');
        return view('admin.financial_reports.customer_accounting.trial_balance.trial_balance',compact('MainCompany'));

    }

    public function trialbalance_show(Request $request)
    {
        $MainCompany = $request->mainCompany;
        $delegates   = $request->delegates;
        $mtscustomer = $request->mtscustomer;
        if($request->ajax())

        {
            $MtsChartAc = MtsChartAc::where('Cmp_No',$MainCompany)->where('Acc_Typ',1)->pluck('Acc_Nm'.ucfirst(session('lang')),'ID_No');
            $MtsChartAc2 = MtsChartAc::where('Cmp_No',$MainCompany)->where('Acc_Typ',1)->pluck('ID_No');
            $MtsChartAc3 = MtsChartAc::where('Cmp_No',$MainCompany)->where('Acc_Typ',1)->pluck('Acc_No');
            $AstSalesman = AstSalesman::where('Cmp_No',$MainCompany)->pluck('Slm_Nm' . ucfirst(session('lang')) ,'Slm_No');
            $AstSalesman2= AstSalesman::where('Cmp_No',$MainCompany)->pluck('Slm_No');
            $mtscustomer = MTsCustomer::where('Cmp_No',$MainCompany)->pluck('Cstm_Nm' . ucfirst(session('lang')) ,'Cstm_No');
            $delegates   = AstSalesman::where('Cmp_No',$MainCompany)->pluck('Slm_Nm' . ucfirst(session('lang')) ,'Slm_No');
            $contents = view('admin.financial_reports.customer_accounting.trial_balance.ajax.show', ['delegates'=>$delegates,'mtscustomer'=>$mtscustomer,'AstSalesman'=>$AstSalesman,'AstSalesman2'=>$AstSalesman2,'MtsChartAc'=>$MtsChartAc,'fromtree'=>$MtsChartAc2->first(), 'totree'=>$MtsChartAc2->last(),'MtsChartAc3'=>$MtsChartAc3,'MainCompany'=>$MainCompany])->render();
            return $contents;
        }


    }

    public function details_trial_balance(Request $request)
    {
//dd($request->all());
        if($request->ajax()){
            $MainCompany = $request->MainCompany;
            $but_sales_check = $request->but_sales_check;
            $sales_check = $request->sales_check;
            $state_check = $request->state_check;
            $fromtree = $request->fromtree;
            $numberfromtree = $request->numberfromtree;
            $totree = $request->totree;
            $numbertotree = $request->numbertotree;
            $radioDepartment = $request->radioDepartment;
            $delegates = $request->delegates;
            $mtscustomer = $request->mtscustomer;
            $From = $request->From;
            $to = $request->to;

                return  $contents = view('admin.financial_reports.customer_accounting.trial_balance.ajax.details',

            [
                'MainCompany'=>$MainCompany,
                'but_sales_check'=>$but_sales_check,
                'sales_check'=>$sales_check,
                'state_check'=>$state_check,
                'fromtree'=>$fromtree,
                'numberfromtree'=>$numberfromtree,
                'totree'=>$totree,
                'numbertotree'=>$numbertotree,
                'radioDepartment'=>$radioDepartment,
                'From'=>$From,
                'to'=>$to,
                'delegates'=>$delegates,
                'mtscustomer'=>$mtscustomer,


            ])->render();


        }

    }
    public function print_trial_balance(Request $request)
    {
        $MainCompany = $request->MainCompany;
        $but_sales_check = $request->but_sales_check;
        $sales_check = $request->sales_check;
        $fromtree = $request->fromtree;
        $numberfromtree = $request->numberfromtree;
        $totree = $request->totree;
        $numbertotree = $request->numbertotree;
        $From = $request->From;
        $to = $request->to;
        $radioDepartment = $request->radioDepartment;
        $delegates = $request->delegates;
        $mtscustomer = $request->mtscustomer;

        if($but_sales_check == null && $delegates == null&& $mtscustomer == null){

            $Cstm_No = MTsCustomer::where('Cmp_No',$MainCompany)->pluck('Cstm_No');
            $GLjrnTrs1 = GLjrnTrs::where('Cmp_No',$MainCompany)->where('Ac_Ty',2)
                ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($From)))
                ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                ->where('Ln_No','>',1)->pluck('Acc_No');
            $GLjrnTrs2 = GLjrnTrs::where('Cmp_No',$MainCompany)->where('Ac_Ty',2)
                ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($From)))
                ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                ->where('Ln_No','>',1)->pluck('Sysub_Account');

            $data = MtsChartAc::where('Cmp_No',$MainCompany)->where('Acc_No',$GLjrnTrs1)->get();
        }else if($but_sales_check != null && $delegates == null&& $mtscustomer == null ){
            $Cstm_No = MTsCustomer::where('Cmp_No',$MainCompany)->where('Slm_No',$sales_check)->pluck('Cstm_No');
//            dd($Cstm_No);
            $GLjrnTrs1 = GLjrnTrs::where('Cmp_No',$MainCompany)->where('Ac_Ty',2)
                ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($From)))
                ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                ->where('Ln_No','>',1)->pluck('Acc_No');
//            dd($GLjrnTrs1);

            $GLjrnTrs2 = GLjrnTrs::where('Cmp_No',$MainCompany)->where('Ac_Ty',2)
                ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($From)))
                ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                ->where('Ln_No','>',1)->pluck('Sysub_Account');

            $data = MtsChartAc::where('Cmp_No',$MainCompany)->where('Acc_No',$GLjrnTrs1)->get();
//            dd($data);
//            $MTsCustomer = MTsCustomer::where('Cmp_No',$MainCompany)->where('Slm_No',$sales_check)->get();
//
//            $IdFristTree =  MtsChartAc::where('Cmp_No',$MainCompany)->where('Acc_No',$fromtree)->pluck('ID_No');
//            $IdEndTree =  MtsChartAc::where('Cmp_No',$MainCompany)->where('Acc_No',$totree)->pluck('ID_No');
//
//            $MtsChartAc = MtsChartAc::where('Cmp_No',$MainCompany)
//                ->where('Acc_Typ',2)
//
//                ->orderBy('Acc_No')->where('ID_No', '>=', $IdFristTree)
//                ->where('ID_No', '<=', $IdEndTree)
//                ->get();
        }
        else if($but_sales_check != null && $delegates != null&& $mtscustomer == null )
        {
//            $Cstm_No = MTsCustomer::where('Cmp_No',$MainCompany)->where('Slm_No',$sales_check)->pluck('Cstm_No');

            $GLjrnTrs1 = GLjrnTrs::where('Cmp_No',$MainCompany)->where('Ac_Ty',2)
                ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($From)))
                ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                ->where('Ln_No','>',1)->pluck('Acc_No');

            $GLjrnTrs2 = GLjrnTrs::where('Cmp_No',$MainCompany)->where('Ac_Ty',2)
                ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($From)))
                ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                ->where('Ln_No','>',1)->pluck('Sysub_Account');

            $data = MtsChartAc::where('Cmp_No',$MainCompany)->where('Acc_No',$GLjrnTrs1)->get();
        }
        else if($but_sales_check == null && $delegates != null&& $mtscustomer == null )
        {
            $Cstm_No = MTsCustomer::where('Cmp_No',$MainCompany)->pluck('Cstm_No');
            $GLjrnTrs1 = GLjrnTrs::where('Cmp_No',$MainCompany)->where('Ac_Ty',2)
                ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($From)))
                ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                ->where('Ln_No','>',1)->pluck('Acc_No');
            $GLjrnTrs2 = GLjrnTrs::where('Cmp_No',$MainCompany)->where('Ac_Ty',2)
                ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($From)))
                ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                ->where('Ln_No','>',1)->pluck('Sysub_Account');

            $data = MtsChartAc::where('Cmp_No',$MainCompany)->where('Acc_No',$GLjrnTrs1)->get();
        }
        else if ($but_sales_check != null && $delegates != null&& $mtscustomer != null )
        {
            $Cstm_No = MTsCustomer::where('Cmp_No',$MainCompany)->where('Slm_No',$sales_check)->pluck('Cstm_No');
            $GLjrnTrs1 = GLjrnTrs::where('Cmp_No',$MainCompany)->where('Ac_Ty',2)
                ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($From)))
                ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                ->where('Ln_No','>',1)->pluck('Acc_No');

            $GLjrnTrs2 = GLjrnTrs::where('Cmp_No',$MainCompany)->where('Ac_Ty',2)
                ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($From)))
                ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                ->where('Ln_No','>',1)->pluck('Sysub_Account');

            $data = MtsChartAc::where('Cmp_No',$MainCompany)->where('Acc_No',$GLjrnTrs1)->get();

        }
        else if ($but_sales_check == null && $delegates == null&& $mtscustomer != null )
        {
            $GLjrnTrs1 = GLjrnTrs::where('Cmp_No',$MainCompany)->where('Ac_Ty',2)
                ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($From)))
                ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                ->where('Ln_No','>',1)->pluck('Acc_No');

            $GLjrnTrs2 = GLjrnTrs::where('Cmp_No',$MainCompany)->where('Ac_Ty',2)
                ->where('Tr_Dt','>=', date('Y-m-d 00:00:00',strtotime($From)))
                ->where('Tr_Dt','<=', date('Y-m-d 00:00:00',strtotime($to)))
                ->where('Ln_No','>',1)->pluck('Sysub_Account');

            $data = MtsChartAc::where('Cmp_No',$MainCompany)->where('Acc_No',$GLjrnTrs1)->get();

        }
            switch ($radioDepartment) {
                case '1':

                    $config = ['instanceConfigurator' => function($mpdf) {
                            $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                            );
                        }];
                        $pdf = PDF::loadView('admin.financial_reports.customer_accounting.trial_balance.pdf.totalDepartment',
                            ['data'   =>$data, 'From'=>$From,'to'=>$to], [] , $config);
                        return $pdf->stream();

                    break;
                case '2':

                    $config = ['instanceConfigurator' => function($mpdf) {
                        $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                        );
                    }];
                    $pdf = PDF::loadView('admin.financial_reports.customer_accounting.trial_balance.pdf.totalDepartment',
                        ['data'   =>$data,'From'=>$From,'to'=>$to], [] , $config);
                    return $pdf->stream();
                    break;

                    case '3':
                        $data = MtsChartAc::where('Cmp_No',$MainCompany)->whereRaw('Fbal_DB > Fbal_CR')
                            ->where(function ($q) use($GLjrnTrs1, $GLjrnTrs2) {
                                $q->whereIn('Acc_No',$GLjrnTrs2)->orWhereIn('Acc_No',$GLjrnTrs1);
                            })->get();
                    $config = ['instanceConfigurator' => function($mpdf) {
                        $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                        );
                    }];
                    $pdf = PDF::loadView('admin.financial_reports.customer_accounting.trial_balance.pdf.totalDepartment',
                        ['data'=> $data,'From'=>$From,'to'=>$to], [] , $config);
                    return $pdf->stream();
                    break;

                    case '4':
                        $data = MtsChartAc::where('Cmp_No',$MainCompany)->whereRaw('Fbal_DB < Fbal_CR')
                            ->where(function ($q) use($GLjrnTrs1, $GLjrnTrs2) {
                                $q->whereIn('Acc_No',$GLjrnTrs2)->orWhereIn('Acc_No',$GLjrnTrs1);
                            })->get();
                    $config = ['instanceConfigurator' => function($mpdf) {
                        $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                        );
                    }];
                    $pdf = PDF::loadView('admin.financial_reports.customer_accounting.trial_balance.pdf.totalDepartment',
                        ['data'=> $data,'From'=>$From,'to'=>$to], [] , $config);
                    return $pdf->stream();
                    break;
            }
//
//                        break;
//                    case '1';
//                        $departments = Department::orderBy('code')->where('id', '>=', $fromtree)->where('id', '<=', $totree)->where('level_id',$level)->get();
//
//                        $config = ['instanceConfigurator' => function($mpdf) {
//                            $mpdf->SetHTMLFooter('
//                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
//                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
//                            );
//                        }];
//                        $pdf = PDF::loadView('admin.accountingReports.trialBalance.pdf.level2', ['departments'=>$departments,'from'=>$from,'to'=>$to], [] , $config);
//                        return $pdf->stream();
//                        break;
//                    case '2';
//                        $departments = Department::orderBy('code')->where('level_id',$level)->where('id', '>=', $fromtree)->where('id', '<=', $totree)
//                            ->get();
//
//                        $config = ['instanceConfigurator' => function($mpdf) {
//                            $mpdf->SetHTMLFooter('
//                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
//                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
//                            );
//                        }];
//                        $pdf = PDF::loadView('admin.accountingReports.trialBalance.pdf.level3', ['departments'=>$departments,'from'=>$from,'to'=>$to], [] , $config);
//                        return $pdf->stream();
//                        break;
//                    case '3';
//                        $departments = Department::orderBy('code')->where('id', '>=', $fromtree)->where('id', '<=', $totree)->where('level_id',$level)->get();
//
//                        $config = ['instanceConfigurator' => function($mpdf) {
//                            $mpdf->SetHTMLFooter('
//                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
//                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
//                            );
//                        }];
//                        $pdf = PDF::loadView('admin.accountingReports.trialBalance.pdf.level4', ['departments'=>$departments,'from'=>$from,'to'=>$to], [] , $config);
//                        return $pdf->stream();
//                    case '4';
//                        $departments = Department::orderBy('code')->where('id', '>=', $fromtree)->where('id', '<=', $totree)->where('level_id',$level)->get();
//
//                        $config = ['instanceConfigurator' => function($mpdf) {
//                            $mpdf->SetHTMLFooter('
//                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
//                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
//                            );
//                        }];
//                        $pdf = PDF::loadView('admin.accountingReports.trialBalance.pdf.level5', ['departments'=>$departments,'from'=>$from,'to'=>$to], [] , $config);
//                        return $pdf->stream();
//                        break;




    }
    public function daily_restriction()
    {
        return view('admin.financial_reports.customer_accounting.report.daily_restriction');

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
