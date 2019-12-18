<?php

namespace App\Http\Controllers\Admin\cc;


use App\Branches;
use App\Models\Admin\MtsCostcntr;
use App\Project;
use App\Contractors;

use App\employee;
use App\Department;
use App\glcc;
use App\limitations;
use App\Http\Controllers\Controller;
use App\levels;
use App\limitationReceipts;
use App\limitationsType;
use App\operation;
use App\pjitmmsfl;
use App\receipts;
use App\receiptsData;
use App\receiptsType;
use App\supplier;
use App\Models\Admin\MtsClosAcc;
use App\Models\Admin\MainCompany;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Up;


class CcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Department $department)
    {
        $chart = MtsCostcntr::get(['Costcntr_Nm'.ucfirst(session('lang')), 'Costcntr_No']);
        if(count($chart) > 0){
            if(session('Cmp_No') == -1){
                $cmps = MainCompany::get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
            }
            else{
                $cmps = MainCompany::where('Cmp_No', session('Cmp_No'))->get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No'])->first();
            }
            $chart_item = MtsCostcntr::first();
            $total = $this->getTotalTransaction($chart_item);
            return view('admin.cc.index', ['title' => trans('admin.cc'),
                'cmps' => $cmps, 'chart_item' => $chart_item, 'total' => $total]);
        }
        else{
            if(session('Cmp_No') == -1){
                $cmps = MainCompany::get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
            }
            else{
                $cmps = MainCompany::where('Cmp_No', session('Cmp_No'))->get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No'])->first();
            }
            $Costcntr_No = $this->createAccNo(0);
            return view('admin.cc.init_chart', ['title' => trans('admin.cc')
                , 'cmps' => $cmps, 'Costcntr_No' => $Costcntr_No]);
        }

    }

    public function createNewAcc(Request $request){
        if($request->ajax()){
            if($request->parent){
                $parent = MtsCostcntr::where('Costcntr_No', $request->parent)->get(['Costcntr_No', 'Cmp_No', 'Level_No'])->first();
                $cmps = MainCompany::where('Cmp_No', $parent->Cmp_No)->get(['Cmp_No', 'Cmp_Nm'.ucfirst(session('lang'))])->first();
                $chart = MtsCostcntr::get(['Costcntr_Nm'.ucfirst(session('lang')), 'Costcntr_No']);
                $Costcntr_No = $this->createAccNo($parent->Costcntr_No);
                return view('admin.cc.create', ['title' => trans('admin.cc'),
                    'parent' => $parent, 'cmps' => $cmps, 'chart' => $chart, 'Costcntr_No' =>  $Costcntr_No,
                     ]);
            }

        }
    }

    public function initChartAcc(){
        if(session('Cmp_No') == -1){
            $cmps = MainCompany::get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
        }
        else{
            $cmps = MainCompany::where('Cmp_No', session('Cmp_No'))->get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No'])->first();
        }
        $Costcntr_No = $this->createAccNo(0);
        return view('admin.cc.create_main_chart', ['title' => trans('admin.cc')
            , 'cmps' => $cmps, 'Costcntr_No' => $Costcntr_No]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Department $department)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Department $department)
    {
        if($request->Level_Status == 0){
            $data = $this->validate($request,[
                'Cmp_No' => 'required',
                'Costcntr_Nmar' => 'required',
                'Costcntr_Nmen' => 'required',
            ],[],[
                'Cmp_No' => trans('admin.cmp_no'),
                'Costcntr_Nmar' => trans('admin.arabic_name'),
                'Costcntr_Nmen' => trans('admin.english_name'),
            ]);

            $chart = new MtsCostcntr;
            $chart->Cmp_No = $request->Cmp_No;
            $chart->Costcntr_Nmar = $request->Costcntr_Nmar;
            $chart->Costcntr_Nmen = $request->Costcntr_Nmen;
            $chart->Fbal_CR = $request->Fbal_CR;
            $chart->Fbal_DB = $request->Fbal_DB;
            $chart->Level_No = 1;
            $chart->Parnt_Acc = 0;
            $chart->Level_Status = 0;
//            $chart->User_Id = Auth::user()->id;
             $chart->Costcntr_No = $this->createAccNo($chart->Parnt_Acc);
//            $chart->Costcntr_No = $request->Costcntr_No;

            $chart->save();
            $chart->Updt_Time = $chart->updated_at;
            $chart->save();
            return redirect(aurl('cc'))->with(session()->flash('message',trans('admin.success_add')));
        }
        else if($request->Level_Status == 1){
            $data = $this->validate($request,[
                'Cmp_No' => 'required',
                'Costcntr_Nmar' => 'required',
                'Costcntr_Nmen' => 'required',

            ],[],[
                'Cmp_No' => trans('admin.cmp_no'),
                'Costcntr_Nmar' => trans('admin.arabic_name'),
                'Costcntr_Nmen' => trans('admin.english_name'),
            ]);

            // return $request;
            $chart = new MtsCostcntr;
            $chart->Cmp_No = $request->Cmp_No;
            $chart->Costcntr_Nmar = $request->Costcntr_Nmar;
            $chart->Costcntr_Nmen = $request->Costcntr_Nmen;
            $chart->Level_Status = $request->Level_Status;
            $parent = MtsCostcntr::where('Costcntr_No', $request->Parnt_Acc)->get(['Level_No'])->first();
            $chart->Level_No = $parent->Level_No + 1;
            $chart->Parnt_Acc = $request->Parnt_Acc;
            $chart->Fbal_DB = $request->Fbal_DB;
            $chart->Fbal_CR = $request->Fbal_CR;
//            $chart->User_Id = Auth::user()->id;
            // $chart->Costcntr_No = $this->createAccNo($chart->Parnt_Acc);
            $chart->Costcntr_No = $request->Costcntr_No;
            $chart->save();
//            $chart->Acc_Dt = $chart->created_at;
//            $chart->Acc_DtAr = date('Y-m-d',strtotime(\GeniusTS\HijriDate\Hijri::convertToHijri($chart->Acc_Dt)));
            $chart->Updt_Time = $chart->updated_at;
            $chart->save();
            $parent_level = MtsCostcntr::where('Costcntr_No', $request->Parnt_Acc)->first();
            if($parent_level){
                $parent_level->Level_Status = 0;
                $parent_level->save();
            }
            return redirect(aurl('cc'))->with(session()->flash('message',trans('admin.success_add')));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if($request->ajax()){
            $search = $request->search;
            if ($search != null){
                if ($search == 0){
                    $max_count = DB::table('cc')->max('level_id');
                    $contents = view('admin.cc.reports.show', compact('max_count','search'))->render();
                    return $contents;
                }
                if ($search == '1'){
                    $max_count = MtsCostcntr::where('type',1)->pluck('Costcntr_Nm'.session('lang'),'id');
                    $contents = view('admin.cc.reports.show', compact('max_count','search'))->render();
                    return $contents;
                }else{
                    $contents = view('admin.cc.reports.details',compact('search'))->render();
                    return $contents;
                }
            }

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $ccs = glcc::where('type','1')->pluck('name_'.session('lang'),'id');
        // $department = Department::findOrFail($id);
        // $parents = $department->parents->pluck('Costcntr_Nm'.session('lang'),'id');
        // $operations = operation::pluck('name_'.session('lang'),'id');
        // return view('admin.cc.edit',['title'=> trans('admin.edit_department') ,'department'=>$department,'parents'=>$parents,'operations'=>$operations,'ccs'=>$ccs]);
    }

    public function getEditBlade(Request $request){
        if($request->ajax()){
            if(session('Cmp_No') == -1){
                $cmps = MainCompany::get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
            }
            else{
                $cmps = MainCompany::where('Cmp_No', session('Cmp_No'))->get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
            }
            $chart = MtsCostcntr::get(['Costcntr_Nm'.ucfirst(session('lang')), 'Costcntr_No']);
            $chart_item =MtsCostcntr::where('Costcntr_No', $request->Costcntr_No)
                ->where('Cmp_No', session('Chart_Cmp_No'))
                ->first();
            $total = $this->getTotalTransaction($chart_item);
            return view('admin.cc.edit', ['title' => trans('admin.cc'),
                'chart' => $chart, 'cmps' => $cmps, 'chart_item' => $chart_item, 'total' => $total,
                ]);
        }
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

        $chart = MtsCostcntr::where('Costcntr_No', $id)->where('Cmp_No', session('Chart_Cmp_No'))->first();
        if($chart->Level_Status == 0){

            $data = $this->validate($request,[
                'Cmp_No' => 'required',
                'Costcntr_Nmar' => 'required',
                'Costcntr_Nmen' => 'sometimes',
            ],[],[
                'Cmp_No' => trans('admin.cmp_no'),
                'Costcntr_Nmar' => trans('admin.arabic_name'),
                'Costcntr_Nmen' => trans('admin.english_name'),
            ]);

            $chart->Cmp_No = $request->Cmp_No;
            $chart->Costcntr_Nmar = $request->Costcntr_Nmar;
            $chart->Costcntr_Nmen = $request->Costcntr_Nmen;
            $chart->Costcntr_No = $request->Costcntr_No;
            // $chart->Parnt_Acc = 0;
//            $chart->User_Id = Auth::user()->id;
            $chart->save();
//            $chart->Acc_Dt = $chart->created_at;
//            $chart->Acc_DtAr = date('Y-m-d',strtotime(\GeniusTS\HijriDate\Hijri::convertToHijri($chart->Acc_Dt)));
            $chart->Updt_Time = $chart->updated_at;
            $chart->save();
            return redirect(aurl('cc'))->with(session()->flash('message',trans('admin.success_update')));
        }
        else{
            $data = $this->validate($request,[
                'Cmp_No' => 'required',
                'Costcntr_Nmar' => 'required',
                'Costcntr_Nmen' => 'sometimes',

            ],[],[
                'Cmp_No' => trans('admin.cmp_no'),
                'Costcntr_Nmar' => trans('admin.arabic_name'),
                'Costcntr_Nmen' => trans('admin.english_name'),

            ]);

            $chart->Cmp_No = $request->Cmp_No;
            $chart->Costcntr_Nmar = $request->Costcntr_Nmar;
            $chart->Costcntr_Nmen = $request->Costcntr_Nmen;
//            $chart->Acc_Typ = $request->Acc_Typ;
            $chart->Fbal_DB = $request->Fbal_DB;
            $chart->Fbal_CR = $request->Fbal_CR;
//            $chart->User_Id = Auth::user()->id;
            $chart->save();
//            $chart->Acc_Dt = $chart->created_at;
//            $chart->Acc_DtAr = date('Y-m-d',strtotime(\GeniusTS\HijriDate\Hijri::convertToHijri($chart->Acc_Dt)));
            $chart->Updt_Time = $chart->updated_at;
            $chart->save();

            return redirect(aurl('cc'))->with(session()->flash('message',trans('admin.success_update')));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chart = MtsCostcntr::where('Costcntr_No', $id)->first();
        if(count($chart->children) > 0){
            return back()->with(session()->flash('error',trans('admin.chart_has_children')));
        }
        else{
            $chart->delete();
            return redirect(aurl('cc'))->with(session()->flash('message',trans('admin.success_deleted')));
        }
    }

    public function reports()
    {
        $title = trans('admin.cc_reports');
        return view('admin.cc.reports.index',compact('title'));
    }
    public function print()
    {

        $cc = Department::orderBy('code')->get();

        $config = ['instanceConfigurator' => function($mpdf) {
            $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
            );
        }];
        $pdf = Pdf::loadView('admin.cc.print', compact('cc'),[], $config);
        return $pdf->stream();
    }
    public function details(Request $request)
    {
        if($request->ajax()){
            $typeRange = $request->typeRange;
            $type = $request->type;
            if ($typeRange != null){
                $contents = view('admin.cc.reports.details', compact('typeRange', 'type'))->render();
                return $contents;

            }

            if ($type != null){

                $contents = view('admin.cc.reports.details', compact('typeRange', 'type'))->render();
                return $contents;
            }
        }
    }

    public function pdf(Request $request) {
        $typeRange = $request->typeRange;
        $type = $request->type;
        $search = $request->search;
        if ($search == 6){
            $cc = Department::where('cc_id','!=',null)->get();
            $config = ['instanceConfigurator' => function($mpdf) {
                $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                        <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                );
            }];
            $pdf = PDF::loadView('admin.cc.reports.pdf.report', compact('cc'), [], $config);
            return $pdf->stream();
        }
        if ($typeRange != null){
            $cc = Department::where('level_id',$typeRange)->get();
            $config = ['instanceConfigurator' => function($mpdf) {
                $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                        <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                );
            }];
            $pdf = PDF::loadView('admin.cc.reports.pdf.report', compact('cc'), [], $config);
            return $pdf->stream();
        }
        if ($type != null){
            $products = [];
            $cc = Department::where('id',$type)->get();
            while(count($cc) > 0){
                $nextCategories = [];
                foreach ($cc as $category) {
                    $products = array_merge($products, $category->children->all());
                    $nextCategories = array_merge($nextCategories, $category->children->all());
                }
                $cc = $nextCategories;
            }
            $config = ['instanceConfigurator' => function($mpdf) {
                $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                        <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                );
            }];
            $pdf = PDF::loadView('admin.cc.reports.pdf.report', compact('products'), [], $config);
            return $pdf->stream();
        }

        if ($search == '2'){
            $cc = Department::where('category','0')->get();
        }elseif ($search == '3'){
            $cc = Department::where('category','1')->get();
        }elseif ($search == '4'){
            $cc = Department::where('type','0')->get();
        }elseif ($search == '5'){
            $cc = Department::where('type','1')->get();
        }elseif ($search == '6'){
            $cc = glcc::where('type','1')->get();
            $config = ['instanceConfigurator' => function($mpdf) {
                $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                );
            }];
            $pdf = PDF::loadView('admin.cc.reports.pdf.cc', compact('cc'), [], $config);
            return $pdf->stream();
        }
        $config = ['instanceConfigurator' => function($mpdf) {
            $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
            );
        }];
        $pdf = PDF::loadView('admin.cc.reports.pdf.report', compact('cc'), [], $config);
        return $pdf->stream();
    }
    public function Review( )
    {

        $limitationReceipts = limitationReceipts::pluck('name_'.session('lang'),'id');
        $title = trans('admin.daily_report');
        return view('admin.cc.review',compact('limitationReceipts'));
    }

    public function reviewdepartment(Request $request)
    {
        $type = $request->type;
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        $limitations_1 = [];
        $limitations_2 = [];
        $limitations_3 = [];

        $receipts_1 = [];
        $receipts_2 = [];
        $receipts_3= [];
//dd(Costcntr_Nmar != name_ar);
        $limitations_1 = limitationsType::where('operation_id', '=', 4)
            ->where('limitations_type.tree_id', '=', \DB::raw('limitations_type.relation_id'))
            ->whereHas('cc', function ($qu) {

                $qu->where('Costcntr_Nmar', '!=', \DB::raw('limitations_type.name_ar'));
            })->whereHas('limitations',
                function ($q) use ($type) {

                    $q->where('limitationsType_id', '=', $type);
                })->get();

//dd($limitations_1);

        $limitations_2 = limitationsType::where('operation_id', '=', 4)->where('limitations_type.tree_id', '!=', \DB::raw('limitations_type.relation_id'))->whereHas('limitations',
            function ($query) use ($type) {
                $query->where('limitationsType_id', '=', $type);


            })->get();




        $Errorlimitations_3 = limitationsType::whereHas('limitations',
            function ($query) use ($type) {
                $query->where('limitationsType_id', '=', $type);


            })->get();

        foreach ($Errorlimitations_3 as $one) {

            if ($one->operation_id == 1) {
                $tree = supplier::where('id', $one->relation_id)->first()['tree_id'];

                $limitations_3 = limitationsType::where('operation_id', '=', 1)->where('tree_id', '!=', $tree)->whereHas('limitations',
                    function ($query) use ($type) {
                        $query->where('limitationsType_id', '=', $type);


                    })->get();

            } elseif ($one->operation_id == 3) {
                $tree = Project::where('id', $one->relation_id)->first()['tree_id'];

                $limitations_3 = limitationsType::where('operation_id', '=', 3)->where('tree_id', '!=', $tree)->whereHas('limitations',
                    function ($query) use ($type) {
                        $query->where('limitationsType_id', '=', $type);


                    })->get();

            } elseif ($one->operation_id == 5) {
                $tree = employee::where('id', $one->relation_id)->first()['tree_id'];

                $limitations_3 = limitationsType::where('operation_id', '=', 5)->where('tree_id', '!=', $tree)->whereHas('limitations',
                    function ($query) use ($type) {
                        $query->where('limitationsType_id', '=', $type);


                    })->get();

            } elseif ($one->operation_id == 10) {
                $tree = Contractors::where('id', $one->relation_id)->first()['tree_id'];

                $limitations_3 = limitationsType::where('operation_id', '=', 10)->where('tree_id', '!=', $tree)->whereHas('limitations',
                    function ($query) use ($type) {
                        $query->where('limitationsType_id', '=', $type);


                    })->get();


            }


        }
        $receipts_1 = receiptsType::where('operation_id', '=', 4)
            ->where('receipts_type.tree_id', '!=', \DB::raw('receipts_type.relation_id'))->whereHas('receipts',
                function ($query) use ($type) {
                    $query->where('receiptsType_id', '=', $type);


                })->get();


        $receipts_2 = receiptsType::where('operation_id', '=', 4)
            ->where('receipts_type.tree_id', '=', \DB::raw('receipts_type.relation_id'))
            ->whereHas('cc', function ($qu) {

                $qu->where('Costcntr_Nmar', '!=', \DB::raw('receipts_type.name_ar'));
            })->whereHas('receipts',
                function ($q) use ($type) {

                    $q->where('receiptsType_id', '=', $type);
                })->get();
//dd($receipts);




        $Errorreceipts_3 = receiptsType::whereHas('receipts',
            function ($query) use ($type) {
                $query->where('receiptsType_id', '=', $type);


            })->get();

        foreach ($Errorreceipts_3 as $one) {

            if ($one->operation_id == 1) {
                $tree = supplier::where('id', $one->relation_id)->first()['tree_id'];

                $receipts_3 = receiptsType::where('operation_id', '=', 1)->where('tree_id', '!=', $tree)->whereHas('receipts',
                    function ($query) use ($type) {
                        $query->where('receiptsType_id', '=', $type);


                    })->get();

            } elseif ($one->operation_id == 3) {
                $tree = Project::where('id', $one->relation_id)->first()['tree_id'];

                $receipts_3 = receiptsType::where('operation_id', '=', 3)->where('tree_id', '!=', $tree)->whereHas('receipts',
                    function ($query) use ($type) {
                        $query->where('receiptsType_id', '=', $type);


                    })->get();

            } elseif ($one->operation_id == 5) {
                $tree = employee::where('id', $one->relation_id)->first()['tree_id'];

                $receipts_3 = receiptsType::where('operation_id', '=', 5)->where('tree_id', '!=', $tree)->whereHas('receipts',
                    function ($query) use ($type) {
                        $query->where('receiptsType_id', '=', $type);


                    })->get();

            } elseif ($one->operation_id == 10) {
                $tree = Contractors::where('id', $one->relation_id)->first()['tree_id'];

                $receipts_3 = receiptsType::where('operation_id', '=', 10)->where('tree_id', '!=', $tree)->whereHas('receipts',
                    function ($query) use ($type) {
                        $query->where('receiptsType_id', '=', $type);


                    })->get();


            }


        }

        return view('admin.cc.ajax.error', compact('receipts_1','receipts_2','receipts_3', 'limitations_1', 'limitations_2', 'limitations_3'))->render();


    }

    //create new Costcntr_No
    public function createAccNo($Parnt_Acc){
        if($Parnt_Acc == 0){
            $chart = MtsCostcntr::where('Parnt_Acc', 0)->orderBy('Costcntr_No', 'desc')->get(['Costcntr_No'])->first();
            if($chart){
                $Costcntr_No = $chart->Costcntr_No + 1;
                return $Costcntr_No;
            }
            else{
                $Costcntr_No = 1;
                return $Costcntr_No;
            }
        }
        else{
            $parent = MtsCostcntr::where('Costcntr_No', $Parnt_Acc)->first();
            if(count($parent->children) > 0){
                $max = MtsCostcntr::where('Parnt_Acc', $parent->Costcntr_No)
                    ->where('Cmp_No', session('Chart_Cmp_No'))
                    ->orderBy('Costcntr_No', 'desc')->get(['Costcntr_No'])->first();
                return $max->Costcntr_No + 1;
            }
            else{
                $Costcntr_No = (int)$Parnt_Acc.'01';
                return $Costcntr_No;
            }

        }
    }

    public function getTotalTransaction($chart){
        // اجمالى الحركة مدين
        $total_debit = $chart->DB11 + $chart->DB12 + $chart->DB13 + $chart->DB14 + $chart->DB15 + $chart->DB16
            + $chart->DB17 + $chart->DB18 + $chart->DB19 + $chart->DB20 + $chart->DB21 + $chart->DB22;

        // اجمالى الحركه دائن
        $total_credit = $chart->CR11 + $chart->CR12 + $chart->CR13 + $chart->CR14 + $chart->CR15 + $chart->CR16
            + $chart->CR17 + $chart->CR18 + $chart->CR19 + $chart->CR20 + $chart->CR21 + $chart->CR22;

        // اجمالى الرصيد
        $total_balance = ($chart->Fbal_DB - $chart->Fbal_CR) + ($total_debit - $total_credit);

        $total[] = (object) array('total_debit' => $total_debit,
            'total_credit' => $total_credit,
            'total_balance' => $total_balance);
        return $total;
    }

    public function getCc(Request $request){
        if($request->ajax()){
            session(['Chart_Cmp_No' => $request->Cmp_No]);
            $tree = load_cc('Parnt_Acc', null, $request->Cmp_No);
            return $tree;
        }
    }

}

