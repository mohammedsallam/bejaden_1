<?php

namespace App\Http\Controllers\Admin\Department;


use App\Branches;
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
use App\Models\Admin\MtsChartAc;
use App\Models\Admin\MainCompany;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Up;


class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Department $department)
    {
        if(session('Cmp_No') == -1){
            $cmps = MainCompany::get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
        }
        else{
            $cmps = MainCompany::where('Cmp_No', session('Cmp_No'))->get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
        }
        $chart = MtsChartAc::get(['Acc_Nm'.ucfirst(session('lang')), 'Acc_No']);
        return view('admin.departments.index', ['title' => trans('admin.Departments'), 
                    'chart' => $chart, 'cmps' => $cmps]);
        // return view('admin.departments.index',['title'=> trans('admin.Departments'),'department'=>$department]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Department $department)
    {   
        // if(session('Cmp_No') == -1){
        //     $cmps = MainCompany::get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
        // }
        // else{
        //     $cmps = MainCompany::where('Cmp_No', session('Cmp_No'))->get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
        // }
        // $chart = MtsChartAc::pluck('Acc_Nm'.ucfirst(session('lang')), 'ID_No');
        // return view('admin.departments.create', ['title' => trans('admin.create_new_department'), 
        //             'chart' => $chart, 'cmps' => $cmps]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Department $department)
    {
        $data = $this->validate($request,[
            'Cmp_No' => 'required',
            'Acc_NmAr' => 'required',
            'Acc_NmEn' => 'sometimes',
            'Acc_Typ' => 'sometimes',
            'Level_Status' => 'required',
            'Acc_Ntr' => 'required',
        ],[],[
            'Cmp_No' => trans('admin.cmp_no'),
            'Acc_NmAr' => trans('admin.arabic_name'),
            'Acc_NmEn' => trans('admin.english_name'),
            'Acc_Typ' => trans('admin.account_type'),
            'Level_Status' => trans('admin.department_type'),
            'Acc_Ntr' => trans('admin.category')
        ]);

        $chart = new MtsChartAc;
        $chart->Cmp_No = $request->Cmp_No;
        $chart->Acc_NmAr = $request->Acc_NmAr;
        $chart->Acc_NmEn = $request->Acc_NmEn;
        $chart->Level_Status = $request->Level_Status;
        if($request->Level_Status == 0){
            $chart->Level_No = 1;
            $chart->Parnt_Acc = 0;
        }
        else{
            $parent = MtsChartAc::where('Acc_No', $request->Parnt_Acc)->get(['Level_No'])->first();
            $chart->Level_No = $parent->Level_No + 1;
            $chart->Parnt_Acc = $request->Parnt_Acc;
        }
        $chart->Acc_Typ = $request->Acc_Typ;
        if($request->Clsacc_No == 0){
            $chart->Clsacc_No1 = $request->Clsacc_No;
        }
        else if($request->Clsacc_No == 1){
            $chart->Clsacc_No2 = $request->Clsacc_No;
        }
        else if($request->Clsacc_No == 2){
            $chart->Clsacc_No3 = $request->Clsacc_No;
        }
        $chart->Acc_Ntr = $request->Acc_Ntr;
        $chart->Fbal_DB = $request->Fbal_DB;
        $chart->Fbal_CR = $request->Fbal_CR;
        $chart->User_Id = Auth::user()->id;

        $chart->Acc_No = $this->createAccNo($chart->Level_No, $chart->Parnt_Acc);
        $chart->save();
        $chart->Acc_Dt = $chart->created_at;
        $chart->Acc_DtAr = date('Y-m-d',strtotime(\GeniusTS\HijriDate\Hijri::convertToHijri($chart->Acc_Dt)));
        $chart->Updt_Time = $chart->updated_at;
        $chart->save();
        
        return redirect(aurl('departments'))->with(session()->flash('message',trans('admin.success_add')));

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
                    $max_count = DB::table('departments')->max('level_id');
                    $contents = view('admin.departments.reports.show', compact('max_count','search'))->render();
                    return $contents;
                }
                if ($search == '1'){
                    $max_count = Department::where('type',1)->pluck('dep_name_'.session('lang'),'id');
                    $contents = view('admin.departments.reports.show', compact('max_count','search'))->render();
                    return $contents;
                }else{
                    $contents = view('admin.departments.reports.details',compact('search'))->render();
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
        $ccs = glcc::where('type','1')->pluck('name_'.session('lang'),'id');
        $department = Department::findOrFail($id);
        $parents = $department->parents->pluck('dep_name_'.session('lang'),'id');
        $operations = operation::pluck('name_'.session('lang'),'id');
        return view('admin.departments.edit',['title'=> trans('admin.edit_department') ,'department'=>$department,'parents'=>$parents,'operations'=>$operations,'ccs'=>$ccs]);
    }

    public function getEditBlade(Request $request){
       if($request->ajax()){
            if(session('Cmp_No') == -1){
                $cmps = MainCompany::get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
            }
            else{
                $cmps = MainCompany::where('Cmp_No', session('Cmp_No'))->get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
            }
            $chart = MtsChartAc::get(['Acc_Nm'.ucfirst(session('lang')), 'Acc_No']);
            $chart_item = MtsChartAc::where('Acc_No', $request->Acc_No)->first();
            return view('admin.departments.edit', ['title' => trans('admin.Departments'), 
                        'chart' => $chart, 'cmps' => $cmps, 'chart_item' => $chart_item]);
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
        $data = $this->validate($request,[
            'Cmp_No' => 'required',
            'Acc_NmAr' => 'required',
            'Acc_NmEn' => 'sometimes',
            'Acc_Typ' => 'sometimes',
            'Level_Status' => 'required',
            'Acc_Ntr' => 'required',
        ],[],[
            'Cmp_No' => trans('admin.cmp_no'),
            'Acc_NmAr' => trans('admin.arabic_name'),
            'Acc_NmEn' => trans('admin.english_name'),
            'Acc_Typ' => trans('admin.account_type'),
            'Level_Status' => trans('admin.department_type'),
            'Acc_Ntr' => trans('admin.category')
        ]);

        $chart = MtsChartAc::where('Acc_No', $id)->first();
        $chart->Cmp_No = $request->Cmp_No;
        $chart->Acc_NmAr = $request->Acc_NmAr;
        $chart->Acc_NmEn = $request->Acc_NmEn;
        $chart->Level_Status = $request->Level_Status;
        if($request->Level_Status == 0){
            $chart->Level_No = 1;
            $chart->Parnt_Acc = 0;
        }
        else{
            $parent = MtsChartAc::where('Acc_No', $request->Parnt_Acc)->get(['Level_No'])->first();
            $chart->Level_No = $parent->Level_No + 1;
            $chart->Parnt_Acc = $request->Parnt_Acc;
        }
        $chart->Acc_Typ = $request->Acc_Typ;
        if($request->Clsacc_No == 0){
            $chart->Clsacc_No1 = $request->Clsacc_No;
        }
        else if($request->Clsacc_No == 1){
            $chart->Clsacc_No2 = $request->Clsacc_No;
        }
        else if($request->Clsacc_No == 2){
            $chart->Clsacc_No3 = $request->Clsacc_No;
        }
        $chart->Acc_Ntr = $request->Acc_Ntr;
        $chart->Fbal_DB = $request->Fbal_DB;
        $chart->Fbal_CR = $request->Fbal_CR;
        $chart->User_Id = Auth::user()->id;

        $chart->Acc_Dt = $chart->created_at;
        $chart->Acc_DtAr = date('Y-m-d',strtotime(\GeniusTS\HijriDate\Hijri::convertToHijri($chart->Acc_Dt)));
        $chart->Updt_Time = $chart->updated_at;
        $chart->save();
        
        return redirect(aurl('departments'))->with(session()->flash('message',trans('admin.success_update')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chart = MtsChartAc::where('Acc_No', $id)->first();
        if(count($chart->children) > 0){
            return back()->with(session()->flash('error',trans('admin.chart_has_children')));
        }
        else{
            $chart->delete();
            return redirect(aurl('departments'))->with(session()->flash('message',trans('admin.success_deleted')));
        }
    }

    public function reports()
    {
        $title = trans('admin.Departments_reports');
        return view('admin.departments.reports.index',compact('title'));
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
     public function createAccNo($Level_No, $Parnt_Acc){
        if($Parnt_Acc == 0){
            $chart = MtsChartAc::where('Parnt_Acc', 0)->orderBy('Acc_No', 'desc')->get(['Acc_No'])->first();
            if($chart){
                $Acc_No = $chart->Acc_No + 1;
                return $Acc_No;
            }
            else{
                $Acc_No = 1;
                return $Acc_No;
            }
        }
        else{
            $parent = MtsChartAc::where('Acc_No', $Parnt_Acc)->first(); 
            if(count($parent->children) > 0){
                $max = MtsChartAc::where('Parnt_Acc', $parent->Acc_No)->orderBy('Acc_No', 'desc')->get(['Acc_No'])->first();
                return $max->Acc_No + 1;
            }
            else{
                $Acc_No = (int)$Parnt_Acc.'01';
                return $Acc_No;
            }
            // $chart = MtsChartAc::where('Parnt_Acc', $Parnt_Acc)->orderBy('Acc_No', 'desc')->get(['Acc_No'])->first();
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
        
    }

}

