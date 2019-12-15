<?php

namespace App\Http\Controllers\Admin\banks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\catchDataTable;
use App\Models\Admin\MainCompany;
use App\Models\Admin\AstSalesman;
use App\Models\Admin\GLjrnTrs;
use App\Models\Admin\MTsCustomer;
use App\Models\Admin\MainBranch;
use App\Models\Admin\MtsChartAc;

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
        return view('admin.banks.catch.create', ['companies' => $companies]);
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

    public function getCustomers(Request $request){
        if($request->ajax()){
            $customers = MTsCustomer::where('Cmp_No', $request->Cmp_No)
                                    ->where('Brn_No', $request->Brn_No)
                                    ->get(['Cstm_No', 'Cstm_Nm'.ucfirst(session('lang'))]);
            $mainAccNo = MainBranch::where('Brn_No', $request->Brn_No)->get(['Acc_Customer'])->first();
            $mainAccNm = MtsChartAc::where('Acc_No', $mainAccNo->Acc_Customer)->get(['Acc_Nm'.ucfirst(session('lang'))]);
            return response()->json(['customers' => $customers, 'mainAccNo' => $mainAccNo, 'mainAccNm' => $mainAccNm]);
        }
    }
}
