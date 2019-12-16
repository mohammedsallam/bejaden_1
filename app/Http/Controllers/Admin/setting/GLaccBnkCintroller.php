<?php

namespace App\Http\Controllers\Admin\setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\MtsChartAc;
use App\Models\Admin\MainCompany;
use App\Models\Admin\GLaccBnk;

class GLaccBnkCintroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cmps = MainCompany::get(['Cmp_No', 'Cmp_Nm'.ucfirst(session('lang'))]);
        return view('admin.setting.accbank.create', ['cmps' => $cmps]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request,[
            'Cmp_No' => 'required',
            'Acc_No_Select' => 'required',
            'Acc_No' => 'sometimes',
            'Acc_NmAr' => 'sometimes',
            'Acc_NmEn' => 'sometimes',
            'Acc_Bank_No' => 'sometimes',
            'RcpCsh_Voucher' => 'sometimes',
            'PymCsh_voucher' => 'sometimes',
            'DB_Note' => 'sometimes',
            'RcpChk_Voucher' => 'sometimes',
            'PymChk_Voucher' => 'sometimes',
            'CR_Note' => 'sometimes',
            'Cash_Rpt' => 'sometimes',
        ],[],[
            'Cmp_No' => trans('admin.cmp_no'),
            'Acc_No_Select' => trans('admin.department'),
            'Acc_No' => trans('admin.account_number'),
            'Acc_NmAr' => trans('admin.account_name'),
            'Acc_NmEn' => trans('admin.subscriber_name_en'),
            'Acc_Bank_No' => trans('admin.Acc_Bank_No'),
            'RcpCsh_Voucher' => trans('admin.RcpCsh_Voucher'),
            'PymCsh_voucher' => trans('admin.cash_payment'),
            'DB_Note' => trans('admin.debt_notify'),
            'RcpChk_Voucher' => trans('admin.RcpChk_Voucher'),
            'PymChk_Voucher' => trans('admin.cheque_payment'),
            'CR_Note' => trans('admin.credit_notify'),
            'Cash_Rpt' => trans('admin.Cash_Rpt'),
        ]);

        $gb = GLaccBnk::create($data);
        if($request->RcpCsh_Voucher){$gb->update(['RcpCsh_Voucher' => 1]);}
        if($request->PymCsh_voucher){$gb->update(['PymCsh_voucher' => 1]);}
        if($request->DB_Note){$gb->update(['DB_Note' => 1]);}
        if($request->RcpChk_Voucher){$gb->update(['RcpChk_Voucher' => 1]);}
        if($request->PymChk_Voucher){$gb->update(['PymChk_Voucher' => 1]);}
        if($request->CR_Note){$gb->update(['CR_Note' => 1]);}
        if($request->Cash_Rpt){$gb->update(['Cash_Rpt' => 1]);}
        return redirect()->back()->with('success', trans('admin.success_add'));
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

    public function getAcc(Request $request){
        if($request->ajax()){
            $AccNm = MtsChartAc::where('Cmp_No', $request->Cmp_No)
                                ->where('Acc_No', $request->Acc_No)
                                ->where('Acc_Typ', $request->Acc_Ty)
                                ->get(['Acc_NmAr', 'Acc_NmEn'])->first();
            return response()->json(['Acc_NmAr' => $AccNm->Acc_NmAr, 'Acc_NmEn' => $AccNm->Acc_NmEn]);
        }
    }

    public function getCharts(Request $request){
        if($request->ajax()){
            $charts = MtsChartAc::where('Level_Status', 1)
                                ->where('Cmp_No', $request->Cmp_No)
                                ->get(['Acc_No', 'Acc_NmAr', 'Acc_NmEn']);
            return view('admin.setting.accbank.charts', ['charts' => $charts]);
        }
    }
}
