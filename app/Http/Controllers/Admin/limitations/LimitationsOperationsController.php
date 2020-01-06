<?php

namespace App\Http\Controllers\Admin\limitations;

use App\Models\Admin\AstSalesman;
use App\Models\Admin\GLJrnal;
use App\Models\Admin\MainBranch;
use App\Models\Admin\MainCompany;
use App\Models\Admin\MtsChartAc;
use App\Models\Admin\MTsCustomer;
use App\Models\Admin\MtsSuplir;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LimitationsOperationsController extends Controller
{
    public function branchForEdit(Request $request){
        if($request->ajax()){
            if($request->id){
                $gl = GLJrnal::where('Tr_No', $request->id)->get(['Brn_No'])->first();
                $branches = MainBranch::where('Cmp_No', $request->Cmp_No)->get();
                return view('admin.limitations.catch.branch', compact('branches', 'gl'));
            }
            else{
                $gl = null;
                $branches = MainBranch::where('Cmp_No', $request->Cmp_No)->get();
                return view('admin.limitations.catch.branch', compact('branches', 'gl'));
            }
        }
    }

    public function getCmpSalesMen(Request $request){
        if($request->ajax()){
            $salesman = AstSalesman::where('Cmp_No', $request->Cmp_No)->get(['Slm_No', 'Slm_Nm'.ucfirst(session('lang'))]);
            return view('admin.limitations.catch.salesman', compact('salesman'));
        }
    }

    public function getSalesMan(Request $request){
        if($request->ajax()){
            $customer = MTsCustomer::where('Cstm_No', $request->Acc_No)->get(['Slm_No'])->first();
            $salesman = AstSalesman::where('Slm_No', $customer->Slm_No)->get(['Slm_No', 'Slm_Nm'.ucfirst(session('lang'))])->first();
            // return $salesman->{'Slm_Nm'.ucfirst(session('lang'))};
            return view('admin.cash.catch.salman', ['salesman' => $salesman]);
        }
    }

    public function checkSetting(Request $request){
        if ($request->ajax()){
            $settings = MainCompany::find($request->Cmp_No);
            return response()->json(['settings' => $settings]);
        }
    }

    public function createTrNo(Request $request){


        if ($request->ajax() && ($request->Cmp_No || $request->Brn_No)){

            $flag = MainCompany::where('Cmp_No', $request->Cmp_No)->first();
            $last_no = 0;
            if($flag->JvAuto_Mnth == 1){
                return response()->json([
                    'last_no' => $this->createMonthAccNo(Carbon::now()->month, $request->Brn_No),
                    'activity' => $flag->Actvty_No,
                    'company' => $request->Cmp_No,
                    'branch' => $request->Brn_No,
                ]);
            }
            else{
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

            }

            return response()->json([
                'last_no' => $last_no + 1,
                'activity' => $flag->Actvty_No,
                'company' => $request->Cmp_No,
                'branch' => $request->Brn_No?$request->Brn_No:0,
            ]);
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

    public function getSubAcc(Request $request)
    {
        if ($request->ajax()) {
            //حسابات
            if ($request->Acc_Ty == 1) {
                $charts = MtsChartAc::where('Cmp_No', $request->Cmp_No)
                    ->where('Level_Status', 1)
                    ->where('Acc_Typ', 1)
                    ->get(['Acc_No as no', 'Acc_Nm' . ucfirst(session('lang')) . ' as name']);
                return view('admin.limitations.notice.SubAcc', ['subAccs' => $charts]);
            } // عملاء
            else if ($request->Acc_Ty == 2) {
                $customers = MTsCustomer::where('Cmp_No', $request->Cmp_No)
                    ->where('Brn_No', $request->Brn_No)
                    ->get(['Cstm_No as no', 'Cstm_Nm' . ucfirst(session('lang')) . ' as name']);
                return view('admin.limitations.notice.SubAcc', ['subAccs' => $customers]);

            } // موردين
            else if ($request->Acc_Ty == 3) {
                $suppliers = MtsSuplir::where('Cmp_No', $request->Cmp_No)
                    ->where('Brn_No', $request->Brn_No)
                    ->get(['Sup_No as no', 'Sup_Nm' . ucfirst(session('lang')) . ' as name']);
                return view('admin.limitations.notice.SubAcc', ['subAccs' => $suppliers]);
            } // موظفين
            else if ($request->Acc_Ty == 4) {
            }


        } else {
            if ($request->Acc_Ty == 1) {
                return 1;
                $charts = MtsChartAc::where('Cmp_No', $request->Cmp_No)
                    ->where('Level_Status', 1)
                    ->where('Acc_Typ', 1)
                    ->get(['Acc_No as no', 'Acc_Nm' . ucfirst(session('lang')) . ' as name']);
                return $charts;
            } // عملاء
            else if ($request->Acc_Ty == 2) {
                $customers = MTsCustomer::where('Cmp_No', $request->Cmp_No)
                    ->where('Brn_No', $request->Brn_No)
                    ->get(['Cstm_No as no', 'Cstm_Nm' . ucfirst(session('lang')) . ' as name']);
                return $customers;

            } // موردين
            else if ($request->Acc_Ty == 3) {
                return 3;
                $suppliers = MtsSuplir::where('Cmp_No', $request->Cmp_No)
                    ->where('Brn_No', $request->Brn_No)
                    ->get(['Sup_No as no', 'Sup_Nm' . ucfirst(session('lang')) . ' as name']);
                return $suppliers;
            } // موظفين
            else if ($request->Acc_Ty == 4) {
                return 4;
            }
        }
    }

    public function getSubAccByNumber(Request $request)
    {
        $Ac_Ty = $request->Ac_Ty;


        switch ($Ac_Ty){
            case "1":
                $charts = MtsChartAc::where('Cmp_No', $request->Cmp_No)
                    ->where('Level_Status', 1)
                    ->where('Acc_Typ', 1)
                    ->get(['Acc_No as no', 'Acc_Nm' . ucfirst(session('lang')) . ' as name']);
                return view('admin.limitations.notice.SubAcc', ['subAccs' => $charts]);
                break;
            case '2':
                $customers = MTsCustomer::where('Cmp_No', $request->Cmp_No)
                    ->where('Brn_No', $request->Brn_No)
                    ->get(['Cstm_No as no', 'Cstm_Nm' . ucfirst(session('lang')) . ' as name']);
                return view('admin.limitations.notice.SubAcc', ['subAccs' => $customers]);
                break;
            case '3':
                $suppliers = MtsSuplir::where('Cmp_No', $request->Cmp_No)
                    ->where('Brn_No', $request->Brn_No)
                    ->get(['Sup_No as no', 'Sup_Nm' . ucfirst(session('lang')) . ' as name']);
                return view('admin.limitations.notice.SubAcc', ['subAccs' => $suppliers]);
                break;
        }
    }

    public function validateCache(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'Cmp_No' => 'required',
                'Brn_No' => 'required',
                'Jr_Ty' => 'required',
                'Tr_No' => 'required',
                'Tr_Dt' => 'required',
                'Tr_DtAr'  => 'required',
                'Curncy_No' => 'required',
                'FTot_Amunt' => 'required',
                'Curncy_Rate' => 'required',
                'Tot_Amunt' => 'required',
                'Ac_Ty' => 'required',
                'Acc_No' => 'sometimes',
                'Sysub_Account' => 'required',
                'Tr_Cr' => 'sometimes',
                'Tr_Db' => 'sometimes',
                'Tr_Ds' => 'sometimes',
                'Tr_Ds1' => 'sometimes',
                'Dc_No' => 'required',
                'Costcntr_No' => 'sometimes',
                'Slm_No' => 'sometimes',
                'debit_sum',
                'credit_sum',
                'Ln_No',
            ], [], [
                'Cmp_No' => trans('admin.Cmp_No'),
                'Brn_No' => trans('admin.branche'),
                'Jr_Ty' => trans('admin.receipts_type'),
                'Tr_No' => trans('admin.number_of_receipt'),
                'Tr_Dt' => trans('admin.receipt_date'),
                'Tr_DtAr' => trans('admin.higri_date'),
                'Curncy_No' => trans('admin.currency'),
                'FTot_Amunt' => trans('admin.Linv_Net'),
                'Tot_Amunt' => trans('admin.amount'),
                'Salman_No' => trans('admin.sales_officer2'),
                'Ac_Ty' => trans('admin.Level_Status'),
                'Sysub_Account' => trans('admin.account_number'),
                'Tr_Cr' => trans('admin.amount_cr'),
                'Dc_No' => trans('admin.receipt_number'),
                'Tr_Ds' => trans('admin.note_ar'),
                'Tr_Ds1' => trans('admin.note_en'),
            ]);

            if ($validator->fails()) {
                return response([
                    'success' => false,
                    'data' => $validator->messages(),
                ]);
            } else {
                return response([
                    'success' => true,
                    'data' => $validator->messages(),
                ]);
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

}
