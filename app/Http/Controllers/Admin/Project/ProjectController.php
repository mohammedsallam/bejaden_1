<?php

namespace App\Http\Controllers\Admin\project;


use App\Branches;

use App\city;
use App\Contractors;

use App\employee;
use App\Department;
use App\glcc;
use App\limitations;
use App\Http\Controllers\Controller;
use App\levels;
use App\limitationReceipts;
use App\limitationsType;
use App\Models\Admin\MainBranch;
use App\operation;
use App\pjitmmsfl;
use App\receipts;
use App\receiptsData;
use App\receiptsType;
use App\supplier;
//use App\Models\Admin\Projectmfs;
use App\Models\Admin\MtsClosAcc;
use App\Models\Admin\MainCompany;
use App\Models\Admin\Projectmfs;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Up;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chart = Projectmfs::get(['Prj_Nm'.ucfirst(session('lang')), 'Prj_No']);
        if(count($chart) > 0){
            if(session('Cmp_No') == -1){
                $cmps = MainCompany::get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
            }
            else{
                $cmps = MainCompany::where('Cmp_No', session('Cmp_No'))->get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No'])->first();
            }
            $chart_item = Projectmfs::first();
            $total = $this->getTotalTransaction($chart_item);
            $children = [];
            return view('admin.projects.index', ['title' => trans('admin.projects'),
                'cmps' => $cmps, 'chart_item' => $chart_item, 'total' => $total, 'children' => $children]);
        }
        else{
            if(session('Cmp_No') == -1){
                $cmps = MainCompany::get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
            }
            else{
                $cmps = MainCompany::where('Cmp_No', session('Cmp_No'))->get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No'])->first();
            }
            $Prj_No = $this->createPrjNo(0);
            return view('admin.projects.init_chart', ['title' => trans('admin.projects')
                , 'cmps' => $cmps, 'Prj_No' => $Prj_No]);

        }

    }

    public function createNewPrj(Request $request){
//dd($request->all());
        if($request->ajax()){
            if($request->parent){
                $parent = Projectmfs::where('Prj_No', $request->parent)
                    ->where('Cmp_No', session('Chart_Cmp_No'))
                    ->get(['Prj_No', 'Cmp_No', 'Level_No', 'Prj_Parnt'])
                    ->first();
                $cmps = MainCompany::where('Cmp_No', $parent->Cmp_No)->get(['Cmp_No', 'Cmp_Nm'.ucfirst(session('lang'))])->first();
                $chart = Projectmfs::get(['Prj_Nm'.ucfirst(session('lang')), 'Prj_No']);
               // $balances = MtsClosAcc::where('Main_Rpt', 1)->get(['CLsacc_Nm'.ucfirst(session('lang')), 'CLsacc_No']);
               // $incomes = MtsClosAcc::where('Main_Rpt', 2)->get(['CLsacc_Nm'.ucfirst(session('lang')), 'CLsacc_No']);
               // dd($parent->Prj_Parnt);
                $Prj_No = $this->createPrjNo($parent->Prj_No);
                //dd($Prj_No);
                //dd($request->Level_No);
                return view('admin.projects.create', ['title' => trans('admin.projects'),
                    'parent' => $parent, 'cmps' => $cmps, 'chart' => $chart, 'Prj_No' =>  $Prj_No]);
            }
        }
    }

    public function initChartPrj(){
        if(session('Cmp_No') == -1){
            $cmps = MainCompany::get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
        }
        else{
            $cmps = MainCompany::where('Cmp_No', session('Cmp_No'))->get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No'])->first();
        }
        $Prj_No = $this->createPrjNo(0);
        return view('admin.projects.create_main_chart', ['title' => trans('admin.projects')
            , 'cmps' => $cmps, 'Prj_No' => $Prj_No]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }


    public function store(Request $request)
    {
        dd($request->all());
        //dd($request->Level_No);
        if($request->Level_Status == 0){
            $data = $this->validate($request,[
                //'Cmp_No' => 'required',
                'Prj_NmAr' => 'sometimes',
                'Prj_NmEn' => 'sometimes',
            ],[],[
                //'Cmp_No' => trans('admin.cmp_no'),
                'Prj_NmAr' => trans('admin.project_name'),
                'Prj_NmEn' => trans('admin.project_name_en'),
            ]);
            //dd($request->all());
            $chart = new Projectmfs;
            $chart->Cmp_No = $request->Cmp_No;
            $chart->Prj_NmAr = $request->Prj_NmAr;
            $chart->Prj_NmEn = $request->Prj_NmEn;
            $chart->Level_Status = $request->Level_Status;
            $chart->Level_No = 1;
            $chart->Prj_Parnt = 0;
            $chart->User_ID = Auth::user()->id;
            $chart->Prj_No = $request->Prj_No;
            $chart->save();
            $chart->Tr_Dt = $chart->created_at;
            $chart->Tr_DtAr = date('Y-m-d',strtotime(\GeniusTS\HijriDate\Hijri::convertToHijri($chart->Tr_Dt)));
            $chart->Opn_Date = $chart->updated_at;
            $chart->save();
            //dd($chart);
            return redirect(aurl('projects'))->with(session()->flash('message',trans('admin.success_add')));
        }
        else if($request->Level_Status == 1){
            $data = $this->validate($request,[
                //'Cmp_No' => 'required',
                'Prj_NmAr' => 'sometimes',
                'Prj_NmEn' => 'sometimes',
                'Prj_Status' => 'sometimes',
                'Level_Status' => 'sometimes',
                //'Acc_Ntr' => 'required',
            ],[],[
                //'Cmp_No' => trans('admin.cmp_no'),
                'Prj_NmAr' => trans('admin.project_name'),
                'Prj_NmEn' => trans('admin.project_name_en'),
                'Prj_Status' => trans('admin.Prj_Status'),
                'Level_Status' => trans('admin.Level_Status'),
                //'Acc_Ntr' => trans('admin.category')
            ]);

            //dd($request->parent);
            $chart = new Projectmfs;
            $chart->Cmp_No = $request->Cmp_No;
            $chart->Prj_NmAr = $request->Prj_NmAr;
            $chart->Prj_NmEn = $request->Prj_NmEn;
            $chart->Level_Status = $request->Level_Status;
            //dd($request->parent);
            $parent = Projectmfs::where('Prj_No', $request->Prj_Parnt)->get(['Level_No'])->first();

            //dd($parent);
            $chart->Level_No = $parent->Level_No + 1;
            //$chart->Level_No = $chart->Level_No + 1;
            $chart->Prj_Parnt = $request->Prj_Parnt;
            $chart->Prj_Status = $request->Prj_Status;
            $chart->Costcntr_No = $request->Costcntr_No;  //مركز التكلفه
            $chart->Prj_Actv = $request->Prj_Actv;
            //$chart->Cr_Blnc = $request->Cr_Blnc;
            //$chart->Acc_Ntr = $request->Acc_Ntr;
            $chart->Fbal_DB = $request->Fbal_DB;
            $chart->Fbal_CR = $request->Fbal_CR;
            $chart->User_Id = Auth::user()->id;
            // $chart->Acc_No = $this->createAccNo($chart->Parnt_Acc);
            $chart->Prj_No = $request->Prj_No;
            $chart->save();
            $chart->Tr_Dt = $chart->created_at;
            $chart->Tr_DtAr = date('Y-m-d',strtotime(\GeniusTS\HijriDate\Hijri::convertToHijri($chart->Tr_Dt)));
            $chart->Updt_Date = $chart->updated_at;
            $chart->save();
            $parent_level = Projectmfs::where('Prj_No', $request->Prj_Parnt)->first();
            if($parent_level){
                $parent_level->Level_Status = 0;
                $parent_level->save();
            }

            return redirect(aurl('projects'))->with(session()->flash('message',trans('admin.success_add')));
        }
    }

    public function show(Request $request)
    {
        if($request->ajax()){
            $search = $request->search;
            if ($search != null){
                if ($search == 0){
                    $max_count = DB::table('projectmfs')->max('Level_No');
                    $contents = view('admin.projects.reports.show', compact('max_count','search'))->render();
                    return $contents;
                }
                if ($search == '1'){
                    $max_count = Projectmfs::where('type',1)->pluck('dep_name_'.session('lang'),'id');
                    $contents = view('admin.projects.reports.show', compact('max_count','search'))->render();
                    return $contents;
                }else{
                    $contents = view('admin.projects.reports.details',compact('search'))->render();
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
        // $parents = $department->parents->pluck('dep_name_'.session('lang'),'id');
        // $operations = operation::pluck('name_'.session('lang'),'id');
        // return view('admin.departments.edit',['title'=> trans('admin.edit_department') ,'department'=>$department,'parents'=>$parents,'operations'=>$operations,'ccs'=>$ccs]);
    }

    public function getEditBlade(Request $request){
        if($request->ajax()){
            if(session('Cmp_No') == -1){
                $cmps = MainCompany::get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
            }
            else{
                $cmps = MainCompany::where('Cmp_No', session('Cmp_No'))->get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
            }
            $balances = MtsClosAcc::where('Main_Rpt', 1)->get(['CLsacc_Nm'.ucfirst(session('lang')), 'CLsacc_No']);
            $incomes = MtsClosAcc::where('Main_Rpt', 2)->get(['CLsacc_Nm'.ucfirst(session('lang')), 'CLsacc_No']);
            $chart = Projectmfs::get(['Prj_Nm'.ucfirst(session('lang')), 'Prj_No']);
            $chart_item =Projectmfs::where('Prj_No', $request->Prj_No)
                ->where('Cmp_No', session('Chart_Cmp_No'))
                ->first();
            $total = $this->getTotalTransaction($chart_item);
            return view('admin.projects.edit', ['title' => trans('admin.projects'),
                'chart' => $chart, 'cmps' => $cmps, 'chart_item' => $chart_item, 'total' => $total,
                'balances' => $balances, 'incomes' => $incomes, 'children' => $request->children]);
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
        //dd($request->Level_No);
        $chart = Projectmfs::where('Prj_No', $id)
                           ->where('Cmp_No', session('Chart_Cmp_No'))
                           ->first();
        //dd($chart);
        // if($chart->Level_Status == 0){

        if($chart->Level_No == 1){
            $data = $this->validate($request,[
                //'Cmp_No' => 'required',
                'Prj_NmAr' => 'required',
                'Prj_NmEn' => 'sometimes',
            ],[],[
                //'Cmp_No' => trans('admin.cmp_no'),
                'Prj_NmAr' => trans('admin.project_name'),
                'Prj_NmEn' => trans('admin.project_name_en'),
            ]);

            $chart->Cmp_No   = $request->Cmp_No;
            $chart->Prj_NmAr = $request->Prj_NmAr;
            $chart->Prj_NmEn = $request->Prj_NmEn;
            $chart->Prj_No   = $request->Prj_No;
            // $chart->Parnt_Acc = 0;
            $chart->User_ID  = Auth::user()->id;
            $chart->save();
            $chart->Tr_Dt = $chart->created_at;
            $chart->Tr_DtAr = date('Y-m-d',strtotime(\GeniusTS\HijriDate\Hijri::convertToHijri($chart->Tr_Dt)));
            $chart->Updt_Date = $chart->updated_at;
            $chart->save();

            $children = $child = Projectmfs::where('Prj_No', 'LIKE '.$chart->Prj_No.'%')->get(['Cmp_No']);
            // return $children;


            if($request->children){
                if(count($request->children) > 0){
                    foreach($request->children as $prj_no){
                        $child = Projectmfs::where('Prj_No', $prj_no)->first()->update(['Cmp_No' => $request->Cmp_No]);
                    }
                }
            }
            return redirect(aurl('projects'))->with(session()->flash('message',trans('admin.success_update')));
        }
        else{
            $data = $this->validate($request,[
                //'Cmp_No' => 'required',
                'Prj_NmAr' => 'required',
                'Prj_NmEn' => 'sometimes',
                'Acc_Typ' => 'sometimes',
                'Level_Status' => 'sometimes',
                //'Acc_Ntr' => 'required',
            ],[],[
                'Cmp_No' => trans('admin.cmp_no'),
                'Prj_NmAr' => trans('admin.project_name'),
                'Prj_NmEn' => trans('admin.project_name_en'),
                'Acc_Typ' => trans('admin.account_type'),
                'Level_Status' => trans('admin.project_type'),
                //'Acc_Ntr' => trans('admin.category')
            ]);

            $chart->Cmp_No = $request->Cmp_No;
            $chart->Prj_NmAr = $request->Prj_NmAr;
            $chart->Prj_NmEn = $request->Prj_NmEn;
            // $chart->Level_Status = $request->Level_Status;
            // return $request->Parnt_Acc;
            // $parent = MtsChartAc::where('Acc_No', $request->Parnt_Acc)->get(['Level_No'])->first();
            // $chart->Level_No = $parent->Level_No + 1;
            // $chart->Parnt_Acc = $request->Parnt_Acc;
            //$chart->Acc_Typ = $request->Acc_Typ;
            $chart->Costcntr_No = $request->Costcntr_No;
            $chart->Prj_Actv = $request->Prj_Actv;
            //$chart->Cr_Blnc = $request->Cr_Blnc;
            //$chart->Acc_Ntr = $request->Acc_Ntr;
            $chart->Fbal_DB = $request->Fbal_DB;
            $chart->Fbal_CR = $request->Fbal_CR;
            $chart->User_ID = Auth::user()->id;
            $chart->save();
            $chart->Tr_Dt = $chart->created_at;
            $chart->Tr_DtAr = date('Y-m-d',strtotime(\GeniusTS\HijriDate\Hijri::convertToHijri($chart->Tr_Dt)));
            $chart->Updt_Date = $chart->updated_at;
            $chart->save();

            if($request->children){
                if(count($request->children) > 0){
                    foreach($request->children as $prj_no){
                        $child = Projectmfs::where('Prj_No', $prj_no)->first()->update(['Cmp_No' => $request->Cmp_No]);
                    }
                }
            }

            return redirect(aurl('projects'))->with(session()->flash('message',trans('admin.success_update')));
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
        $chart = Projectmfs::where('Prj_No', $id)->first();
        if(count($chart->children) > 0){
            return back()->with(session()->flash('error',trans('admin.chart_has_children')));
        }
        else{
            $chart->delete();
            return redirect(aurl('projects'))->with(session()->flash('message',trans('admin.success_deleted')));
        }
    }

    public function reports()
    {
        $title = trans('admin.Departments_reports');
        return view('admin.projects.reports.index',compact('title'));
    }
    public function print()
    {

//        $departments = sumdepartment(15);
        $departments = Department::orderBy('code')->get();

//        dd($departments);
        $config = ['instanceConfigurator' => function($mpdf) {
            $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
            );
        }];
        $pdf = Pdf::loadView('admin.departments.print', compact('departments'),[], $config);
        return $pdf->stream();
    }
    public function details(Request $request)
    {
        if($request->ajax()){
            $typeRange = $request->typeRange;
            $type = $request->type;
            if ($typeRange != null){
                $contents = view('admin.departments.reports.details', compact('typeRange', 'type'))->render();
                return $contents;

            }

            if ($type != null){

                $contents = view('admin.departments.reports.details', compact('typeRange', 'type'))->render();
                return $contents;
            }
        }
    }

    public function pdf(Request $request) {
        $typeRange = $request->typeRange;
        $type = $request->type;
        $search = $request->search;
        if ($search == 6){
            $departments = Department::where('cc_id','!=',null)->get();
            $config = ['instanceConfigurator' => function($mpdf) {
                $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                        <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                );
            }];
            $pdf = PDF::loadView('admin.departments.reports.pdf.report', compact('departments'), [], $config);
            return $pdf->stream();
        }
        if ($typeRange != null){
            $departments = Department::where('level_id',$typeRange)->get();
            $config = ['instanceConfigurator' => function($mpdf) {
                $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                        <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                );
            }];
            $pdf = PDF::loadView('admin.departments.reports.pdf.report', compact('departments'), [], $config);
            return $pdf->stream();
        }
        if ($type != null){
            $products = [];
            $departments = Department::where('id',$type)->get();
            while(count($departments) > 0){
                $nextCategories = [];
                foreach ($departments as $category) {
                    $products = array_merge($products, $category->children->all());
                    $nextCategories = array_merge($nextCategories, $category->children->all());
                }
                $departments = $nextCategories;
            }
            $config = ['instanceConfigurator' => function($mpdf) {
                $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                        <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                );
            }];
            $pdf = PDF::loadView('admin.departments.reports.pdf.report', compact('products'), [], $config);
            return $pdf->stream();
        }

        if ($search == '2'){
            $departments = Department::where('category','0')->get();
        }elseif ($search == '3'){
            $departments = Department::where('category','1')->get();
        }elseif ($search == '4'){
            $departments = Department::where('type','0')->get();
        }elseif ($search == '5'){
            $departments = Department::where('type','1')->get();
        }elseif ($search == '6'){
            $departments = glcc::where('type','1')->get();
            $config = ['instanceConfigurator' => function($mpdf) {
                $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                );
            }];
            $pdf = PDF::loadView('admin.departments.reports.pdf.cc', compact('departments'), [], $config);
            return $pdf->stream();
        }
        $config = ['instanceConfigurator' => function($mpdf) {
            $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
            );
        }];
        $pdf = PDF::loadView('admin.departments.reports.pdf.report', compact('departments'), [], $config);
        return $pdf->stream();
    }
    public function Review( )
    {
//        $operations = operation::whereIn('receipt',[1,2])->pluck('name_'.session('lang'),'id');
//        $branches = Branches::pluck('name_'.session('lang'),'id');
        $limitationReceipts = limitationReceipts::pluck('name_'.session('lang'),'id');
        $title = trans('admin.daily_report');
        return view('admin.departments.review',compact('limitationReceipts'));
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
//dd(dep_name_ar != name_ar);
        $limitations_1 = limitationsType::where('operation_id', '=', 4)
            ->where('limitations_type.tree_id', '=', \DB::raw('limitations_type.relation_id'))
            ->whereHas('departments', function ($qu) {

                $qu->where('dep_name_ar', '!=', \DB::raw('limitations_type.name_ar'));
            })->whereHas('limitations',
                function ($q) use ($type) {

                    $q->where('limitationsType_id', '=', $type);
                })->get();

//dd($limitations_1);

        $limitations_2 = limitationsType::where('operation_id', '=', 4)->where('limitations_type.tree_id', '!=', \DB::raw('limitations_type.relation_id'))->whereHas('limitations',
            function ($query) use ($type) {
                $query->where('limitationsType_id', '=', $type);


            })->get();


//        $limitations_2 = limitationsType::where('operation_id', '=', 4)->where('limitations_type.tree_id', '!=', \DB::raw('limitations_type.relation_id'))->whereHas('limitations',
//            function ($query) use ($type) {
//                $query->where('limitationsType_id', '=', $type);
//
//
//            })->get();

//dd(tree_id  != relation_id);


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
            ->whereHas('departments', function ($qu) {

                $qu->where('dep_name_ar', '!=', \DB::raw('receipts_type.name_ar'));
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

        return view('admin.departments.ajax.error', compact('receipts_1','receipts_2','receipts_3', 'limitations_1', 'limitations_2', 'limitations_3'))->render();


    }

    //create new Acc_No
    public function createPrjNo($Prj_Parnt){
        if($Prj_Parnt == 0){
            $chart = Projectmfs::where('Prj_Parnt', 0)->orderBy('Prj_No', 'desc')->get(['Prj_No'])->first();
            if($chart){
                $Prj_No = $chart->Prj_No + 1;
                return $Prj_No;
            }
            else{
                $Prj_No = 1;
                return $Prj_No;
            }
        }
        else{
            $parent = Projectmfs::where('Prj_No', $Prj_Parnt)->first();
            if(count($parent->children) > 0){
                $max = Projectmfs::where('Prj_Parnt', $parent->Prj_No)
                    ->where('Cmp_No', session('Chart_Cmp_No'))
                    ->orderBy('Prj_No', 'desc')->get(['Prj_No'])->first();
                return $max->Prj_No + 1;
            }
            else{
                $Prj_No = (int)$Prj_Parnt.'01';
                return $Prj_No;
            }
            // $chart = Projectmfs::where('Parnt_Acc', $Parnt_Acc)->orderBy('Acc_No', 'desc')->get(['Acc_No'])->first();
            // if($chart){
            //     $index = explode('0', $chart->Acc_No);
            //     $counter = (int)$index[count($index)-1] + 1;
            //     $Acc_No = (int)$Parnt_Acc.'0'.$counter;
            //     return $Acc_No;
            // }
            // else{
            //     $Acc_No = (int)$Parnt_Acc.'01';
            //     return $Acc_No;
            // }
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
    public function getTree(Request $request){
        if($request->ajax()){
            session(['Chart_Cmp_No' => $request->Cmp_No]);
            $tree = load_prj('parent_id', null, $request->Cmp_No);
            return $tree;
        }
    }


    public function getBranches(Request $request)
    {

        $branches = MainBranch::where('Cmp_No', $request->Cmp_No)->get();


        return view('admin.projects.get_branches', compact('branches'));
    }

}

