<?php

namespace App\Http\Controllers\Admin\sales_invoices;

use App\DataTables\salesInvoicesDataTable;
use App\Models\Admin\ActivityTypes;
use App\Models\Admin\AstSalesman;
use App\Models\Admin\InvLoddtl;
use App\Models\Admin\InvLodhdr;
use App\Models\Admin\MainBranch;
use App\Models\Admin\MainCompany;
use App\Models\Admin\MtsItmfsunit;
use App\Models\Admin\MtsItmmfs;
use App\Models\Admin\PjbranchDlv;
use App\Models\Admin\Units;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Promise\all;

class SalesInvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param salesInvoicesDataTable $table
     * @return Response
     */
    public function index(salesInvoicesDataTable $table)
    {
        return $table->render('admin.sales_invoices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $last = InvLodhdr::latest()->first();
        if(session('Cmp_No') == -1){
            $branches = MainBranch::with('stores')->get();
            $companies = MainCompany::all();
            $activity = ActivityTypes::all();
        }
        else {
            $branches = MainBranch::where('Cmp_No', session('Cmp_No'))->with('stores')->get();
            $companies = MainCompany::where('Cmp_No', session('Cmp_No'))->get();
            $activity = ActivityTypereturnItemInfos::where('Cmp_No', session('Cmp_No'))->get();
        }

        $items = MtsItmmfs::where('Itm_Parnt', '!=', null)->get();
        $units = Units::all();

        return view('admin.sales_invoices.create', compact(['branches', 'companies', 'activity', 'last', 'items', 'units']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        if ($request->ajax() && $request->requestType == 'createHeader'){
            $validation = Validator::make($request->all(), [
                'Cmp_No' => 'required',
                'Actvty_No' => 'required',
                'Brn_No' => 'required',
                'Slm_No' => 'required',
                'Cstm_No' => 'required',
                'Dlv_Stor' => 'required',
                'Doc_Dt' => 'required',
                'Doc_DtAr' => 'required',
                'Doc_No' => 'required',
                'SubCstm_Filno' => 'required',
                'Pym_No' => 'required',
                'Reftyp_No' => 'sometimes',
                'Ref_No' => 'sometimes',
                'Credit_Days' => 'required',
                'Pym_Dt' => 'required',
                'Tax_Allow' => 'sometimes',
                'Notes' => 'required',
                'Notes1' => 'sometimes',
            ],[], [
                'Cmp_No' => trans('admin.na_Comp'),
                'Actvty_No' => trans('admin.activity'),
                'Brn_No' => trans('admin.Brn_No'),
                'Slm_No' => trans('admin.Slm_No'),
                'Cstm_No' => trans('admin.Cstm_No'),
                'Dlv_Stor' => trans('admin.Dlv_Stor'),
                'Doc_Dt' => trans('admin.Doc_Dt'),
                'Doc_DtAr' => trans('admin.Doc_DtAr'),
                'Doc_No' => trans('admin.Doc_No'),
                'SubCstm_Filno' => trans('admin.SubCstm_Filno'),
                'Pym_No' => trans('admin.Pym_No'),
                'Reftyp_No' => trans('admin.Reftyp_No'),
                'Ref_No' => trans('admin.Ref_No'),
                'Credit_Days' => trans('admin.Credit_Days'),
                'Pym_Dt' => trans('admin.Pym_Dt'),
                'Notes' => trans('admin.notes'),
            ]);

            if ($validation->fails()){
                return  response()->json(['status' => 0, 'message' => $validation->getMessageBag()->first()]);
            } else {
                $header = InvLodhdr::where('Doc_No', $request->Doc_No)->first();
                if($header == null){
                    InvLodhdr::create($request->all());
                } else {
                    $header->update($request->all());
                    if (!$request->has(['Tax_Allow'])){
                        $header->update(['Tax_Allow' => null]);
                    }
                }

                return  response()->json(['status' => 1, 'message' => trans('admin.save_success')]);

            }
        }
    }

    public function createNewLine(Request $request)
    {
        if ($request->ajax()){
            $validation = Validator::make($request->all(), [
                'Ln_No' => 'required',
                'Cmp_No' => 'required',
                'Actvty_No' => 'required',
                'Brn_No' => 'required',
                'Slm_No' => 'required',
                'Cstm_No' => 'required',
                'Dlv_Stor' => 'required',
                'Pym_No' => 'required',
                'Reftyp_No' => 'sometimes',
                'Ref_No' => 'sometimes',
                'Doc_No' => 'required',
                'Doc_Dt' => 'required',
                'Doc_DtAr' => 'required',
                'Itm_No' => 'required',
                'Unit_No' => 'required',
                'Loc_No' => 'sometimes',
                'Qty' => 'required',
                'Itm_Sal' => 'required',
                'Exp_Date' => 'required',
                'Batch_No' => 'required',
                'Disc1_Prct' => 'sometimes',
                'Disc1_Val' => 'sometimes',
                'Taxp_ExtraDtl' => 'sometimes',
                'Taxv_ExtraDtl' => 'sometimes',

                'Tot_Sal' => 'sometimes',
                'Tot_Disc' => 'sometimes',
                'Tot_Prct' => 'sometimes',
                'Tot_ODisc' => 'sometimes',
                'Tot_OPrct' => 'sometimes',
                'Taxp_Extra' => 'sometimes',
                'Taxv_Extra' => 'sometimes',
                'Net' => 'sometimes',
            ],[], [
                'Cmp_No' => trans('admin.na_Comp'),
                'Actvty_No' => trans('admin.activity'),
                'Brn_No' => trans('admin.Brn_No'),
                'Slm_No' => trans('admin.Slm_No'),
                'Cstm_No' => trans('admin.Cstm_No'),
                'Dlv_Stor' => trans('admin.Dlv_Stor'),
                'Pym_No' => trans('admin.Pym_No'),
                'Reftyp_No' => trans('admin.Reftyp_No'),
                'Ref_No' => trans('admin.Ref_No'),
                'Doc_No' => trans('admin.Doc_No'),
                'Doc_Dt' => trans('admin.Doc_Dt'),
                'Doc_DtAr' => trans('admin.Doc_DtAr'),
                'Itm_No' => trans('admin.item_no'),
                'Unit_No' => trans('admin.unit_no'),
                'Qty' => trans('admin.Qty'),
                'Itm_Sal' => trans('admin.Itm_Sal'),
                'Exp_Date' => trans('admin.Exp_Date'),
                'Batch_No' => trans('admin.Batch_No'),
            ]);

            if ($validation->fails()){
                return  response()->json(['status' => 0, 'message' => $validation->getMessageBag()->first()]);
            } else {
                $detail = InvLoddtl::where('Ln_No', $request->Ln_No)->first();
                if($detail == null){
                    InvLoddtl::create($request->except([
                        'Tot_Sal',
                        'Tot_Disc',
                        'Tot_Prct',
                        'Tot_ODisc',
                        'Tot_OPrct',
                        'Taxp_Extra',
                        'Taxv_Extra',
                        'Net',
                    ]));
                } else {
                    $detail->update($request->except([
                        'Tot_Sal',
                        'Tot_Disc',
                        'Tot_Prct',
                        'Tot_ODisc',
                        'Tot_OPrct',
                        'Taxp_Extra',
                        'Taxv_Extra',
                        'Net',
                        ]));
                }

                $header = InvLodhdr::where('Doc_No', $request->Doc_No)->first();

                $header->update($request->all([
                    'Tot_Sal',
                    'Tot_Disc',
                    'Tot_Prct',
                    'Tot_ODisc',
                    'Tot_OPrct',
//                    'Taxp_Extra',
                    'Taxv_Extra',
                    'Net',
                ]));

                $header->update(['status' => 1]);


                return  response()->json(['status' => 1, 'message' => trans('admin.save_success')]);

            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
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
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
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

    public function returnCountOfDays(Request $request)
    {
        if ($request->ajax()){
            if($request->DateEn || $request->daysNo){
                $daysToSec = strtotime($request->DateEn)+($request->daysNo*24*60*60);
                $daysToDate = date('Y-m-d', $daysToSec);
                return response()->json(['date' => $daysToDate]);
            }

        }
    }

    public function createNewRow(Request $request)
    {
        if ($request->ajax()){
            $items = MtsItmmfs::where('Itm_Parnt', '!=', null)->get();
            $units = Units::all();
            $row = $request->rowNo;
            return view('admin.sales_invoices.create_new_row', compact(['items', 'units', 'row']));
        }
    }

    public function returnItemInfo(Request $request)
    {
        if ($request->ajax() && $request->Itm_No){
            $item = MtsItmmfs::where('Itm_No', $request->Itm_No)->first();
            if ($item != null){

                $unitNo = $item->units->pluck('Unit_No');
                $units = Units::whereIn('Unit_No', $unitNo)->get();
                return response()->json([
                    'units' => $units,
                    'price' => $item->Itm_Sal1,
                    'quantity' => $item->MaxQty_SaL,
                ]);
            }
        }
    }

    public function returnUnitPrice(Request $request)
    {
        if ($request->ajax() && ($request->Itm_No && $request->Unit_No)){
            $unit = MtsItmfsunit::where('Itm_No', $request->Itm_No)->where('Unit_No', $request->Unit_No)->first();
            if ($unit != null){
                return response()->json([
                    'price' => $unit->Unit_Sal1,
                ]);
            }
        }
    }

    public function deleteLine(Request $request)
    {
//        return response()->json(['status' => 1]);
        $line = InvLoddtl::where('Ln_No', $request->Ln_No)->first();
        if ($line != null){
            $line->delete();
            $header = InvLodhdr::where('Doc_No', $request->Doc_No)->first();
            if ($header != null){
                $header->update([
                    'Tot_Sal' => $header->Tot_Sal - $request->lineTotal,
                    'status' => count($header->details) == 0 ? 0 : 1
                ]);
            }

            return response()->json(['status' => 1]);
        }
    }
}
