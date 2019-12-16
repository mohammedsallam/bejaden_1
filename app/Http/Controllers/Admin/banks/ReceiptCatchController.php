<?php

namespace App\Http\Controllers\Admin\banks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\DataTables\catchDataTable;
use App\Models\Admin\MainCompany;
use App\Models\Admin\AstSalesman;
use App\Models\Admin\GLjrnTrs;
use App\Models\Admin\GLJrnal;
use App\Models\Admin\MTsCustomer;
use App\Models\Admin\MainBranch;
use App\Models\Admin\MtsChartAc;
use App\Models\Admin\MtsSuplir;
use App\Models\Admin\GLaccBnk;
use Carbon\Carbon;
use Auth;

class ReceiptCatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(catchDataTable $receipts)
    {
        return $receipts->render('admin.banks.invoice.index',['title'=>trans('admin.catch_receipt')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = MainCompany::get(['Cmp_No', 'Cmp_Nm'.ucfirst(session('lang'))]);
        $flags = GLaccBnk::all();
        // مسموح بظهور البنوك و الصنودق فى سند القبض النقدى
        $banks = [];
        foreach($flags as $flag){
            if($flag->RcpCsh_Voucher == 1){
                array_push($banks, $flag);
            }
        }
        return view('admin.banks.catch.create', ['companies' => $companies, 'banks' => $banks]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'Cmp_No' => 'required',
            'Brn_No' => 'required',
            'Tr_No' => 'sometimes',
            'Tr_Dt' => 'sometimes',
            'Tr_DtAr' => 'sometimes',
            'Jr_Ty' => 'sometimes',
            'Tr_Crncy' => 'sometimes',
            'Tr_ExchRat' => 'sometimes',
            'Tot_Amunt' => 'required',
            'Tr_TaxVal' => 'sometimes',
            'Rcpt_By' => 'sometimes',
            'Salman_No' => 'sometimes',
            'Ac_Ty' => 'required',
            'Sysub_Account' => 'required',
            'Tr_Cr' => 'required',
            'Dc_No' => 'sometimes',
            'Tr_Ds' => 'required',
            'Tr_Ds1' => 'sometimes',
            'Tr_Db_Acc_No' => 'sometimes',
        ], [], [
            'Cmp_No' => trans('admin.Cmp_No'),
            'Brn_No' => trans('admin.branche'),
            'Tr_No' => trans('admin.number_of_receipt'),
            'Tr_Dt' => trans('admin.receipt_date'),
            'Tr_DtAr' => trans('admin.higri_date'),
            'Jr_Ty' => trans('admin.receipts_type'),
            'Tr_Crncy' => trans('admin.currency'),
            'Tr_ExchRat' => trans('admin.exchange_rate'),
            'Tot_Amunt' => trans('admin.amount'),
            'Tr_TaxVal' => trans('admin.tax'),
            'Rcpt_By' => trans('admin.Rcpt_By'),
            'Salman_No' => trans('admin.sales_officer2'),
            'Ac_Ty' => trans('admin.Level_Status'),
            // 'Sysub_Account' => trans('admin.'),
            'Tr_Cr' => trans('admin.amount_cr'),
            'Dc_No' => trans('admin.receipt_number'),
            'Tr_Ds' => trans('admin.note_ar'),
            'Tr_Ds1' => trans('admin.note_en'),
            'Tr_Db_Acc_No' => trans('admin.main_cache'),
        ]);
            // return $request;
        $header = GLJrnal::create([
            'Cmp_No' => $request->Cmp_No,
            'Brn_No' => $request->Brn_No,
            'Jr_Ty' => $request->Jr_Ty,
            'Tr_No' => $request->Tr_No,
            'Month_No' => Carbon::now()->month,
            'Month_Jvno' => $request->Tr_No,
            'Doc_Type' => 2,
            'Tr_Dt' => $request->Tr_Dt,
            'Tr_DtAr' => $request->Tr_DtAr,
            'Acc_No' => $request->Acc_No,
            'User_ID' => auth::user()->id,
            'Ac_Ty' => $request->Ac_Ty,
            'Tr_Crncy' => $request->Tr_Crncy,
            'Tr_ExchRat' => $request->Tr_ExchRat,
            'Tr_TaxVal' => $request->Tr_TaxVal,
            'Salman_No' => $request->Salman_No,
            'Tot_Amunt' => $request->Tot_Amunt,
        ]);

        $brn = MainCompany::where('Cmp_No', $request->Cmp_No)->get(['JvAuto_Mnth'])->first();
        // if($brn->JvAuto_Mnth == 1){
        //     $header->Month_Jvno = $this->createMonthAccNo($header->Month_No);
        // }
        $header->Entr_Dt = $header->created_at->format('Y-m-d');
        $header->Entr_Time = $header->created_at->format('H:i:s');
        if($request->Ac_Ty == 1){$header->Chrt_No = $request->Sysub_Account;}
        if($request->Ac_Ty == 2){$header->Cstm_No = $request->Sysub_Account;}
        if($request->Ac_Ty == 3){$header->Sup_No = $request->Sysub_Account;}
        if($request->Ac_Ty == 4){$header->Emp_No = $request->Sysub_Account;}
        $header->save();

        return 'done';
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

    public function convertToDateToHijri(Request $request){
        $hijri = date('Y-m-d',strtotime(\GeniusTS\HijriDate\Hijri::convertToHijri($request->Hijri)));
        return response()->json($hijri);
    }

    public function getSalesMan(Request $request){
        if($request->ajax()){
            $salesman = AstSalesman::where('Brn_No', $request->Brn_No)->get(['Slm_No', 'Slm_Nm'.ucfirst(session('lang'))]);
            return view('admin.banks.catch.salman', ['salesman' => $salesman]);
        }
    }

    public function createTrNo(Request $request){
        $flag = MainCompany::where('Cmp_No', $request->Cmp_No)->get(['JvAuto_Mnth'])->first();
        if($flag->JvAuto_Mnth == 1){
            return $this->createMonthAccNo(Carbon::now()->month);
        }
        else{
            $last_no = 0;
            if(count(GLjrnTrs::all()) == 0){
                $last_no = 0;
            }
            else{
                $last_trans = GLjrnTrs::where('Brn_No', $request->Brn_No)->orderBy('Tr_No', 'desc')->first();
                if($last_trans){
                    $last_no = $last_trans->Tr_No;
                }
                else{
                    $last_no = 0;
                }
            }
            return $last_no + 1;
        }
    }

    public function getSubAcc(Request $request){
        if($request->ajax()){
            //حسابات
            if($request->Acc_Ty == 1){
                $charts = MtsChartAc::where('Cmp_No', $request->Cmp_No)
                                    ->where('Level_Status', 1)
                                    ->where('Acc_Typ', 1)
                                    ->get(['Acc_No as no', 'Acc_Nm'.ucfirst(session('lang')).' as name']);
                return view('admin.banks.catch.SubAcc', ['subAccs' => $charts]);
            }
            // عملاء
            else if($request->Acc_Ty == 2){
                $customers = MTsCustomer::where('Cmp_No', $request->Cmp_No)
                                        ->where('Brn_No', $request->Brn_No)
                                        ->get(['Cstm_No as no', 'Cstm_Nm'.ucfirst(session('lang')).' as name']);
                return view('admin.banks.catch.SubAcc', ['subAccs' => $customers]);

            }
            // موردين
            else if($request->Acc_Ty == 3){
                $suppliers = MtsSuplir::where('Cmp_No', $request->Cmp_No)
                                        ->where('Brn_No', $request->Brn_No)
                                        ->get(['Sup_No as no', 'Sup_Nm'.ucfirst(session('lang')).' as name']);
                return view('admin.banks.catch.SubAcc', ['subAccs' => $suppliers]);
            }
            // موظفين
            else if($request->Acc_Ty == 4){

            }
        }
    }

    public function getMainAccNo(Request $request){
        if($request->ajax()){
            // حسابات
            if($request->Acc_Ty == 1){
                $AccNm = MtsChartAc::where('Cmp_No', $request->Cmp_No)
                                        ->where('Acc_No', $request->Acc_No)
                                        ->get(['Parnt_Acc', 'CostCntr_Flag as cc_flag', 'Costcntr_No as cc_no'])->first();
                $mainAccNm = MtsChartAc::where('Acc_No', $AccNm->Parnt_Acc)
                                        ->get(['Acc_Nm'.ucfirst(session('lang')).' as acc_name'])->first();
                $mainAccNo = MtsChartAc::where('Acc_No', $AccNm->Parnt_Acc)
                                        ->get(['Acc_No as acc_no'])->first();
                return response()->json(['mainAccNo' => $mainAccNo, 'mainAccNm' => $mainAccNm, 'AccNm' => $AccNm] );
            }
            // عملاء
            else if($request->Acc_Ty == 2){
                $mainAccNo = MainBranch::where('Brn_No', $request->Brn_No)->get(['Acc_Customer as acc_no'])->first();
                $mainAccNm = MtsChartAc::where('Acc_No', $mainAccNo->acc_no)->get(['Acc_Nm'.ucfirst(session('lang')).' as acc_name'])->first();
                return response()->json(['mainAccNo' => $mainAccNo, 'mainAccNm' => $mainAccNm]);
            }
            // موردين
            else if($request->Acc_Ty == 3){
                $mainAccNo = MainBranch::where('Brn_No', $request->Brn_No)->get(['Acc_Suplier as acc_no'])->first();
                $mainAccNm = MtsChartAc::where('Acc_No', $mainAccNo->acc_no)->get(['Acc_Nm'.ucfirst(session('lang')).' as acc_name'])->first();
                return response()->json(['mainAccNo' => $mainAccNo, 'mainAccNm' => $mainAccNm]);
            }
            // موظفين
            else if($request->Acc_Ty == 4){

            }
        }
    }

    public function createMonthAccNo($month){
        if(count(GLJrnal::all()) == 0){
            $Month_Jvno = $month.'01';
        }
        else{
            $gls = GLJrnal::where('Month_No', $month)->orderBy('Month_Jvno', 'desc')->get(['Month_Jvno'])->first();
            if($gls){
                $Month_Jvno = $gls->Month_Jvno + 1;
            }
            else{
                $Month_Jvno = $month.'01';
            }
        }
        return $Month_Jvno;
    }
}
