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
use App\Models\Admin\MtsCostcntr;
use Carbon\Carbon;
use Auth;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class ReceiptCatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(catchDataTable $catch)
    {
        if(session('Cmp_No') == -1){
            $cmps = MainCompany::get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
            // $gls = GLJrnal::where('Jr_Ty', 2)->paginate(6);
        }
        else{
            $cmps = MainCompany::where('Cmp_No', session('Cmp_No'))->get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
            // $gls = GLJrnal::where('Jr_Ty', 2)->where('Cmp_No', session('Cmp_No'))->paginate(6);
        }
        // return view('admin.banks.catch.index', ['companies' => $cmps, 'gls' => $gls]);
        return $catch->render('admin.banks.catch.index',['title'=>trans('admin.catch_receipt'), 'companies' => $cmps]);
    }

    public function getRecieptByCmp(Request $request){
        session(['recpt_cmp_no' => $request->Cmp_No]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $last_record = GLJrnal::latest()->get(['Tr_No'])->first();
        if(session('Cmp_No') == -1){
            $cmps = MainCompany::get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
        }
        else{
            $cmps = MainCompany::where('Cmp_No', session('Cmp_No'))->get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No'])->first();
        }
        $flags = GLaccBnk::all();
        // مسموح بظهور البنوك و الصنودق فى سند القبض النقدى
        $banks = [];
        $cost_center = MtsCostcntr::where('Level_Status', 0)->get(['Costcntr_No', 'Costcntr_Nm'.session('lang')]);
        foreach($flags as $flag){
            if($flag->RcpCsh_Voucher == 1){
                array_push($banks, $flag);
            }
        }
        return view('admin.banks.catch.create', ['companies' => $cmps, 'banks' => $banks, 'last_record' => $last_record,
                                                'cost_center' => $cost_center]);
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
                'Tot_Amunt' => $catch_data[$last_index]->Tr_Db_Db,
                'Tr_Ds' => $catch_data[$last_index]->Tr_Ds_Db,
                'Tr_Ds1' => $catch_data[$last_index]->Tr_Ds_Db,
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
                        'Tr_Ds' => $data->Tr_Ds_Db,
                        'Tr_Ds1' => $data->Tr_Ds_Db,
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
                    'Salman_No' => $data->Salman_No,
                ]);
                $trans_cr->Entr_Dt = $trans_cr->created_at->format('Y-m-d');
                $trans_cr->Entr_Time = $trans_cr->created_at->format('H:i:s');
                $trans_cr->save();

            }
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gl = GLJrnal::where('Tr_No', $id)->first();
        $gltrns = GLjrnTrs::where('Tr_No', $id)->get();
        $debt_acc_no = GLjrnTrs::where('Sysub_Account', 0)
                                ->where('Tr_No', $gl->Tr_No)
                                ->where('Ln_No', 1)
                                ->pluck('Acc_No')->first();
        $debt = MtsChartAc::where('Acc_No', $debt_acc_no)->pluck('Acc_Nm'.ucfirst(session('lang')))->first();
        $cmp = MainCompany::where('Cmp_No', $gl->Cmp_No)->get(['License_No', 'Cmp_Nm'.ucfirst(session('lang'))])->first();
        $brn = MainBranch::where('Cmp_No', $gl->Cmp_No)->get(['Brn_Nm'.ucfirst(session('lang'))])->first();
        return view('admin.banks.catch.show', ['gl' => $gl, 'gltrns' => $gltrns, 'cmp' => $cmp, 'brn' => $brn, 'debt' => $debt]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(session('Cmp_No') == -1){
            $cmps = MainCompany::get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
        }
        else{
            $cmps = MainCompany::where('Cmp_No', session('Cmp_No'))->get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No'])->first();
        }
        $gl = GLJrnal::where('Tr_No', $id)->first();
        // $salesman = AstSalesman::where('Slm_No', $gl->Salman_No)->pluck('Slm_Nm'.ucfirst(session('lang')))->first();
        $gltrns = GLjrnTrs::where('Tr_No', $id)->get();
        $flags = GLaccBnk::all();
        // مسموح بظهور البنوك و الصنودق فى سند القبض النقدى
        $banks = [];
        foreach($flags as $flag){
            if($flag->RcpCsh_Voucher == 1){
                array_push($banks, $flag);
            }
        }

        return view('admin.banks.catch.edit', compact('gl', 'gltrns', 'cmps', 'banks'));
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
    }

    public function updateTrns(Request $request){

        $updated_data = json_decode($request->catch_data);

        if(count($updated_data) > 0){
            foreach($updated_data as $data){
                $trns = GLjrnTrs::where('Tr_No', $data->Tr_No)
                                ->where('Ln_No', $data->Ln_No)->first();
                //Update transaction credit
                $trns->update([
                    'Cmp_No' => $data->Cmp_No,
                    'Brn_No' => $data->Brn_No,
                    'Jr_Ty' => 2,
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
                    'Salman_No' => $data->Salman_No,
                    'updated_at' => carbon::now(),
                ]);
            }

            //update debt Tot_Amunt
            //1- get all credit lines - sum credit money
            $trnses = GLjrnTrs::where('Tr_No', $updated_data[0]->Tr_No)
                                ->where('Ln_No' , '>', 1)->get();
            if($trnses){
                $total = 0;
                foreach($trnses as $trns){
                    $total += $trns->Tr_Cr;
                }

                //2- get debt line - update money with new total
                $debt = GLjrnTrs::where('Tr_No', $trnses[0]->Tr_No)
                                ->where('Ln_No', 1)->first();
                $debt->update(['Tr_Db' => $total]);


                $gl_debt = GLJrnal::where('Tr_No', $trnses[0]->Tr_No)->first();
                $gl_debt->update([
                    'Tr_Db' => $total,
                    'Tr_Cr' => $total,
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //حذف كل سطور السند
        $gl = GLJrnal::where('ID_No', $id)->get(['Tr_No', 'status'])->first();
        $trns = GLjrnTrs::where('Tr_No', $gl->Tr_No)->get();
        if($trns && count($trns) > 0){
            foreach($trn as $trn){
                $trn->delete();
            }
        }
        $gl->status = 1;
        $gl->save();
    }

    //Delete trans line from GLjrnTrs
    public function deleteTrns(Request $request){
        if($request->ajax()){
            $trns = GLjrnTrs::where('Tr_No', $request->Tr_No)->get();
            //حذف السطر المطلوب فقط اذا كان عدد سطور السند اكبر من سطرين
            if($trns && count($trns) > 2){
                if($request->Ln_No != -1){
                    GLjrnTrs::where('Tr_No', $request->Tr_No)
                            ->where('Ln_No', $request->Ln_No)->first()->delete();
                }
            }
            //حذف كل تفاصيل السند اذا كان عدد السطور  سطرين فاقل
            else if($trns && count($trns) <= 2){
                foreach($trns as $trn){
                    $trn->delete();
                }
            }

            $gl = GLJrnal::where('Tr_No', $request->Tr_No)->first();
            $gl->status = 1;
            $gl->save();
        }
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
        else{
            if($request->Acc_Ty == 1){
                $charts = MtsChartAc::where('Cmp_No', $request->Cmp_No)
                                    ->where('Level_Status', 1)
                                    ->where('Acc_Typ', 1)
                                    ->get(['Acc_No as no', 'Acc_Nm'.ucfirst(session('lang')).' as name']);
                return $charts;
            }
            // عملاء
            else if($request->Acc_Ty == 2){
                $customers = MTsCustomer::where('Cmp_No', $request->Cmp_No)
                                        ->where('Brn_No', $request->Brn_No)
                                        ->get(['Cstm_No as no', 'Cstm_Nm'.ucfirst(session('lang')).' as name']);
                return $customers;

            }
            // موردين
            else if($request->Acc_Ty == 3){
                $suppliers = MtsSuplir::where('Cmp_No', $request->Cmp_No)
                                        ->where('Brn_No', $request->Brn_No)
                                        ->get(['Sup_No as no', 'Sup_Nm'.ucfirst(session('lang')).' as name']);
                return $suppliers;
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

    public function validateCache(Request $request){
        if($request->ajax()){
            $validator = Validator::make($request->all(), [
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

            // dd($validator->messages());

            if ($validator->fails()) {
                return response([
                    'success' => false,
                    'data' => $validator->messages(),
                ]);
            }
            else{
                    return response([
                    'success' => true,
                    'data' => $validator->messages(),
                ]);
            }
        }
    }

    public function getCatchRecpt(Request $request){
        if($request->ajax()){
            $gls = GLJrnal::where('Jr_Ty', 2)->where('Cmp_No', $request->Cmp_No)->paginate(6);
            return view('admin.banks.catch.rcpts', ['gls' => $gls]);
        }
    }

    public function branchForEdit(Request $request){
        if($request->ajax()){
            if($request->id){
                $gl = GLJrnal::where('Tr_No', $request->id)->get(['Brn_No'])->first();
                $branches = MainBranch::where('Cmp_No', $request->Cmp_No)->get(['Brn_No', 'Brn_Nm'.ucfirst(session('lang'))]);
                return view('admin.banks.catch.branch', compact('branches', 'gl'));
            }
            else{
                $gl = null;
                $branches = MainBranch::where('Cmp_No', $request->Cmp_No)->get(['Brn_No', 'Brn_Nm'.ucfirst(session('lang'))]);
                return view('admin.banks.catch.branch', compact('branches', 'gl'));
            }
        }
    }

    public function getRcptDetails(Request $request){
        if($request->ajax()){
            $trns = GLjrnTrs::where('Ln_No', $request->Ln_No)
                            ->where('Tr_No', $request->Tr_No)
                            ->first();

            $new_request = new Request;
            $new_request->Acc_Ty = $trns->Ac_Ty;
            $new_request->Cmp_No = $trns->Cmp_No;
            $new_request->Brn_No = $trns->Brn_No;
            $subAccs = $this->getSubAcc($new_request);

            $cost_center = MtsCostcntr::where('Level_Status', 0)->get(['Costcntr_No', 'Costcntr_Nm'.session('lang')]);

            return view('admin.banks.catch.credit_data', compact('trns', 'subAccs', 'cost_center'));
        }
    }

    public function print($id){
        $gl = GLJrnal::where('Tr_No',$id)->first();
        $gltrns = GLjrnTrs::where('Tr_No',$id)->get();
        $config = ['instanceConfigurator' => function($mpdf) {
            $mpdf->SetHTMLFooter('
            <div dir="ltr" style="text-align: right">{DATE j-m-Y H:m}</div>
            <div dir="ltr" style="text-align: center">{PAGENO} of {nbpg}</div>'
            );
        }];
        $pdf = PDF::loadView('admin.banks.invoice.pdf.multi_report', compact('gl', 'gltrns'),[],['format' => 'A4'], $config);
        return $pdf->stream();
        // $receiptsData = $receipts->receiptsData;
        // $data = $receipts->receipts_type;
        // if (count($data) > 1){
        //     if ($receipts->limitationReceipts['limitationReceiptsId'] == 0 || $receipts->limitationReceipts['limitationReceiptsId'] == 1){

        //         $pdf = PDF::loadView('admin.banks.invoice.pdf.multi_report', compact('receiptsData','data','receipts'),[],['format' => 'A4'], $config);
        //         return $pdf->stream();
        //     }else{
        //         $config = ['instanceConfigurator' => function($mpdf) {
        //             $mpdf->SetHTMLFooter('
        //             <div dir="ltr" style="text-align: right">{DATE j-m-Y H:m}</div>
        //             <div dir="ltr" style="text-align: center">{PAGENO} of {nbpg}</div>'
        //             );
        //         }];
        //         $pdf = PDF::loadView('admin.banks.invoice.pdf.multi_report2', compact('receiptsData','data','receipts'),[],['format' => 'A4'], $config);
        //         return $pdf->stream();
        //     }
        // }elseif(count($data) == 1){
        //     if ($receipts->limitationReceipts['limitationReceiptsId'] == 0 || $receipts->limitationReceipts['limitationReceiptsId'] == 1){
        //         $config = ['instanceConfigurator' => function($mpdf) {
        //             $mpdf->SetHTMLFooter('
        //             <div dir="ltr" style="text-align: right">{DATE j-m-Y H:m}</div>
        //             <div dir="ltr" style="text-align: center">{PAGENO} of {nbpg}</div>'
        //             );
        //         }];
        //         $pdf = PDF::loadView('admin.banks.invoice.pdf.report', compact('receiptsData','data','receipts'),[],['format' => 'A4'], $config);
        //         return $pdf->stream();
        //     }else{
        //         $config = ['instanceConfigurator' => function($mpdf) {
        //             $mpdf->SetHTMLFooter('
        //             <div dir="ltr" style="text-align: right">{DATE j-m-Y H:m}</div>
        //             <div dir="ltr" style="text-align: center">{PAGENO} of {nbpg}</div>'
        //             );
        //         }];
        //         $pdf = PDF::loadView('admin.banks.invoice.pdf.report2', compact('receiptsData','data','receipts'),[],['format' => 'A4'], $config);
        //         return $pdf->stream();
        //     }
        // }

    }
}
