<?php

namespace App\Http\Controllers\Admin\banks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
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
        $last_record = GLJrnal::latest()->get(['Tr_No'])->first();
        $companies = MainCompany::get(['Cmp_No', 'Cmp_Nm'.ucfirst(session('lang'))]);
        $flags = GLaccBnk::all();
        // مسموح بظهور البنوك و الصنودق فى سند القبض النقدى
        $banks = [];
        foreach($flags as $flag){
            if($flag->RcpCsh_Voucher == 1){
                array_push($banks, $flag);
            }
        }
        return view('admin.banks.catch.create', ['companies' => $companies, 'banks' => $banks, 'last_record' => $last_record]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $catch_data = json_decode($request->catch_data);
       
        // $validator = Validator::make($request->all(), [
        //     'Cmp_No' => 'required',
        //     'Brn_No' => 'required',
        //     'Tr_No' => 'sometimes',
        //     'Tr_Dt' => 'sometimes',
        //     'Tr_DtAr' => 'sometimes',
        //     'Jr_Ty' => 'sometimes',
        //     'Tr_Crncy' => 'sometimes',
        //     'Tr_ExchRat' => 'sometimes',
        //     'Tot_Amunt' => 'required',
        //     'Tr_TaxVal' => 'sometimes',
        //     'Rcpt_By' => 'sometimes',
        //     'Salman_No' => 'sometimes',
        //     'Ac_Ty' => 'required',
        //     'Sysub_Account' => 'required',
        //     'Tr_Cr' => 'required',
        //     'Dc_No' => 'sometimes',
        //     'Tr_Ds' => 'required',
        //     'Tr_Ds1' => 'sometimes',
        //     'Tr_Db_Acc_No' => 'sometimes',
        // ], [], [
        //     'Cmp_No' => trans('admin.Cmp_No'),
        //     'Brn_No' => trans('admin.branche'),
        //     'Tr_No' => trans('admin.number_of_receipt'),
        //     'Tr_Dt' => trans('admin.receipt_date'),
        //     'Tr_DtAr' => trans('admin.higri_date'),
        //     'Jr_Ty' => trans('admin.receipts_type'),
        //     'Tr_Crncy' => trans('admin.currency'),
        //     'Tr_ExchRat' => trans('admin.exchange_rate'),
        //     'Tot_Amunt' => trans('admin.amount'),
        //     'Tr_TaxVal' => trans('admin.tax'),
        //     'Rcpt_By' => trans('admin.Rcpt_By'),
        //     'Salman_No' => trans('admin.sales_officer2'),
        //     'Ac_Ty' => trans('admin.Level_Status'),
        //     // 'Sysub_Account' => trans('admin.'),
        //     'Tr_Cr' => trans('admin.amount_cr'),
        //     'Dc_No' => trans('admin.receipt_number'),
        //     'Tr_Ds' => trans('admin.note_ar'),
        //     'Tr_Ds1' => trans('admin.note_en'),
        //     'Tr_Db_Acc_No' => trans('admin.main_cache'),
        // ]);

        // dd($validator->messages());
            
        // if ($validator->fails()) {
        //     return response([
        //         'success' => false,
        //         'data' => $validator->messages(),
        //     ]);
        // }
        // else{
            //Create header
            if(count($catch_data) > 0){
                $last_index = count($catch_data) - 1;
                $header = GLJrnal::create([
                    'Cmp_No' => $catch_data[$last_index]->Cmp_No,
                    'Brn_No' => $catch_data[$last_index]->Brn_No,
                    'Jr_Ty' => 2,
                    'Tr_No' => $catch_data[$last_index]->Tr_No,
                    'Month_No' => Carbon::now()->month,
                    'Month_Jvno' => $catch_data[$last_index]->Tr_No,
                    'Doc_Type' => $catch_data[$last_index]->Doc_Type,
                    'Tr_Dt' => $catch_data[$last_index]->Tr_Dt,
                    'Tr_DtAr' => $catch_data[$last_index]->Tr_DtAr,
                    'Acc_No' => $catch_data[$last_index]->Acc_No,
                    'User_ID' => auth::user()->id,
                    'Ac_Ty' => $catch_data[$last_index]->Ac_Ty,
                    'Tr_Crncy' => $catch_data[$last_index]->Tr_Crncy,
                    'Tr_ExchRat' => $catch_data[$last_index]->Tr_ExchRat,
                    'Tr_TaxVal' => $catch_data[$last_index]->Tr_TaxVal,
                    'Salman_No' => $catch_data[$last_index]->Salman_No,
                    'Tot_Amunt' => $catch_data[$last_index]->Tr_Db_Db,
                    'Tr_Ds' => $catch_data[$last_index]->Tr_Ds,
                    'Tr_Ds1' => $catch_data[$last_index]->Tr_Ds1,
                    'Dc_No' => $catch_data[$last_index]->Dc_No,
                    'Chq_no' => $catch_data[$last_index]->Chq_no,
                    'Bnk_Nm' => $catch_data[$last_index]->Bnk_Nm,
                    'Issue_Dt' => $catch_data[$last_index]->Issue_Dt,
                    'Due_Issue_Dt' => $catch_data[$last_index]->Due_Issue_Dt,
                    'Rcpt_By' => $catch_data[$last_index]->Rcpt_By,
                    'Tr_Db' => $catch_data[$last_index]->Tr_Db_Db,
                    'Tr_Cr' => $catch_data[$last_index]->Tr_Cr_Db,
                ]);
        
                $header->Entr_Dt = $header->created_at->format('Y-m-d');
                $header->Entr_Time = $header->created_at->format('H:i:s');
                if($catch_data[$last_index]->Ac_Ty == 1){$header->Chrt_No = $catch_data[$last_index]->Sysub_Account;}
                if($catch_data[$last_index]->Ac_Ty == 2){$header->Cstm_No = $catch_data[$last_index]->Sysub_Account;}
                if($catch_data[$last_index]->Ac_Ty == 3){$header->Sup_No = $catch_data[$last_index]->Sysub_Account;}
                if($catch_data[$last_index]->Ac_Ty == 4){$header->Emp_No = $catch_data[$last_index]->Sysub_Account;}
                $header->save();
        
            }

            if($request->catch_data){
                foreach($catch_data as $data){

                    $debt = GLjrnTrs::where('Tr_No', $data->Tr_No)
                                    ->where('Ln_No', 1)->first();
                    if(!$debt){
                        // Create transaction debt
                        $trans_db = GLjrnTrs::create([
                            'Cmp_No' => $data->Cmp_No,
                            'Brn_No' => $data->Brn_No,
                            'Jr_Ty' => 2,
                            'Tr_No' => $data->Tr_No,
                            'Month_No' => Carbon::now()->month,
                            'Tr_Dt' => $data->Tr_Dt,
                            'Tr_DtAr' => $data->Tr_DtAr,
                            'Ac_Ty' => 1,
                            'Sysub_Account' => 0,
                            'Acc_No' => $data->Tr_Db_Acc_No,
                            'Tr_Db' => $catch_data[$last_index]->Tr_Db_Db,
                            'Tr_Cr' => 0.00,
                            'Dc_No' => $data->Dc_No,
                            'Tr_Ds' => $data->Tr_Ds,
                            'Tr_Ds1' => $data->Tr_Ds1,
                            'Doc_Type' => $data->Doc_Type,
                            'User_ID' => auth::user()->id,
                            'Rcpt_Value' => $data->Tot_Amunt,
                            'Ln_No' => 1,
                        ]);

                        $trans_db->Entr_Dt = $trans_db->created_at->format('Y-m-d');
                        $trans_db->Entr_Time = $trans_db->created_at->format('H:i:s');
                        $trans_db->save();
                    }
                    
                    //Create transaction credit
                    $trans_cr = GLjrnTrs::create([
                        'Cmp_No' => $data->Cmp_No,
                        'Brn_No' => $data->Brn_No,
                        'Jr_Ty' => 2,
                        'Tr_No' => $data->Tr_No,
                        'Month_No' => Carbon::now()->month,
                        'Tr_Dt' => $data->Tr_Dt,
                        'Tr_DtAr' => $data->Tr_DtAr,
                        'Ac_Ty' => $data->Ac_Ty,
                        'Sysub_Account' => $data->Sysub_Account,
                        'Acc_No' => $data->Acc_No,
                        'Tr_Db' => 0.00,
                        'Tr_Cr' => $data->Tr_Cr,
                        'Dc_No' => $data->Dc_No,
                        'Tr_Ds' => $data->Tr_Ds,
                        'Tr_Ds1' => $data->Tr_Ds1,
                        'Doc_Type' => $data->Doc_Type,
                        'User_ID' => auth::user()->id,
                        'Rcpt_Value' => $data->Tot_Amunt,
                        'Ln_No' => $data->Ln_No,
                    ]);
                    $trans_cr->Entr_Dt = $trans_cr->created_at->format('Y-m-d');
                    $trans_cr->Entr_Time = $trans_cr->created_at->format('H:i:s');
                    $trans_cr->save();
                }
            } 

        //     return response([
        //         'success' => true,
        //         'data' => $validator->messages(),
        //     ]);
        // } 
        
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
            $customer = MTsCustomer::where('Cstm_No', $request->Acc_No)->get(['Slm_No'])->first();
            $salesman = AstSalesman::where('Slm_No', $customer->Slm_No)->get(['Slm_No', 'Slm_Nm'.ucfirst(session('lang'))])->first();
            // return $salesman->{'Slm_Nm'.ucfirst(session('lang'))};
            return view('admin.banks.catch.salman', ['salesman' => $salesman]);
        }
    }

    public function createTrNo(Request $request){
        $flag = MainCompany::where('Cmp_No', $request->Cmp_No)->get(['JvAuto_Mnth'])->first();
        if($flag->JvAuto_Mnth == 1){
            // return 'a';
            return $this->createMonthAccNo(Carbon::now()->month, $request->Brn_No);
        }
        else{
            $last_no = 0;
            if(count(GLJrnal::all()) == 0){
                $last_no = 0;
            }
            else{
                $last_trans = GLJrnal::where('Brn_No', $request->Brn_No)->orderBy('Tr_No', 'desc')->first();
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

    public function createMonthAccNo($month, $Brn_No){
        if(count(GLJrnal::all()) == 0){
            $Month_Jvno = $month.'01';
        }
        else{
            $gls = GLJrnal::where('Month_No', $month)
                            ->where('Brn_No', $Brn_No)
                            ->orderBy('Month_Jvno', 'desc')->get(['Month_Jvno'])->first();
            if($gls){
                $Month_Jvno = $gls->Month_Jvno + 1;
            }
            else{
                $Month_Jvno = $month.'01';
            }
        }
        return $Month_Jvno;
    }

    public function getTaxValue(Request $request){
        if($request->ajax()){
            $cmp = MainCompany::where('Cmp_No', $request->Cmp_No)->get(['TaxExtra_Prct'])->first();
            if($cmp){
                return $cmp->TaxExtra_Prct;
            }
            else{
                return null;
            }
        }
    }
}
