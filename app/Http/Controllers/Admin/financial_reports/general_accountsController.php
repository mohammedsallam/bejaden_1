<?php

namespace App\Http\Controllers\admin\financial_reports;

use App\Branches;
use App\limitations;
use App\limitationsType;
use App\Models\Admin\MainCompany;
use App\Models\Admin\MainBranch;
use App\Models\Admin\MtsChartAc;
use App\operation;
use App\receipts;
use App\receiptsType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class general_accountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function financial_reports()
    {


        return view('admin.financial_reports.financial_reports',compact(''));

    }
    public function general_accounts()
    {
        return view('admin.financial_reports.general_accounts.general_accounts');

    }
    public function account_statement()
    {

        $MainCompany = MainCompany::pluck('Cmp_Nm'.ucfirst(session('lang')),'ID_No');

        return view('admin.financial_reports.general_accounts.report.account_statement',compact('MainCompany'));

    }

    public function acc_state(Request $request)
    {
        if($request->ajax())
        {
            $mainCompany = $request->mainCompany;
            $mtschartac = MtsChartAc::where('Cmp_No',$mainCompany)->where('Acc_Typ',1)->pluck('Acc_Nm'.ucfirst(session('lang')),'ID_No');
            return view('admin.financial_reports.general_accounts.ajax.account_statement',compact('MainBranch','mainCompany','mtschartac'));
        }
    }
    public function details(Request $request)
    {

$maincompany = $request->maincompany;
$fromtree = $request->fromtree;
$totree = $request->totree;
$from = $request->from;
$to = $request->to;
if($request->ajax())
{
    $depart = MtsChartAc::where('Cmp_No',$maincompany)->where('ID_No', '>=', $fromtree)->where('ID_No', '<=', $totree)->pluck('ID_No')->toArray();
    @dd($depart);

    $receipts_id = receipts::where('branche_id',$branches)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)
        ->whereHas('receipts_type',function ($query) use ($operations,$depart,$fromtree,$totree){
            $query->where('tree_id', '>=', $fromtree)->where('tree_id', '<=', $totree);
        })
        ->pluck('id');
    $limitations_id = limitations::whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)
        ->whereHas('limitations_type',function ($query) use ($operations,$depart,$fromtree,$totree){
            $query->where('tree_id', '>=', $fromtree)->where('tree_id', '<=', $totree);
        })
        ->pluck('id');
    $hasTask = receiptsType::where('operation_id',$operations)->whereIn('tree_id',$depart)->whereIn('receipts_id',$receipts_id)->exists();
    $hasTask2 = limitationsType::whereIn('tree_id',$depart)->whereIn('limitations_id',$limitations_id)->exists();


}

    }
    public function trial_balance()
    {
        return view('admin.financial_reports.general_accounts.report.trial_balance');

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
