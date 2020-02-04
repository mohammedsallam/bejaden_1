<?php

namespace App\Http\Controllers\Admin\sales_invoices;

use App\DataTables\salesInvoicesDataTable;
use App\Models\Admin\ActivityTypes;
use App\Models\Admin\MainBranch;
use App\Models\Admin\MainCompany;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalesInvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param salesInvoicesDataTable $table
     * @return \Illuminate\Http\Response
     */
    public function index(salesInvoicesDataTable $table)
    {
        return $table->render('admin.sales_invoices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if(session('Cmp_No') == -1){
            $branches = MainBranch::with('stores')->get();
            $companies = MainCompany::all();
            $activity = ActivityTypes::all();
        } else {
            $branches = MainBranch::where('Cmp_No', session('Cmp_No'))->with('stores')->get();
            $companies = MainCompany::where('Cmp_No', session('Cmp_No'))->get();
            $activity = ActivityTypes::where('Cmp_No', session('Cmp_No'))->get();
        }

        return view('admin.sales_invoices.create', compact(['branches', 'companies', 'activity']));
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

    public function getActivity(Request $request)
    {
        if ($request->ajax() && $request->Cmp_No){
            $company = MainCompany::find($request->Cmp_No);
            return response()->json(['id' => $company->activity->Actvty_No, 'name' => $company->activity->{'Name_'.ucfirst(session('lang'))} ]);
        }

    }
}
