<?php

namespace App\Http\Controllers\admin\financial_reports;

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
        return view('admin.financial_reports.financial_reports');

    }
    public function general_accounts()
    {
        return view('admin.financial_reports.general_accounts.general_accounts');

    }
    public function account_statement()
    {
        return view('admin.financial_reports.general_accounts.report.account_statement');

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
