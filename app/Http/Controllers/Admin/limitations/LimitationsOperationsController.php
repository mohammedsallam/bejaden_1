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

    public function checkSetting(Request $request){
        if ($request->ajax()){
            $settings = MainCompany::find($request->Cmp_No);
            return response()->json(['settings' => $settings]);
        }
    }

    public function createTrNo(Request $request){
        if ($request->ajax() && ($request->Cmp_No && $request->Brn_No)){
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
