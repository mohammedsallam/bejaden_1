<?php

namespace App\Http\Controllers\Admin\Projcontractmfs;

use App\Branches;
use App\country;
use App\Models\Admin\Astsupctg;
use App\Models\Admin\MainBranch;
use App\Models\Admin\MainCompany;
use App\Models\Admin\MTsCustomer;
use App\Projcontractmfs;
use App\DataTables\ProjcontractmfsDataTable;
use App\Http\Controllers\Controller;
use App\projectcontract;
use Illuminate\Http\Request;

class ProjcontractmfsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProjcontractmfsDataTable $projcontractmfs)
    {
        return $projcontractmfs->render('admin.Projcontractmfs.index',['title'=>trans('admin.projects_contracts')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = country::pluck('country_name_'.session('lang'),'id');
        $astsupctg = Astsupctg::pluck('Supctg_Nm'.session('lang'),'ID_No');
        $branches = MainBranch::pluck('Brn_Nm'.session('lang'),'ID_No');
        $subscription = MTsCustomer::all()->pluck('name_'.session('lang'), 'ID_No');

        $company = MainCompany::pluck('Cmp_Nm'.ucfirst(session('lang')),'ID_No');
        $Projects = projectcontract::all()->pluck('name_'.session('lang'), 'id');

        return view('admin.Projcontractmfs.create',['title'=> trans('admin.add_project_contract'),'astsupctg' => $astsupctg,'company' => $company,'countries' => $countries,'branches' => $branches,'subscription' => $subscription,'Projects' => $Projects]);

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
     * @param  \App\Projcontractmfs  $projcontractmfs
     * @return \Illuminate\Http\Response
     */
    public function show(Projcontractmfs $projcontractmfs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Projcontractmfs  $projcontractmfs
     * @return \Illuminate\Http\Response
     */
    public function edit(Projcontractmfs $projcontractmfs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Projcontractmfs  $projcontractmfs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Projcontractmfs $projcontractmfs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Projcontractmfs  $projcontractmfs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Projcontractmfs $projcontractmfs)
    {
        //
    }
}
