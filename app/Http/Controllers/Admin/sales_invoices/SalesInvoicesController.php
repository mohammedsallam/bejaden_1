<?php

namespace App\Http\Controllers\Admin\sales_invoices;

use App\DataTables\salesInvoicesDataTable;
use App\Models\Admin\ActivityTypes;
use App\Models\Admin\AstSalesman;
use App\Models\Admin\InvLodhdr;
use App\Models\Admin\MainBranch;
use App\Models\Admin\MainCompany;
use App\Models\Admin\PjbranchDlv;
use Carbon\Carbon;
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
    public function create(Request $request)
    {
        $last = InvLodhdr::latest()->first();
        if ($request->ajax()){
            if ($request->Cmp_No){
                InvLodhdr::where('Brn_No', null)->delete();
                InvLodhdr::create([
                    'Cmp_No' => $request->Cmp_No,
                    'Custm_Inv' => $request->Custm_Inv,
                    'Actvty_No' => $request->Actvty_No,
                    'Brn_No' => $request->Brn_No,
                    'Slm_No' => $request->Slm_No,
                    'Dlv_Stor' => $request->Dlv_Stor,
                    'Cstm_No' => $request->Cstm_No,
                ]);
            }
            elseif($request->Custm_Inv){
                InvLodhdr::where('Brn_No', null)->delete();
                $last = InvLodhdr::latest()->first();
                $new = InvLodhdr::create(['Custm_Inv' => $last == null ? 1 : $request->Custm_Inv+1]);
                return response()->json(['Custm_Inv' => $new->Custm_Inv]);
            }
            elseif($request->Doc_Dt || $request->Credit_Days){
                $dataDayes = Carbon::createFromDate($request->Credit_Days);

                dd($dataDayes);
            }

        }

        if(session('Cmp_No') == -1){
            $branches = MainBranch::with('stores')->get();
            $companies = MainCompany::all();
            $activity = ActivityTypes::all();
        }
        else {
            $branches = MainBranch::where('Cmp_No', session('Cmp_No'))->with('stores')->get();
            $companies = MainCompany::where('Cmp_No', session('Cmp_No'))->get();
            $activity = ActivityTypes::where('Cmp_No', session('Cmp_No'))->get();
        }

        return view('admin.sales_invoices.create', compact(['branches', 'companies', 'activity', 'last']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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

    public function getActivityCustomer(Request $request)
    {
        if ($request->ajax()){
            if ($request->Cmp_No){
                $company = MainCompany::where('Cmp_No', $request->Cmp_No)->first();
                return response()->json([
                    'activity_id' => $company->activity->Actvty_No,
                    'activity_name' => $company->activity->{'Name_'.ucfirst(session('lang'))},
                    'customers' => $company->customers,
                    'branches' => $company->branches,
                ]);
            } elseif($request->Brn_No){
                $stores = PjbranchDlv::where('Brn_No', $request->Brn_No)->get();
                $salesMan = AstSalesman::where('Brn_No', $request->Brn_No)->get();
                return response()->json([
                    'stores' => $stores,
                    'salesMan' => $salesMan,
                ]);
            }
        }

    }
}
