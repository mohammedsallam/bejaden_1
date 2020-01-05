<?php

namespace App\Http\Controllers\admin\financial_reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
